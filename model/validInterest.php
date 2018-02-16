<?php
/**
 * Created by PhpStorm.
 * User: Mingjie Deng
 * Date: 2018/2/1
 * Time: 0:17
 */

include_once 'validate.php';

$errors = array();

if (!validIndoor($myIndoorInterests)) {
    $errors['indoor'] = "Please select the valid interests.";
}

if (!validOutdoor($myOutdoorInterests)) {
    $errors['outdoor'] = "Please select the valid interests.";
}

if ($_FILES['fileToUpload']['error'] != 4) {
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if (!validImg($_FILES['fileToUpload'])) {
        $errors['upload'] = "Photo upload failed or image type invalid.";
    } else {
        // Check if file already exists
        if (file_exists($target_file)) {
            $errors['upload'] = $errors['upload'] . "Sorry, file already exists. ";
        } else {
            if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $errors['upload'] = "Sorry, there was an error uploading your file.";
            }
        }
    }
}


/*
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    $errors['upload'] = $errors['upload'] . "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
}

// Check if image file is a actual image or fake image
if(!getimagesize($_FILES["fileToUpload"]["tmp_name"])) {
    $errors['upload'] = $errors['upload'] . "File is not an image. ";
}

// Check if file already exists
if (file_exists($target_file)) {
    $errors['upload'] = $errors['upload'] . "Sorry, file already exists. ";
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $errors['upload'] = $errors['upload'] . "Sorry, your file is too large. ";
}

// Check if $uploadOk is set to 0 by an error
if (isset($errors['upload'])) {
    if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $errors['upload'] = "Sorry, there was an error uploading your file.";
    }
}
*/

//$success = true;
$success = sizeof($errors) == 0;