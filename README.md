CrazEvent
=========

## Installation Guide

In order to install this software, you must configure your Apache server with the instructions provided in the file `configApache.txt`.

Moreover, it will be more convenient if you clone this repo manually in your `wamp/www/crazevent` directory with a shell and the following command
```
git clone git@github.com:Auriana/CrazEvent .
```
The final dot is mandatory if you want to avoid to clone the root directory `CrazEvent`.
Then you can add this repo to your GitHub desktop interface with a simple drag and drop.

Finally, a MySql database must be running when you test the application. The credentials must be the same as provided in the file `application\config\database.php`. By default the username is `root` and password is `root` likewise.
A `crazevent` database must be running as well. The deployement script will be soon available.
