<?php
session_start();
unset($_SESSION['admin_id']['$id']);
header("Location:adminSignIn.php");
?>