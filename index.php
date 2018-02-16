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

    //session_start() must after requiring autoload.php
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
        if (isset($_POST['submit'])) {
            //save the user input to the variables
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $phone = $_POST['phone'];
            $premium = $_POST['premium'];

            include('model/validPersonal.php');

//            $f3->set('lname', $lname);
//            $f3->set('age', $age);
//            $f3->set('gender', $gender);
//            $f3->set('phone', $phone);
//            $f3->set('premium', $premium);
//            $f3->set('errors', $errors);

            if ($premium == "true") {
                $member = new PremiumMember($fname, $lname, $age, $gender, $phone);
            } else {
                $member = new Member($fname, $lname, $age, $gender, $phone);
            }

            $f3->set('member', $member);

            $_SESSION['member'] = $member;

            if ($success) {
                $f3->reroute('/signUp/profile');
            }
        }
        echo Template::instance() -> render('views/personalInfo.html');
    });

    $f3->route('GET|POST /signUp/profile', function ($f3)
    {
        if(isset($_POST['submit']))
        {
            //save the user input to the variables
            $email = $_POST['email'];
            $state = $_POST['state'];
            $seeking = $_POST['seeking'];
            $biography = $_POST['biography'];

            include('model/validProfile.php');

            $f3->set('email', $email);
            $f3->set('state', $state);
            $f3->set('seeking', $seeking);
            $f3->set('biography', $biography);

            $member = $_SESSION['member'];
            $member->setEmail($email);
            $member->setState($state);
            $member->setSeeking($seeking);
            $member->setBio($biography);
            $_SESSION['member'] = $member;

            if ($success) {
                if ($member instanceof PremiumMember) {
                    $f3->reroute('/signUp/interests');
                } else {
                    $f3->reroute('/signUp/summary');
                }
            }
        }
        echo Template::instance() -> render('views/profile.html');
    });

    $f3->route('GET|POST /signUp/interests', function ($f3)
    {
        if (!($_SESSION['member'] instanceof PremiumMember)) {
            $f3->reroute('/');
        }

        if(isset($_POST['submit']))
        {
            //save the user input to the variables
            $indoorInterests = empty($_POST['indoorInterests']) ? array() : $_POST['indoorInterests'];
            $outdoorInterests = empty($_POST['outdoorInterests']) ? array() : $_POST['outdoorInterests'];

            include('model/validInterest.php');

            $f3->set('myIndoorInterests', $indoorInterests);
            $f3->set('myOutdoorInterests', $outdoorInterests);
            $f3->set('errors', $errors);

            $member = $_SESSION['member'];
            $member->setInDoorInterests($indoorInterests);
            $member->setOutDoorInterests($outdoorInterests);
            $_SESSION['member'] = $member;

            if ($success) {
                $f3->reroute('/signUp/summary');
            }
        }
        echo Template::instance() -> render('views/interests.html');
    });

    $f3->route('GET|POST /signUp/summary', function ($f3)
    {
        $member = $_SESSION['member'];
        $f3->set('member', $member);
        $name = $member->getFname() . " " . $member->getLname();
        $f3->set('name', $name);
        $f3->set('age', $member->getAge());
        $f3->set('gender', $member->getGender());
        $f3->set('phone', $member->getPhone());
        $f3->set('email', $member->getEmail());
        $f3->set('state', $member->getState());
        $f3->set('seeking', $member->getSeeking());
        $f3->set('biography', $member->getBio());
        if ($member instanceof PremiumMember) {
            $f3->set('premium', 'true');
            $f3->set('indoorInterests', $member->getInDoorInterests());
            $f3->set('outdoorInterests', $member->getOutDoorInterests());
        }

        echo Template::instance() -> render('views/summary.html');
    });

    //Run fat free
    $f3->run();