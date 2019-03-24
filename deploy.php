<?php

namespace Deployer;

require_once 'recipe/typo3.php';

use Symfony\Component\Yaml\Yaml;
use Deployer\Host\Host;
use Deployer\Host\Localhost;


set('keep_releases', 3);
set('typo3_webroot', 'web');
set('clear_use_sudo', false);
set('writable_use_sudo', false);
set('writable_mode', 'chmod');
set('writable_chmod_mode', '0775');
set('writable_chmod_recursive', false);
set('ssh_type', 'native');


/**
 * Shared files
 */
set('shared_files', [
    '.env_deploy',
]);

set('shared_dirs', [
    '{{typo3_webroot}}/fileadmin',
    '{{typo3_webroot}}/uploads',
    '{{typo3_webroot}}/typo3temp',
]);

set('writable_dirs', [
    '{{typo3_webroot}}/typo3temp',
    '{{typo3_webroot}}/typo3conf',
    '{{typo3_webroot}}/uploads',
    'cache'
]);

// load servers
if (getenv('DEPLOYER_SERVERS')) {
    inventoryString(getenv('DEPLOYER_SERVERS'));
} else if (file_exists('servers.yml')) {
    inventory('servers.yml');
}

task('deploy', [
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:symlink',
    'deploy:writable',
    'deploy:unlock',
    'cleanup',
])->desc('Deploy your project');

//    'deploy:db:update',
//    'deploy:cache:clear',

// override update code
task('deploy:update_code', function () {
    upload('build.tar.gz', '{{release_path}}/build.tar.gz');
    run('cd {{release_path}} && tar -xzf {{release_path}}/build.tar.gz --strip 1 && rm {{release_path}}/build.tar.gz');
});

//update db
task('deploy:db:update', function() {
    run('php {{deploy_path}}/current/vendor/bin/typo3cms database:updateschema "*.add,*.change"');
})->desc('Update DB');

// delete cache
task('deploy:cache:clear', function() {
    run('php {{deploy_path}}/current/vendor/bin/typo3cms cache:flush');
    run('php {{deploy_path}}/current/vendor/bin/typo3cms cache:flushgroups pages');
})->desc('Clear all TYPO3 caches');


task('dump', [
    'dump:db',
    'dump:assets',
])->desc('Dump data and database');

// dump db
task('dump:db', function () {
    $dump_active = has('active_dump')? get('active_dump') : '0';
    if($dump_active == "1") {
        run('{{dump_db_command}}');
    } else {
        run("echo dump db do not started");
    }
})->desc('Dump db');

// dump data
task('dump:assets', function () {
    $dump_active = has('active_dump')? get('active_dump') : '0';
    if($dump_active == "1") {
        run('cd {{deploy_path}}/shared && tar --exclude=\'web/typo3temp\' -czf web.tar.gz web');
    } else {
        run("echo dump assets do not started");
    }
})->desc('Dump assets');


task('sync', [
    'sync:db',
    'sync:assets',
    'deploy:cache:opcache_clear',
    'deploy:cache:clear',
])->desc('sync data and database');

// sync db
task('sync:db', function () {
    if(has('fetch_db_command')) {
        // fetch db from live (path is defined)
        runLocally('{{fetch_db_command}}');
        // upload dump.sql.gz to server
        upload('dump.sql.gz', 'dump.sql.gz');
        run('gunzip -f dump.sql.gz');
        // execute dump.sql.gz
        run('{{mysql_import_db_command}}');
        // execute after sync sql
        run('{{mysql_import_db_extra_command}}');
    }
})->desc('Sync db');

// sync db
task('sync:assets', function () {
    if(has('fetch_assets_command')) {
        // fetch db from live (path is defined)
        runLocally('{{fetch_assets_command}}');
        // upload web.tar.gz to server
        upload('web.tar.gz', '{{deploy_path}}/shared/web.tar.gz');
        // execute web.sql.gz
        run('cd {{deploy_path}}/shared && tar -xzf web.tar.gz');
    }
})->desc('Sync assets');

/**
 * use yml file to add hosts
 *
 * @param string $serverConfig
 */
function inventoryString(string $serverConfig)
{
    $data = Yaml::parse($serverConfig);
    if (!is_array($data)) {
        throw new Exception("Hosts file should contains array of hosts.");
    }

    $deployer = Deployer::get();
    foreach ($data as $hostname => $config) {
        if (preg_match('/^\./', $hostname)) {
            continue;
        }

        if (isset($config['local'])) {
            $host = new Localhost($hostname);
        } else {
            $host = new Host($hostname);
            $methods = [
                'hostname',
                'user',
                'port',
                'configFile',
                'identityFile',
                'forwardAgent',
                'multiplexing',
                'sshOptions',
                'sshFlags',
            ];

            foreach ($methods as $method) {
                if (isset($config[$method])) {
                    $host->$method($config[$method]);
                }
            }
        }

        foreach ($config as $name => $value) {
            $host->set($name, $value);
        }

        $deployer->hosts->set($host->getHostname(), $host);
    }
}
