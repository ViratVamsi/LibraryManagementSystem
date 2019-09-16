<?php
session_start();
if(!isset($_SESSION['admin_id']['$id'])){
        header("Location:adminSignIn.php");
    }
    else{
        if(isset($_REQUEST['addBookForm'])){
    $name=$_POST['name'];
$id=$_POST['id'];
$author=$_POST['author'];
$publication=$_POST['publication'];
$copies=$_POST['copies'];
    $connection=mysqli_connect("localhost","root","","lms");
    $query="INSERT INTO books(`name`, `id`, `author`, `publication`, `copies`) VALUES ('$name','$id','$author','$publication','$copies')";
    mysqli_query($connection,$query);
    header("Location:adminTabPortal.php");
    echo "succesfully added";
 }

if(isset($_REQUEST['issueBook'])){
$bid=$_POST['book_id'];
$sid=$_POST['std_id'];
    $connection=mysqli_connect("localhost","root","","lms");
    $sselect="SELECT * from students where id='$sid'";
    $sdata=mysqli_query($connection,$sselect);
    if(mysqli_num_rows($sdata)==0){
        echo "no such id in students exists"."<br>";
    }
    $bselect="SELECT * from books where id='$bid'";
    $bdata=mysqli_query($connection,$bselect);
    if(mysqli_num_rows($bdata)==0){
        echo "no such id in books exists"."<br>";
    }
    // $iselect="SELECT * from issued where book_id='$bid'";
    // $idata=mysqli_query($connection,$iselect);
    // if(mysqli_num_rows($idata)!=0){
    //     echo "this book already issued to this id"."<br>";
    // }
    if(mysqli_num_rows($sdata)!=0 && mysqli_num_rows($bdata)!=0 /*&& mysqli_num_rows($idata)==0*/){
    $query="INSERT INTO issued(`book_id`, `std_id`, `from_date`, `to_date`) VALUES ('$bid','$sid',CURDATE(),date_add(CURDATE(),INTERVAL 15 DAY))";
    mysqli_query($connection,$query);
    $update=mysqli_query($connection,"UPDATE books set copies=copies-1 where id='$bid'");
    header("Location:adminTabPortal.php");
    echo "succesfully issued";
    }
}
if(isset($_REQUEST['removeBook'])){
    $id=$_POST['id'];
    $connection=mysqli_connect("localhost","root","","lms");
    $query="DELETE FROM books WHERE id='$id'";
    mysqli_query($connection,$query);
    header("Location:adminTabPortal.php");
    echo "succesfully removed";
}
 if(isset($_REQUEST['searchBook'])){
$id=$_POST['id'];
    $connection=mysqli_connect("localhost","root","","lms");
    $query="SELECT * FROM books where id='$id'";
    $data=mysqli_query($connection,$query);
    if(mysqli_num_rows($data)==0){
        echo "No book with such id exists";
    }
    else{
        echo "your search results are"."<br>";
        $d=mysqli_fetch_array($data);
            echo "name =".$d['name']."<br>";
            echo "id =".$d['id']."<br>";
            echo "author =".$d['author']."<br>";
            echo "publication =".$d['publication']."<br>";
            echo "copies =".$d['copies']."<br>";
        //$d=mysqli_fetch_array($data
        // for($x=0;$x<5;$x++){
        //     echo $d[$x]."<br/>";
        // }
        // foreach ($d as $key => $value) {
        //     echo $key."=".$value."<br>";
        // }
    }
 }
if(isset($_REQUEST['updateBook'])){
    $name=$_POST['name'];
$id=$_POST['id'];
$author=$_POST['author'];
$publication=$_POST['publication'];
$copies=$_POST['copies'];
    $connection=mysqli_connect("localhost","root","","lms");
    $query="UPDATE books SET name='$name',id='$id',author='$author',publication='$publication',copies='$copies' WHERE id='$id'";
    mysqli_query($connection,$query);
    header("Location:adminTabPortal.php");
    echo "Details updated successfully";
    
}
if(isset($_REQUEST['bookReturned'])){
$bid=$_POST['book_id'];
$sid=$_POST['std_id'];
    $connection=mysqli_connect("localhost","root","","lms");
    $sselect="SELECT * from students where id='$sid'";
    $sdata=mysqli_query($connection,$sselect);
    if(mysqli_num_rows($sdata)==0){
        echo "no such id in students exists"."<br>";
    }
    $bselect="SELECT * from books where id='$bid'";
    $bdata=mysqli_query($connection,$bselect);
    if(mysqli_num_rows($bdata)==0){
        echo "no such id in books exists"."<br>";
    }
    // $iselect="SELECT * from issued where book_id='$bid' and std_id='$sid'";
    // $idata=mysqli_query($connection,$iselect);
    // if(mysqli_num_rows($idata)==0){
    //     echo "no such book is issued"."<br>";
    //}
    if(mysqli_num_rows($sdata)!=0 && mysqli_num_rows($bdata)!=0 /*&& mysqli_num_rows($idata)!=0*/){
    mysqli_query($connection,"DELETE from issued where book_id='$bid' and std_id='$sid'");
    mysqli_query($connection,"UPDATE books set copies=copies+1 where id='$bid'");
    header("Location:adminTabPortal.php"); //here php page is redirected to html
    echo "details successfully updated";    //this is not bein printed bcoz html page doesnt support php code
    }
}
        
    }

?>
<!-- keeping this above php  causing error as cannot modify header information already started .... this is due to placing of raw tags s such as html before php tags or duee to white spaces before or after php tags --> 
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
    <header>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="containter-fluid">
                <!-- container fluid takes full width of webpage unlike container class -->
                <div id="wrapper">
                    <div class="navbar-header">
                        <!-- navbar header is bootstap class for header in navbar -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <!-- span elements are used for white lines in toggle button -->
                        </button>
                        <a class="navbar-brand" href="#admin-home">Hii <?=$_SESSION['admin_id']['$id']?></a> <!-- navbar-brand is used for styling content in navbar header class -->
                    </div>
                    <div id="menu" class="collapse navbar-collapse">
                        <!-- collapse navbar-collapse class should be used in order to make menu elements collapsable -->
                        <ul class="nav navbar-nav">
                            <!-- nav navbar-nav is used for only styling anchor elements in unordered list -->
                            <li><a href="#admin-home">Home</a></li>
                            <li><a href="#tab-section">My Priviliges</a></li>
                            <li><a href="admin_profile.php">Profile</a></li>
                            <li><a href="admin_settings.php">Settings</a></li>
                            <li><a href="admin_logout.php">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <section id="admin-home">
        <div class="home-cover">
            <div class="home-content">
                <div class="home-content-inner">
                    <div class="inner-content">
                        <h2>Welcome to the Admin Portal<br></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="tab-section">
        <div class="tab-box">
            <div class="tab-box-inner">
                <div class="tabs">
                    <div class="containter">
                        <div class="row">
                            <div class="col-md-2">
                                <button class="tablinks btn btn-lg" onclick="openn(event,'add')">Add Book</button>
                            </div>
                            <div class="col-md-2">
                                <button class="tablinks btn btn-lg" onclick="openn(event,'remove')">Remove Book</button>
                            </div>
                            <div class="col-md-2">
                                <button class="tablinks btn btn-lg" onclick="openn(event,'search')">Search</button>
                            </div>
                            <div class="col-md-2">
                                <button class="tablinks btn btn-lg" onclick="openn(event,'update')">Update</button>
                            </div>
                            <div class="col-md-2">
                                <button class="tablinks btn btn-lg" onclick="openn(event,'issue')">Issue</button>
                            </div>
                            <div class="col-md-2">
                                <button class="tablinks btn btn-lg" onclick="openn(event,'return')">Book Returned</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="add" class="tabcontent">
        <!-- <div id="content-title">
                <h3>Add a Book</h3>
                <div class="underline"></div>
            </div> -->
        <fieldset>
            <legend>Add Book</legend>
            <form action="adminTabPortal.php" method="POST">
                <table>
                    <tr>
                        <td>Book Name</td>
                        <td><input type="text" name="name"></td>
                    </tr>
                    <tr>
                        <td>Book ID</td>
                        <td><input type="text" name="id"></td>
                    </tr>
                    <tr>
                        <td>Author Name</td>
                        <td><input type="text" name="author"></td>
                    </tr>
                    <tr>
                        <td>Publication</td>
                        <td><input type="text" name="publication"></td>
                    </tr>
                    <tr>
                        <td>No. of Copies</td>
                        <td><input type="text" name="copies"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input name="addBookForm" type="submit" value="Add"></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
    <div id="remove" class="tabcontent">
        <!-- <div id="content-title">
                <h3>Add a Book</h3>
                <div class="underline"></div>
            </div> -->
        <fieldset>
            <legend>Remove Book</legend>
            <form action="adminTabPortal.php" method="POST">
                <table>
                    <tr>
                        <td>Book ID</td>
                        <td><input type="text" name="id"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input name="removeBook" type="submit" value="Remove"></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
    <div id="search" class="tabcontent">
        <!-- <div id="content-title">
                <h3>Add a Book</h3>
                <div class="underline"></div>
            </div> -->
        <fieldset>
            <legend>Search Book</legend>
            <form action="adminTabPortal.php" method="POST">
                <table>
                    <tr>
                        <td>Book ID</td>
                        <td><input type="text" name="id"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input name="searchBook" type="submit" value="Search"></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
    <div id="update" class="tabcontent">
        <!-- <div id="content-title">
                <h3>Add a Book</h3>
                <div class="underline"></div>
            </div> -->
        <fieldset>
            <legend>Update Book</legend>
            <form action="adminTabPortal.php" method="POST">
                <table>
                    <tr>
                        <td>Book ID</td>
                        <td><input type="text" name="id" required></td>
                    </tr>
                    <tr>
                        <td>Book Name</td>
                        <td><input type="text" name="name"></td>
                    </tr>
                    <tr>
                        <td>Author Name</td>
                        <td><input type="text" name="author"></td>
                    </tr>
                    <tr>
                        <td>Publication</td>
                        <td><input type="text" name="publication"></td>
                    </tr>
                    <tr>
                        <td>No. of Copies</td>
                        <td><input type="text" name="copies"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input name="updateBook" type="submit" value="Update"></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
    <div id="issue" class="tabcontent">
        <!-- <div id="content-title">
                <h3>Add a Book</h3>
                <div class="underline"></div>
            </div> -->
        <fieldset>
            <legend>Issue Book</legend>
            <form action="adminTabPortal.php" method="POST">
                <table>
                    <tr>
                        <td>How many Books</td>
                        <td><input type="text" name="number"></td>
                    </tr>
                    <tr>
                        <td>Book ID</td>
                        <td><input type="text" name="book_id"></td>
                    </tr>
                    <tr>
                        <td>To Student ID</td>
                        <td><input type="text" name="std_id"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input name="issueBook" type="submit" value="Issue"></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
    <div id="return" class="tabcontent">
        <!-- <div id="content-title">
                <h3>Add a Book</h3>
                <div class="underline"></div>
            </div> -->
        <fieldset>
            <legend>Book Returned</legend>
            <form action="adminTabPortal.php" method="POST">
                <table>
                    <tr>
                        <td>Book ID</td>
                        <td><input type="text" name="book_id"></td>
                    </tr>
                    <tr>
                        <td>From Student ID</td>
                        <td><input type="text" name="std_id"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input name="bookReturned" type="submit" value="Returned"></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
    </div>
    
    <!-- jquery -->
    <script src="js/jquery.js"></script>

<!-- bootstrap JS -->
    <script src="js/bootstrap/bootstrap.min.js"></script>

    <!-- custom -->
    <script src="js/custom.js"></script>

    <!-- <script type="text/javascript">
    function open(evt, cityName) {
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    </script> -->
</body>


</html>