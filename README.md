# P6-OC-SnowTricks
Community website about snowboard tricks with Symfony

This project is the 6th done as part of my training (« Développeur d’applications-spécialité PHP/Symfony » OC).

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/681cc0192f9f4db6afe2d04b3e233f1c)](https://www.codacy.com/app/caroleguardiola/P6-OC-SnowTricks?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=caroleguardiola/P6-OC-SnowTricks&amp;utm_campaign=Badge_Grade)

# Instructions for this project :
The website must be developped with Symfony but without using bundles except for initial data.
There 2 types of users :
* 	Anonymous : 
	* 	Can only access to the homepage with the list of tricks, to the details of the trick with comments.
	* 	Can also register as user member to access to all the fonctionnalities of the website.
* 	User member connected : 
	* 	In addition to anonymous access can also create a new trick, edit or delete a trick.
	* 	Can also post comments.
	* 	Can also connect to the website with login page, reset his password.


This project was developed with Symfony 3.4.6 and installed with the dependencies by Composer.
A Bootstrap theme was included and customized.
Mailtrap.io was used for emails.
PHPUnit is installed too.


# Structure :
1 bundle in src :
* 	AppBundle : Tricks management and initial data in DataFixtures and User management.


# Installing :
1.	Clone or Download this repository on your local machine.
2.	Install composer : https://getcomposer.org/
3.	In project folder open a new terminal window and execute command line : composer update
4. 	Create the configuration in /app/config/parameters.yml :
	Copy /app/config/parameters.yml.dist and rename it in /app/config/parameters.yml and update with your parameters.
5. 	Create the database : php bin/console doctrine:database:create
6. 	Create schema with entities : php bin/console doctrine:schema:update --force
7. 	Install initial data with 10 tricks (P6-OC-SnowTricks/SnowTricks/src/ST/AppBundle/DataFixtures/ORM/LoadFixtures.php) : php bin/console doctrine:fixtures:load
8. 	Open the website with web/app_dev.php.


# Contributing :
1.	Fork it
2.	Create your feature branch (git checkout -b my-new-feature)
3.	Commit your changes (git commit -am 'Add some feature')
4.	Push to the branch (git push origin my-new-feature)
5.	Create new Pull Request
