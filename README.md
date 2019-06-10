# Herohub
Herohub is a web application that connects Overwatch players based on their individual preferences.

## An example
Sarah is a top 500 Mercy player. She has selected preferences that indicate that she is looking for:

* DPS and tank players
* Players close to her SR
* Other support players that do not play Mercy often
* Hero-specific synergies (Pharah, Winston)
* Players that use voice communication

Selecting more preferences will only make matches more relevant and does not decrease the amount of matches she will see. Being specific about what she looks for in a teammate offers a better experience for everyone.

This project was set up to function with: Ow-API (Overwatch API) https://ow-api.com/

## Disclaimer
All Overwatch assets are accessed via Blizzard's content delivery network. The contributors of this repository do not claim these assets as works of their own.

Source code is licensed under **GNU General Public License v3.0**

## Outlined Project Requirements
Our project uses an MVC pattern to separate business logic such as the database interactions and validation of forms into a model/ directory. The index serves as the controller and processes the user registration form submissions and HeroHub site navigation via routing. The controller gets data from the model via validation-functions.php and database.php. The controller returns a view. Views are html files and are included in the views/ directory. Views utilize the Bootstrap front-end framework.

Read the Bootstrap documentation here - https://getbootstrap.com/docs/4.3/getting-started/introduction/

To use this project, you will need to initially install a composer.json file. If any class changes are made composer.json should be updated. Additionally, an .htaccess file is required.

Our project uses the Fat-Free Framework as a templating language to manage the MVC pattern. Fat-Free utilizes routing, views, and provides access to hive variables to exchange information between the model/view/controller. New and returning users are routed through a registration or account login using this framework as described above.

Read the Fat-Free Documentation here - https://fatfreeframework.com/3.6/user-guide

Our project implements a defined database layer using PDO ( PHP Data Objects) where classes/user.php and classes/ premiumuser.php are User and PremiumUser objects that are utilized prior to inserting and after retrieval from a database. Information is retrieved from User objects and passed to the models/database.php to utilize prepared statements. Prepared statements are pre-compiled therefore, these statements execute faster and information passed as params prevent SQL injection by using placeholders information is passed from objects via the controller.  

Our project includes a means for a new user to create/add a new account. Users can view an account creation summary after successfully completing account registration and being inserted into the database. After a successful login, a user can search and view a list of hero matches that fit what they need to complete a team by retrieving a valid user account from the database. Users can update information on their dashboard via the Update Account Info, Update Playstyle Info, and Update Hero Info pages. A user can logout. A user can delete their account.

Our project utilizes OOP where a user can be a standard User or a PremiumUser. PremiumUser is a User and has access additional functionality for Hero Preferences and Role Priority.

Our code base applies PHP Docblocks for documentation and follows PEAR standards. 

Validation of our web application is handled both the server-side through PHP and via Bootstrap and JavaScript for client-side validation.

