
<?php
session_start();
$_SESSION['user_id']=array();
	if(isset($_REQUEST['submit_request'])){
		$id=$_POST['id'];
		$pass=$_POST['pass'];
		$connection=mysqli_connect("localhost","root","","lms");

$query=mysqli_query($connection,"SELECT * from students where id='$id'");
if(mysqli_num_rows($query)!=0){
	$data=mysqli_fetch_array($query);
	if($data['password'] == $pass){
		$_SESSION['user_id']['$id']=$data['name'];
		$_SESSION['u_id']=$id;
		header("Location:studentsTabPortal.php");
	}
	else{
		echo "Credentials doesnt match"."<br/>";
		echo "<a href='forgot_passsword.php'>Forgot Password?</a>";
	}
	
}
else{
	echo "Your ID is not found on registered list. Please register in case if u not previously registered"."<br>";
}
	}

// if($pass!=$r_pass){
// 	echo "Please correct ur password dude!"."<br>";
// 	//header("Location:studentsSignUp.html");
// }
// else{
// 	$connection=mysqli_connect("localhost","root","","lms");
// 	$id_query=mysqli_query($connection,"SELECT 'id' from students");
// 	if(mysqli_num_rows($id_query)!=0){
// 		echo "ID already exited"."<br>";
// 	}
// 	$email_query=mysqli_query($connection,"SELECT 'mail' from students");
// 	if(mysqli_num_rows($email_query)!=0){
// 		echo "email ID already exited"."<br>";
// 	}
// 	else{
// 	$query="INSERT INTO students(`name`, `id`, `password`, `date`, `email`) VALUES ('$name','$id','$pass','$date','$mail')";
// 	mysqli_query($connection,$query);
// 	session_start();
// 	$_SESSION['id']="Your id is logged in";
// 	$_SESSION['email']="Your email is registered";
	
// echo "your registration was successful";
// }
// }



//To Echo out The registered members
// echo "your registered candidates are : "."<br/>";
// $query=mysqli_query($connection,"SELECT * from students");
// while($data=mysqli_fetch_array($query)){
// 	echo $data['name']."<br/>";
// }

//sign in form checks


?>



<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<fieldset><legend><h3>SignIn to continue</h3></legend>
	<form action="studentsSignIn.php" method="POST" >
		<table>
		<tr>
			<td>
				ID : 
			</td>
			<td>
				<input type="text" name="id" minlength="10" maxlength="10" value="<?=((isset($id))?$id:'')?>" required >
			</td>
		</tr>
		<tr>
			<td>
				PASSWORD : 
			</td>
			<td>
				<input type="password" name="pass" minlength="5" required>
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" name="submit_request" value="LOGIN">
			</td>
		</tr>
	</table>
	<h6>Not a Member</h6><br>
	<a href="studentsSignUp.php">Register Now!</a>
	</form>
</fieldset>
</body>
</html>