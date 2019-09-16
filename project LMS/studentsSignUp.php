
<fieldset><legend>SignUp</legend>
<form action="studentsSignUp.php" method="POST" >
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
				<input type="email" name="mail" required>
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
$mail=$_POST['mail'];

if($pass!=$r_pass){
	echo "Please correct ur password dude!"."<br>";
	//header("Location:studentsSignUp.html");
}
else{
	$connection=mysqli_connect("localhost","root","","lms");
	$id_query=mysqli_query($connection,"SELECT 'id' from students where id='$id'");
	if(mysqli_num_rows($id_query)!=0){
		echo "ID already exited"."<br>";
	}
	// $email_query=mysqli_query($connection,"SELECT 'mail' from students");
	// if(mysqli_num_rows($email_query)!=0){
	// 	echo "email ID already exited"."<br>";
	// }
	else{
	$query="INSERT INTO students(`name`, `id`, `password`, `date`, `email`) VALUES ('$name','$id','$pass','$date','$mail')";
	mysqli_query($connection,$query);
	session_start();
	$_SESSION['id']="Your id is logged in";
	$_SESSION['email']="Your email is registered";
	
echo "your registration was successful";
}
}
}
?>