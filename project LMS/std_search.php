<?php
session_start();
$msg='';
$id=$_SESSION['book_id'];
    $connection=mysqli_connect("localhost","root","","lms");
    $query="SELECT * FROM books where id='$id'";
    $data=mysqli_query($connection,$query);
    if(mysqli_num_rows($data)==0){
        echo "No book with such id exists";
    }
    else{
        $msg.= "your search results are"."<br>";
        $d=mysqli_fetch_array($data);
            $msg.= "name =".$d['name']."<br>";
            $msg.= "id =".$d['id']."<br>";
            $msg.= "author =".$d['author']."<br>";
            $msg.= "publication =".$d['publication']."<br>";
            $msg.= "copies =".$d['copies']."<br>";
 }
echo $msg;
?>