<?php
/**
 * Created by PhpStorm.
 * User: Mingjie Deng
 * Date: 2018/2/1
 * Time: 0:17
 */

include_once 'validate.php';

$errors = array();

if (!(validName($fname) && validName($lname))) {
    $errors['name'] = "Please enter a valid name.";
}

if (!validAge($age)) {
    $errors['age'] = "Please enter a valid age.";
}

if (!validPhone($phone)) {
    $errors['phone'] = "Please enter a valid phone.";
}

//$success = true;
$success = sizeof($errors) == 0;