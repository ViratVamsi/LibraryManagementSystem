<?php

session_start();
$_SESSION['cart']=array();
array_push($_SESSION['cart'], 29);
array_push($_SESSION['cart'], 34);
array_push($_SESSION['cart'], 43);
// var_dump($_SESSION['cart']);
// unset($_SESSION['cart'][array_search(34, $_SESSION['cart'])]);
// var_dump($_SESSION['cart']);
// unset($_SESSION['cart'][2]);
// var_dump($_SESSION['cart']);
$associ = array('vamsi' => 29 );
$associ['nagsai']=65;




$_SESSION['logins']=array();
$_SESSION['logins']['vamsi']=29;
$_SESSION['logins']['nagsai']=65;
$_SESSION['test']=229;

?>