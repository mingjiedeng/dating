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
    return ctype_digit($age) && $age >= 18;
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
            $uploadFile["size"] < 10000
    );
}

