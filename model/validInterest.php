<?php
/**
 * Created by PhpStorm.
 * User: Mingjie Deng
 * Date: 2018/2/1
 * Time: 0:17
 */

include_once 'validate.php';

$errors = array();

if (!validIndoor($indoorInterests)) {
    $errors['indoor'] = "Please select the valid interests.";
}

if (!validOutdoor($outdoorInterests)) {
    $errors['outdoor'] = "Please select the valid interests.";
}

//$success = true;
$success = sizeof($errors) == 0;