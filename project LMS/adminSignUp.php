<fieldset><legend>SignUp</legend>
<form action="adminSignUp.php" method="POST" >
		<table>
			<tr>
				<td>
				NAME  
				</td>
			<td>
				<input type="text" name="name" required>
			</td>
			</tr>
		<tr>
			<td>
				ID 
			</td>
			<td>
				<input type="text" name="id" minlength="10" maxlength="10" required>
			</td>
		</tr>
		<tr>
			<td>
				PASSWORD 
			</td>
			<td>
				<input type="password" name="pass" minlength="5" required>
			</td>
		</tr>
		<tr>
			<td>
				RE-ENTER PASSWORD: 
			</td>
			<td>
				<input type="password" name="r_pass" minlength="5" required>
			</td>
		</tr>
		<tr>
			<td>
				DATE OF BIRTH
			</td>
			<td>
				<input type="date" name="date" required>
			</td>
		</tr>
		<tr>
			<td>
				MAIL
			</td>
			<td>
				<input type="email" name="email" required>
			</td>
		</tr>
		<tr>
			<td>
				MOBILE NO.
			</td>
			<td>
				<input type="tel" name="mobile" required>
			</td>
		</tr>
		<tr>
			<td>
				REFEREE ID
			</td>
			<td>
				<input type="text" name="ref_id" required>
			</td>
		</tr>
		<tr>
			<td>
				REFEREE PASSWORD
			</td>
			<td>
				<input type="password" name="ref_pass" required>
			</td>
		</tr>
		<tr>
			<td>
				<input name="signUpForm" type="submit" value="SIGN UP">
			</td>
		</tr>
	</table>
	</form>
</fieldset>
	<?php
if(isset($_REQUEST['signUpForm'])){

$name=$_POST['name'];
$id=$_POST['id'];
$pass=$_POST['pass'];
$r_pass=$_POST['r_pass'];
$date=$_POST['date'];
$mail=$_POST['email'];
$mobile=$_POST['mobile'];
$ref_id=$_POST['ref_id'];
$ref_pass=$_POST['ref_pass'];
if($pass!=$r_pass){
	echo "Please correct ur password dude!"."<br>";
	//header("Location:studentsSignUp.html");
}
else{
	$connection=mysqli_connect("localhost","root","","lms");
	$id_query=mysqli_query($connection,"SELECT 'id' from admins where id='$id'");
	if(mysqli_num_rows($id_query)!=0){
		echo "ID already exited"."<br>";
	}
	// $email_query=mysqli_query($connection,"SELECT 'mail' from students");
	// if(mysqli_num_rows($email_query)!=0){
	// 	echo "email ID already exited"."<br>";
	// }
	$ref_id_query=mysqli_query($connection,"SELECT * FROM admins where id='$ref_id'");
	$ref_pass_query=mysqli_query($connection,"SELECT * FROM admins where password='$ref_pass'");
	$id_data=mysqli_fetch_array($ref_id_query);
	$pass_data=mysqli_fetch_array($ref_pass_query);
	if($ref_id==$id_data['id'] && $ref_pass==$pass_data['password']){
		$query="INSERT INTO admins(`name`, `id`, `password`, `date`, `email`, `mobile`, `ref_id`, `ref_pass`) VALUES ('$name','$id','$pass','$date','$mail','$mobile','$ref_id','$ref_pass')";
		mysqli_query($connection,$query);
	}
	else{
		echo "referee was not a valid one"."<br>";
	}
	//this code worked
// 	else{
// 	$query="INSERT INTO `admins`(`name`, `id`, `password`, `date`, `email`, `mobile`, `ref_id`, `ref_pass`) VALUES ('$name','$id','$pass','$date','$mail','$mobile','$ref_id','$ref_pass')";
	

// 	mysqli_query($connection,$query);
// 	session_start();
// 	$_SESSION['id']="Your id is logged in";
// 	$_SESSION['email']="Your email is registered";
	
// echo "your registration was successful";
// }
}
}
?>