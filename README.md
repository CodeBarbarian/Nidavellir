# Nidavellir
Forged by Dwarfs at the heart of a dying star.

## Vision Statement
This framework should follow three simple rules.
    
1. Secure by Design
2. Easy to use, easy to develop
3. Modular to the extreme

Hidden 4th. Do it how you want to do it.

### Concept

The concept of the framework is to have the possibility to drastically change how we do web development in PHP.
As this framework develops, the needs may grow, but should always have a low footprint.

## Directory Structure


### Main Directories

There are three main directories in the framework

```
/App
/Core
/public
```
These directories form the main framework.

***/public*** is the exposed part of the framework. The index.php file, and style sheets, as well as other client side script resides here.

***/App*** is where the application is built on top of the framework.

***/Core*** is where the framework itself is located.

### Temporary Directory Structure
```
/app
    /Controllers
    /Libraries
    /Models
    /Routes
    /Storage
    /Views
/Core
    /Forge
        /Config
        /Languages
        /Middleware
        /Plugins
        /Resources
        /Rules
        /System
        /Template
    Controller.php
    Error.php
    Model.php
    Router.php
    View.php
/public
    /assets
    index.php
```

### /App

***/App/Controllers*** are the event handlers.

***/App/Models*** are the main data handlers for the controllers.

***/App/Views*** are the template files, HTML data.

***/App/Libraries*** are classes, functions that does not fit within an already existing category.

***/App/Routes*** are the routes for the application.

***/App/Storage*** is the storage for the application, contains the cache, temporary directory and logs.

### /Core

***/Core/Config*** where all the configuration files resides.

***/Core/Languages*** where all the translation files resides.

***/Core/Middleware*** where the middleware is located. These are files that can be used before actions.

***/Core/Plugins*** where the plugins resides.

***/Core/Resources*** where framework resources resides.

***/Core/Rules*** where rule sets are located, these are how to do things. Such as validating user input.

***/Core/System*** where the system files are located, these are files to make sure the framework behaves as a framework correctly. Also implements auto updating. 

***/Core/Template*** where the template engine resides

### /public

*** /public/assets *** where css, javascript and other client side stuff is located.
