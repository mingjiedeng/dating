<?php
/*
    index.php
    This file is the main routing file using fat free framework.

    @author     Mingjie Deng <mdeng@mail.greenriver.edu>
    @version    1.0(1/19/2018)
*/

    //session_start();

    //Require the autoload file
    require_once('vendor/autoload.php');

    //Create an instance of the Base class
    $f3 = Base::instance();

    //Set devug level
    $f3->set('DEBUG', 3); //3 is higher than 0, will present more info

    //Define a default route
    $f3->route('GET /', function() {
        $view = new View;
        echo $view->render
        ('pages/home.html');
    });

    //Run fat free
    $f3->run();