<?php
// test
session_start();
// include config
require ('config.php');

// include lib classes
require ('classes/Bootstrap.php');
require ('classes/Controller.php');
require ('classes/Model.php');
require ('classes/Messages.php');

// include controllers
require ('controllers/Home.php');
require ('controllers/Users.php');
require ('controllers/Tasks.php');
require ('controllers/Projects.php');
require ('controllers/Calendar.php');

// include models
require ('models/User.php');
require ('models/Home.php');
require ('models/Tasks.php');
require ('models/Projects.php');
require ('models/Calendar.php');


$bootstrap = new Bootstrap($_GET);

$controller = $bootstrap->createController();

if ($controller)
{
    $controller->executeAction();
}

// index
// gateway for all files, including stuff and


//echo 'test inz';

// config
// holding database instances and some constants and paths we can use throught application


// classes folder
// lib folder where is core for base model, controler and bootstrap file which take care of redirecting and getting params from url