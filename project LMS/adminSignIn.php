<?php
session_start();
$errors='';
	$_SESSION['admin_id']=array();
	if(isset($_REQUEST['submit_request'])){
		$id=$_POST['id'];
	$pass=$_POST['pass'];
		$connection=mysqli_connect("localhost","root","","lms");

$query=mysqli_query($connection,"SELECT * from admins where id='$id'");
if(mysqli_num_rows($query)!=0){
	$data=mysqli_fetch_array($query);
	if($data['password'] == $pass){
		$_SESSION['admin_id']['$id']=$data['name'];
		$_SESSION['id']=$id;
		header("Location:adminTabPortal.php");
	}
	else{
		$errors.= "Password doesnt match with user id given"."<br/>";
		$errors.= "<a href='forgot_passsword.php'>Forgot Password?</a>";
	}
	
}
else{
	$errors.= "Your ID is not found on registered list. Please register in case if u not previously registered"."<br>";
}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<fieldset><legend>SignIn to continue</legend>
	<form action="adminSignIn.php" method="POST" >
		<?php
		echo $errors;
		?>
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
	Not a Member<br>
	<a href="adminSignUp.php">Register Now!</a>
	</form>
</fieldset>
</body>
</html>
