<?php
session_start();
    $user_id=$_SESSION['u_id'];
    $connection=mysqli_connect("localhost","root","","lms");
    $iquery="SELECT * FROM issued where std_id='$user_id'";
    $idata=mysqli_query($connection,$iquery);
    $squery="SELECT * FROM students where id='$user_id'";
    $sdata=mysqli_query($connection,$squery);
    if(mysqli_num_rows($idata)==0){
        echo "No book given to this id";
    }
    else{
        echo "your account details are"."<br>";
        $sd=mysqli_fetch_array($sdata);
            echo "name is ".$sd['name']."<br>";
            echo "id is ".$sd['id']."<br>";
            echo "date of birth is ".$sd['date']."<br>";
            echo "email is ".$sd['email']."<br>";
            echo "<br>Books issued to you are <br>";
            $count=1;
        while($d=mysqli_fetch_array($idata)){
            echo $count.")<br/>";
            echo "book id = ".$d['book_id']."<br>";
            echo "issued on = ".$d['from_date']."<br>";
            echo "return date = ".$d['to_date']."<br>";
            $count=$count+1;
        } 
    }
?>