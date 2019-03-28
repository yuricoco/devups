**********************************
*
*
*
** this project has been generate by easybuild
*
*
*
**********************************

PHP 5.6.~ 7.~

HOW TO INSTALL PROJECT IN LOCAL

1. active the rewrite module off wamp (or xamp ...)

on windows (wamp) click on the icon of wamp -> Apache -> Apache module -> rewrite_module
restart all services

2. url to backoffice http://localhos/path-to-project/app/
    login: admin | pwd: admin

3. edit the .htaccess file and make sure the path to the index file is correct
i.e: "ErrorDocument 404 /project_build/rhpro/index.php"

4. edit the index.php file and make sure the define ORIGINE path to your project folder is correct

HOW TO INSTALL PROJECT ON THE SERVER

1. 