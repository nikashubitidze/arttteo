<?php
require_once ('.././config/settings.php');

/**
 * @param array $required_fields
 * @param array $request
 * @return bool
 */
function validateRequirements(array $required_fields, array $request)
{
    $status = true;
    foreach ($required_fields as $field) {
        if (!isset($request[$field]) || strlen($request[$field]) == 0) {
            $status = false;
        }
    }
    return $status;
}

/**
 * @param $url
 */
function redirect($url) {
    header("location: ". $url);
    exit();
}

/**
 * @param array $data
 */
function setSessionData(array $data)
{
    foreach ($data as $key => $value) {
        $_SESSION[$key] = $value;
    }
}

/**
 * @param array $request
 * @return bool
 */
function checkPasswordEquals(array $request)
{
    if ($request['password'] != $request['repeat_password']) {
        return false;
    } else {
        return true;
    }
}

/**
 * @return mysqli
 */
function connectToDb()
{
    $connection = new mysqli(SERVER, USER, PASSWORD, DB_NAME);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    return $connection;
}