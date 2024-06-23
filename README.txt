1. Install php (https://windows.php.net/download#php-8.3, windows download , VS16 x64 Thread Safe (2024-May-08 09:15:56), extract all, rename to "php-8.3.7") and copy the address location in the C: Drive (C:\php-8.3.7). Open environmental variables and copy this location into the system variables PATH to add it to the whole pc.

The working website can be found by visiting thegameplatform.com
The website uses, HTML, JavaScript, CSS, and PHP.

It uses some of Amazon AWS services such as an EC2 instance, Route 53, RDS, and AWS Certificate Manager (SSL).


The website's homepage shows featured games, news, and updates about the website. In order to play a game a user must register an account with an email address and a unique username. After that, they may log in and start playing some games.

It uses Let's Encrypt to obtain a free SSL certificate for the website. This is set up through the EC2 Linux terminal.

The Ec2 instance was used to host the webserver. 

FileZilla was used for easy drag in drop and modifying files in the webserver.

Route 53 was used to purchase the domain name for the server. It uses the DNS Route 53 to create and manage DNS records for the domain, such as A records, CNAME records, and more. This was useful for routing traffic to other services such as to Cloud Front while using the domain name.

Amazon Relational Database Service (RDS) is a managed relational database service that makes it easy to set up, operate, and scale a relational database in the cloud. I chose a mySQL to store the emails, usernames, first names, last names, and password which are encrypted in php.

php is a server side language so the code here will not be accessed via inspect on the web browser making it secure for a regestration system. Server-Side Execution: The PHP script runs on the server, so the code is not exposed to the client.
The uses prepared statements with parameterized queries, which are effective in preventing SQL injection.
