<?php
/**
 * Created by PhpStorm.
 * User: Mingjie Deng
 * Date: 2018/2/1
 * Time: 0:17
 */

include_once 'validate.php';

$errors = array();

//if (!(validName($fname) && validName($lname))) {
//    $errors['name'] = "Please enter a valid name.";
//}

//$success = true;
$success = sizeof($errors) == 0;