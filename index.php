<?php
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
        //echo '<h1>This is a routing-demo page</h1>';
    });
/*
    $f3->route('GET /page1', function() {
        $view = new View;
        //echo $view->render
        //('views/home.html');
        echo '<h1>This is page1</h1>';
    });

    $f3->route('GET /page1/subpage-a', function() {
        $view = new View;
        //echo $view->render
        //('views/home.html');
        echo '<h1>This is page1, Subpage A</h1>';
    });

    $f3->route('GET /jewelry/rings/toe-rings', function() {
        //$view = new View;
        //echo $view->render
        //('views/home.html');
        //echo '<h1>This is page1, Subpage A</h1>';
        $template = new Template();
        echo $template->render('views/toe-rings.html');
    });

    //Define a route using parameters
    $f3->route('GET /hello/@name',
        function($f3, $params) {
        //$name = $params['name'];
        //echo "<h1>Hello, $name</h1>";

            $f3->set('name', $params['name']);
            $template = new Template();
            echo $template->render('views/hello.html');
    });

    //...328/routing-demo/hi/Joe/Shmo
    $f3->route('GET /hi/@first/@last',
        function($f3, $params) {
            $f3->set('first', $params['first']);
            $f3->set('last', $params['last']);
            $f3->set('message', 'Hi');

            $_SESSION['first'] = $f3->get('first');
            $_SESSION['last'] = $f3->get('last');

            $template = new Template();
            echo $template->render('views/hi.html');
        });

    $f3->route('GET /hi-again',
        function($f3, $params) {

            echo 'Hi again, '.$SESSION['first'];
        });

    $f3->route('GET /language/@lang'),
        function($f3, $params) {
            switch($params['lang']) {
                case 'swahili':
                    echo 'Jumbo!'; break;
                case 'spanish':
                    echo 'Hola!'; break;
                case 'russian':
                    echo 'Privet!'; break;
                case 'farsi':
                    echo 'Salam!'; break;
                //Reroute to another page
                case 'french':
                    $f3->reroute('/'); break;
                //404 error
                default:
                    $f3->error(404); break;
            }
        }
*/
    //Run fat free
    $f3->run();