## geekportal

A one-stop-shop for all the geeks . Get news feed from leading tech blogs and discuss along with them , about them.
An ideal site to start your day with!

###features

* Get the latest ten articles from leading techblogs from various categories
		on your homescreen .
* Only read the short description initially . Liked the description ? Now ,click
		that and read the whole article on a popup
		( _No need to navigate to the original site, Saves your time._ )  
* Indulge in discussions in the forum .
* The forums provide distinct trending categories.
* Strict admin policies for content .
	
#####Installation on a local machine :

1.  Import sql/forumdb_schema.sql from phpmyadmin or MySQL command prompt . You have the databases' table structure ready .
    The admin account ( username : 'superuser' , password :'password' email: 'superuser@example.com') and a user account ( username : 'geek' , password : 'qwertyui' email: 'geek@example.com') would also be created to get you started.
    Four categories , namely, SmartPhones, Internet of Things, Tech Startups, Wearables would also be created .
    Users can start creating topics and post , reply on the created posts and have fun! .
2.  You can delete the sql folder now if you like .
3.  Simply copy the whole project directory into the www directory of your WAMP/LAMP or htdocs directory incase you use XAMPP .
4.  Fill up the fields in config.php file.
5.	Run your WAMP/LAMP/XAMPP and request "localhost/geekportal" on your browser . You made it.


#####Admin capabilities (as of now) :

* Creating new categories.
* TODO (Working in progress)
    * Removing categories
    * Removing topics
    * Removing posts
    * Removing replys

##Added CLEF login integration.

* Now users with a clef account can login using nice and quick two factor authentication. 
* for that to work. Every account has been changed to have unique and valid email.

>"Don't judge me for the front-end . Rather, **improve** it !."


###RESTful API (UPCOMNG)

    [geekportal-api](https://github.com/dg711/geekportal-api/ "geekportal API")