<?php
session_start();
require_once ('.././models/User.php');
use models\User;

$user = new User();
$user->login($_REQUEST);