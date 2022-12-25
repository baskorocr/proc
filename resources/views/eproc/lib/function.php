<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 29-Sep-17
 * Time: 04:27 PM
 */

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function token(){

    $token=generateRandomString(50);
    return "q=1&target=&token=$token&";
}

function token2(){
    $token2 = generateRandomString(25);
    return "&%src%&view=$token2&srv=&valid=1";
}



/*
$token = generateRandomString(50);
$token2 = generateRandomString(25);
$datamock1 = "q=1&target=&token=$token&";
$datamock2 = "&%src%&view=$token2&srv=&valid=1";
*/

?>