<?php
namespace Glacryl\T3Glacryl\Automation;

use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;
//use TYPO3\CMS\Core\Utility\VersionNumberUtility;


/**
 * Class Install
 *
 * Called class to install (copy) all needed files to the fileadmin/files directory
 *
 */

class Install
{

    /**
     * destination dir
     * @var string
     */
    public $dest;

    /**
     * source dir
     * @var string
     */
    public $source;

    /**
     * @var string
     */
    protected $messageQueueByIdentifier = '';

    /**
     * Initializes the install service
     */
    public function __construct()
    {
        $this->messageQueueByIdentifier = 'extbase.flashmessages.tx_extensionmanager_tools_extensionmanagerextensionmanager';
    }

    /**
     * Initialize function
     * starts the installer
     */
    public function InitializeInstaller($extname = null) {
        if ($extname !== 't3_glacryl') {
            return;
        }

        $flagFile = $_SERVER['DOCUMENT_ROOT'] . '/typo3conf/ext/t3_glacryl/FIRST_INSTALL';
        if (file_exists ( $flagFile )) {
            $this->source = $_SERVER['DOCUMENT_ROOT'] . '/typo3conf/ext/t3_glacryl/Resources/Fileadmin/';
            $this->dest = $_SERVER['DOCUMENT_ROOT'] . '/fileadmin/';

            $this->copyTemplateStructure();
            //$this->copyRealUrlConfig();
            //$this->copyCoolUriConfig();

            $this->deleteFlag( $flagFile );

            /**
             * Add Flashmessage after files was placed in the "files" directory
             */
            /*$flashMessage = GeneralUtility::makeInstance(
                'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
                'All files was placed in your files directory.',
                'Default RealURL and CoolUri configuration was placed in the typo3conf directory.',
                FlashMessage::OK,
                true
            );*/
            /*
            $message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessage::class,
                'Default RealURL and CoolUri configuration was placed in the typo3conf directory.',
                'All files was placed in your "files" directory.', // [optional] the header
                \TYPO3\CMS\Core\Messaging\FlashMessage::OK, // [optional] the severity defaults to \TYPO3\CMS\Core\Messaging\FlashMessage::OK
                true // [optional] whether the message should be stored in the session or only in the \TYPO3\CMS\Core\Messaging\FlashMessageQueue object (default is false)
            );
            $flashMessageService = $this->objectManager->get(\TYPO3\CMS\Core\Messaging\FlashMessageService::class);
            $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
            $messageQueue->addMessage($message);*/



        }

    }

    /**
     * copy template files to fileadmin
     */
    public function copyTemplateStructure() {
        if (!is_dir($this->dest)) {
            @mkdir($this->dest, 0755);
        }

        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->source, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $item) {
            if ($item->isDir()) {
                @mkdir($this->dest . '/' . $iterator->getSubPathName());
            } else {
                if (!file_exists($this->dest . $iterator->getSubPathName())) {
                    @copy($item, $this->dest . $iterator->getSubPathName());
                }
            }
        }
    }

    public function copyRealUrlConfig() {
        $filename = $_SERVER['DOCUMENT_ROOT'] . '/typo3conf/ext/t3_glacryl/Configuration/RealUrl/realurl_conf.php';
        if (file_exists($filename)) {
            copy($filename, $_SERVER['DOCUMENT_ROOT'] . '/typo3conf/realurl_conf.php');
        }
    }

    public function copyCoolUriConfig() {
        $filename = $_SERVER['DOCUMENT_ROOT'] . '/typo3conf/ext/t3_glacryl/Configuration/CoolUri/CoolUriConf.xml';
        if (file_exists($filename)) {
            copy($filename, $_SERVER['DOCUMENT_ROOT'] . '/typo3conf/CoolUriConf.xml');
        }
    }

    /**
     * Creates the TypoScript constants.txt file with necessary page IDs
     */
    protected function createTypoScriptConstants()
    {
        $data = '';
        $ds = DIRECTORY_SEPARATOR;
        $filename = dirname( __DIR__ ) . $ds . 'Configuration' . $ds . 'TypoScript' . $ds . 'constants.txt';

        $records = BackendUtility::getRecordsByField( 'pages', 'title', 'Root' );

        foreach( $records as $record ) {
            $data .= 'home = ' . intval( $record['uid'] ) . "\n";
        }

        $records = BackendUtility::getRecordsByField( 'pages', 'title', 'Global content' );

        foreach( $records as $record ) {
            $data .= 'globalContent = ' . intval( $record['uid'] ) . "\n";
        }

        $records = BackendUtility::getRecordsByField( 'pages', 'title', '404' );

        foreach( $records as $record ) {
            $data .= 'error404 = ' . intval( $record['uid'] ) . "\n";
        }

        $records = BackendUtility::getRecordsByField( 'pages', 'title', 'Sitemap' );

        foreach( $records as $record ) {
            $data .= 'siteMap = ' . intval( $record['uid'] ) . "\n";
        }

        GeneralUtility::writeFile( $filename, $data );
    }

    /**
     * Delete flag after first installation
     *
     * @param string $filename
     */

    protected function deleteFlag( $filename )
    {
        unlink( $filename );
    }

    
    /**
     * Create .htaccess file.
     */
    public function createHtaccessFile() {
        $htAccessFile = GeneralUtility::getFileAbsFileName(".htaccess");
        if ( file_exists($htAccessFile) ) {
            $this->addMessage(FlashMessage::NOTICE, '.htaccess not created', ' File .htaccess already exists in the root directory.');
            return;
        }
        $htAccessContent = GeneralUtility::getUrl(PATH_typo3 .'../_.htaccess');
        if ( trim($htAccessContent) ) {
            if ( GeneralUtility::writeFile($htAccessFile, $htAccessContent, TRUE) ) {
                $this->addMessage(FlashMessage::OK,  '.htaccess file created', 'File .htaccess was created in the root directory.');
            }
        }
    }


}
