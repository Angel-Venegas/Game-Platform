1. Install php (https://windows.php.net/download#php-8.3, windows download , VS16 x64 Thread Safe (2024-May-08 09:15:56), extract all, rename to "php-8.3.7") and copy the address location in the C: Drive (C:\php-8.3.7). Open environmental variables and copy this location into the system variables PATH to add it to the whole pc.

The working website can be found by visiting http://thegameplatform.com/
The website uses, HTML, JavaScript, CSS, and PHP.

It uses some of Amazon AWS services such as an EC2 instance, Route 53, RDS, and AWS Certificate Manager (SSL).


The website's homepage shows featured games, news, and updates about the website. In order to play a game a user must register an account with an email address and a unique username. After that, they may log in and start playing some games.

It uses Let's Encrypt to obtain a free SSL certificate for the website. This is set up through the EC2 Linux terminal.
