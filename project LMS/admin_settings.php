<?php
session_start();
    $id=$_SESSION['id'];
if(isset($_REQUEST['updateName'])){
    $name=$_POST['name'];
    $id=$_SESSION['id'];
    $connection=mysqli_connect("localhost","root","","lms");
    $query="UPDATE admins SET name='$name' WHERE id='$id'";
    mysqli_query($connection,$query);
    $_SESSION['admin_id']['$id']=$name; //this line modifies the name showing in navigation header
    header("Location:adminTabPortal.php");
    echo "Details updated successfully";
    
}
if(isset($_REQUEST['updateMail'])){
    $mail=$_POST['mail'];
    $connection=mysqli_connect("localhost","root","","lms");
    $query="UPDATE admins SET email='$mail' WHERE id='$id'";
    mysqli_query($connection,$query);
    header("Location:adminTabPortal.php");
    echo "Details updated successfully";
    
}
if(isset($_REQUEST['updateMobile'])){
    $mobile=$_POST['mobile'];
    $connection=mysqli_connect("localhost","root","","lms");
    $query="UPDATE admins SET mobile='$mobile' WHERE id='$id'";
    mysqli_query($connection,$query);
    header("Location:adminTabPortal.php");
    echo "Details updated successfully";
    
}
if(isset($_REQUEST['updatePass'])){
    $old_pass=$_POST['old_pass'];
    $new_pass=$_POST['new_pass'];
    $connection=mysqli_connect("localhost","root","","lms");
    $pass_select=mysqli_query($connection,"SELECT password from admins where id='$id'");
    $pass_data=mysqli_fetch_array($pass_select);
    if($old_pass==$pass_data['password']){
    	$query="UPDATE admins SET password='$new_pass' WHERE id='$id'";
    mysqli_query($connection,$query);
    header("Location:adminTabPortal.php");
    echo "Details updated successfully";
    }
    else{
    	echo "You entered wrong password";
    }
    
}

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <!-- style.css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<section id="tab-section">
        <div class="tab-box">
            <div class="tab-box-inner">
                <div class="tabs">
                    <div class="containter">
                        <div class="row">
                            <div class="col-md-3">
                                <button class="tablinks btn btn-lg" onclick="openn(event,'set_name')">Change Name</button>
                            </div>
                            <div class="col-md-3">
                                <button class="tablinks btn btn-lg" onclick="openn(event,'set_pass')">Change Password</button>
                            </div>
                            <div class="col-md-3">
                                <button class="tablinks btn btn-lg" onclick="openn(event,'set_mobile')">Update Mobile Number</button>
                            </div>
                            <div class="col-md-3">
                                <button class="tablinks btn btn-lg" onclick="openn(event,'set_mail')">Change Emai ID</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="tabsection-content">
            <div id="set_name" class="tabcontent">
        <!-- <div id="content-title">
                <h3>Add a Book</h3>
                <div class="underline"></div>
            </div> -->
        <fieldset>
            <legend>Update Name</legend>
            <form action="admin_settings.php" method="POST">
                <table>
                    <tr>
                        <td>Name</td>
                        <td><input type="text" name="name"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input name="updateName" type="submit" value="Update"></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
    <div id="set_mail" class="tabcontent">
        <!-- <div id="content-title">
                <h3>Add a Book</h3>
                <div class="underline"></div>
            </div> -->
        <fieldset>
            <legend>Update E-Mail</legend>
            <form action="admin_settings.php" method="POST">
                <table>
                    <tr>
                        <td>Email</td>
                        <td><input type="text" name="mail"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input name="updateMail" type="submit" value="Update"></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
    <div id="set_pass" class="tabcontent">
        <!-- <div id="content-title">
                <h3>Add a Book</h3>
                <div class="underline"></div>
            </div> -->
        <fieldset>
            <legend>Update Password</legend>
            <form action="admin_settings.php" method="POST">
                <table>
                    <tr>
                        <td>Old Password</td>
                        <td><input type="text" name="old_pass"></td>
                    </tr>
                    <tr>
                        <td>New Password</td>
                        <td><input type="text" name="new_pass"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input name="updatePass" type="submit" value="Update"></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
    <div id="set_mobile" class="tabcontent">
        <!-- <div id="content-title">
                <h3>Add a Book</h3>
                <div class="underline"></div>
            </div> -->
        <fieldset>
            <legend>Update Phone Number</legend>
            <form action="admin_settings.php" method="POST">
                <table>
                    <tr>
                        <td>Mobile No.</td>
                        <td><input type="text" name="mobile"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input name="updateMobile" type="submit" value="Update"></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
        </div>
    </section>

    <!-- jquery -->
    <script src="js/jquery.js"></script>
    <!-- bootstrap JS -->
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <!-- custom -->
    <script src="js/custom.js"></script>

</body>

</html>