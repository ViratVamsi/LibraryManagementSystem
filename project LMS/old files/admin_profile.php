<?php
session_start();
    $admin_id=$_SESSION['id'];
    $connection=mysqli_connect("localhost","root","","lms");
    $squery="SELECT * FROM admins where id='$admin_id'";
    $sdata=mysqli_query($connection,$squery);
    echo "Profile"."<br>";
        $sd=mysqli_fetch_array($sdata);
            echo "name : ".$sd['name']."<br>";
            echo "id : ".$sd['id']."<br>";
            echo "date of birth : ".$sd['date']."<br>";
            echo "email : ".$sd['email']."<br>";
            echo "mobile : ".$sd['mobile']."<br>";
            echo "referee : ".$sd['ref_id']."<br>";
?>