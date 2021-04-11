<?php
session_start();
require_once ('.././helpers/helper.php');

session_destroy();

redirect("http://localhost/arttteotask/pages/index.php");
