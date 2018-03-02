<?php
/**
 * Created by PhpStorm.
 * User: Mingjie Deng
 * Date: 2018/1/31
 * Time: 22:23
 */



/**
 * @param $name
 * @return bool
 */
function validName($name)
{
    return !empty($name) && ctype_alpha($name);
}

/**
 * @param $age
 * @return bool
 */
function validAge($age)
{
    return ctype_digit($age) && $age > 0;
}

/**
 * @param $phone
 * @return bool
 */
function validPhone($phone)
{
    //Eliminate all the non digit char
    $phone = preg_replace('/[^\d]/', '', $phone);

    return (strlen($phone) == 10 || (strlen($phone) == 11 && preg_match('/^1/', $phone)));
}

/**
 * @param $interests
 * @return bool
 */
function validOutdoor($interests)
{
    global $f3;

    foreach ($interests as $interest) {
        if (!in_array($interest, $f3->get('outdoorInterests'))) {
            return false;
        }
    }
    return true;
}

/**
 * @param $interests
 * @return bool
 */
function validIndoor($interests)
{
    global $f3;

    foreach ($interests as $interest) {
        if (!in_array($interest, $f3->get('indoorInterests'))) {
            return false;
        }
    }
    return true;
}

/**
 * @param $uploadFile
 * @return bool
 */
function validImg($uploadFile)
{
    return ($uploadFile["error"] == 0 &&
            ($uploadFile["type"] == "image/gif" ||
                $uploadFile["type"] == "image/jpeg" ||
                $uploadFile["type"] == "image/png") &&
            $uploadFile["size"] < 500000
    );
}

function validPersonal($fname, $lname, $age, $phone)
{
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
    return $errors;
}

function validInterest($myIndoorInterests, $myOutdoorInterests)
{
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

    return $errors;
}

