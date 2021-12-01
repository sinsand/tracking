<?php
session_start();
//// Recaptcha
include("../config/phpcaptcha/phptextClass.php");

/*create class object*/
$phptextObj = new phptextClass();
/*phptext function to genrate image with text*/
$phptextObj->phpcaptcha('#162453','#fff',180,40,10,25);
?>
