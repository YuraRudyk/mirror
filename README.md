Use TYPO3 9.5 LTS for build Glacryl website.


Getting started

This project is using the following core technologies:



PHP 7.2 as programming language

MySql as relational database

TYPO3 CMS v9.5 as content management system and application development framework

Composer for dependency management in PHP

Docker and Docker Compose for settings up a personal development environment

GitLab as Git server and continuos integration server


Please read the guides of the according projects before starting using this project.

Run application

There are several ways of how to run the application. The official supported way is to use Docker Compose.

Run application using Docker Compose

You can run this project using docker-compose. This documentation assumes you are using the host name glacryl.lh .
For accessing the project you might want to choose a host name of your choice but the recommended hostname is glacryl.lh .
If you want to name your host differently then change the scripts above accordingly.


1. Dump the database to a SQL file and add the file to ./etc/db/dump.sql.
Please note that there will be no error message if the file is missing.
2. Copy .env-example to .env (configuration file for typo3).
3. Run "docker-compose up" on your command line.
4. Install composer dependencies using a local installed Composer "composer install".
5. You need .htaccess file to web folder, you can copy fom root _.htaccess and rename it to .htaccess.
6. Open your browser http://glacryl.lh/typo3 and login to the backend.

