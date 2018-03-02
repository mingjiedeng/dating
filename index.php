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
    require_once 'vendor/autoload.php';
    require_once '/home/mdenggre/config.php';
    include_once 'model/global_var.php';

    //session_start() must after requiring autoload.php
    session_start();

    //Create an instance of the Base class
    $f3 = Base::instance();

    //Set devug level
    $f3->set('DEBUG', 3); //3 is higher than 0, will present more info

    $f3->set('states', $states);
    $f3->set('indoorInterests', $indoorInterests);
    $f3->set('outdoorInterests', $outdoorInterests);

    //Define a default route
    $f3->route('GET /', function() {
        echo Template::instance() -> render('views/home.html');
    });

    $f3->route('GET|POST /signUp/personalInfo', function ($f3)
    {
        if (isset($_POST['submit'])) {
            //Create an object
            $member = new Member($_POST);

            //Set f3 variables
            $f3->set('member', $member);

            //Save member object into session
            $_SESSION['member'] = $member;

            $f3->reroute('/signUp/profile');
        }
        echo Template::instance() -> render('views/personalInfo.html');
    });

    $f3->route('GET|POST /signUp/profile', function ($f3)
    {
        if(isset($_POST['submit']))
        {
            if (!$_SESSION['member'])
                $f3->reroute('/');

            $member = $_SESSION['member'];
            $member->setData($_POST);
            $f3->set('member', $member);

            if ($member->getValue('premium'))
                $f3->reroute('/signUp/interests');
            else {
                //Save the member data into database
                $member->saveToDB();
                $f3->reroute('/signUp/summary');
            }
        }
        echo Template::instance() -> render('views/profile.html');
    });

    $f3->route('GET|POST /signUp/interests', function ($f3)
    {
        if (!$_SESSION['member'] || !$_SESSION['member']->getValue('premium'))
            $f3->reroute('/');

        if(isset($_POST['submit']))
        {
            //save the user input to the variables
            $myIndoorInterests = empty($_POST['indoorInterests']) ? array() : $_POST['indoorInterests'];
            $myOutdoorInterests = empty($_POST['outdoorInterests']) ? array() : $_POST['outdoorInterests'];

            $member = $_SESSION['member'];
            $member->setPremiumData($myIndoorInterests, $myOutdoorInterests);


            $f3->set('myIndoorInterests', $myIndoorInterests);
            $f3->set('myOutdoorInterests', $myIndoorInterests);
            $f3->set('member', $member);

            $f3->reroute('/signUp/summary');
        }
        echo Template::instance() -> render('views/interests.html');
    });

    $f3->route('GET|POST /signUp/summary', function ($f3)
    {
        if (!$_SESSION['member'])
            $f3->reroute('/');

        $member = $_SESSION['member'];

        $f3->set('member', $member);

        echo Template::instance() -> render('views/summary.html');
    });

    $f3->route('GET|POST /summary/@id', function ($f3, $params)
    {
        $member = Member::getMember($params['id']);

        $f3->set('member', $member);

        echo Template::instance() -> render('views/summary.html');
    });

    $f3->route('GET|POST /admin', function ($f3)
    {
        $members = Member::getMembers();
        $f3->set("members", $members);

        echo Template::instance() -> render('views/admin.html');
    });

    //Run fat free
    $f3->run();