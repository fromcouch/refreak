refreak
=======

taskfreak fork

Hi, I'm using Taskfreak from two or three years ago. I made many changes to the original code but is a poor Hell modify this code and finally I decide to make my own Taskfreak.

Actually I'm in development stage.


What is Refreak?
----------------

Refreak is a simple but efficient web based task manager written in PHP and Code Igniter.
Originally created in September 2005 and maintained by Stan Ozier and Tirzen with their Tirzen Framework.


###Features

 - easy to use task manager
 - order tasks by deadline, project, etc ..
 - user management for tasks and system
 - easy project management
 - import from Taskfreak! when install.

###Future Features

 - Plugin Ready


TODO
----

### Stage 2
+ ~~Import on Install tasks from TF~~
+ Pluginize project
    + Pluginize Controlers and models
    + Decorators for views
    + Pluginize JS
+ Printing Version

Please, feel free to add issue or comment.

INSTALL
=======
Parameters for database configuration are in:

    application/config/database.php

You only need configure hostname, username, password and database parameters inside database.php. Save it and 
then access to www.yourdomain.com/install and click Install button.

Additionaly you can configure some parameters in:

    application/config/refreak.php