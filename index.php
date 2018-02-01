<?php
/*
    index.php
    This file is the main routing file using fat free framework.

    @author     Mingjie Deng <mdeng@mail.greenriver.edu>
    @version    1.1(1/31/2018)
*/

    error_reporting(E_ALL);
    ini_set("display_errors",TRUE);

    //Require the autoload file
    require_once('vendor/autoload.php');
    session_start();

    //Create an instance of the Base class
    $f3 = Base::instance();

    //Set devug level
    $f3->set('DEBUG', 3); //3 is higher than 0, will present more info

    $f3->set('states', array('Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California',
        'Colorado', 'Connecticut', 'Delaware', 'District Of Columbia', 'Florida', 'Georgia',
        'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana',
        'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri',
        'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York',
        'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania',
        'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont',
        'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'));

    $f3->set('indoorInterests', array('tv', 'movies', 'cooking', 'board games', 'puzzles',
        'reading', 'playing cards', 'video games'));

    $f3->set('outdoorInterests', array('hiking', 'biking', 'swimming', 'collecting', 'walking',
        'climbing'));

    //Define a default route
    $f3->route('GET /', function() {
        $view = new View;
        echo $view->render
        ('views/home.html');
    });

    $f3->route('GET|POST /signUp/personalInfo', function ($f3)
    {
        if(isset($_POST['submit']))
        {
            //save the user input to the variables
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $phone = $_POST['phone'];

            include('model/validPersonal.php');

            $f3->set('fname', $fname);
            $f3->set('lname', $lname);
            $f3->set('age', $age);
            $f3->set('gender', $gender);
            $f3->set('phone', $phone);
            $f3->set('errors', $errors);

            $_SESSION['fname']=$fname;
            $_SESSION['lname']=$lname;
            $_SESSION['age']=$age;
            $_SESSION['gender']=$gender;
            $_SESSION['phone']=$phone;

            if ($success) {
                $f3->reroute('/signUp/profile');
            }
        }
        echo Template::instance() -> render('views/personalInfo.html');
    });

    $f3->route('GET|POST /signUp/profile', function ($f3)
    {
        echo Template::instance() -> render('views/profile.html');
    });

    $f3->route('GET|POST /signUp/interests', function ($f3)
    {
        echo Template::instance() -> render('views/interests.html');
    });

    $f3->route('GET|POST /signUp/summary', function ($f3)
    {
        echo Template::instance() -> render('views/summary.html');
    });

    //Run fat free
    $f3->run();