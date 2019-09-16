<?php
session_start();
$table='';
$up_msg='';
$msg='';
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
    // header("Location:adminTabPortal.php"); this is removed bcoz a script placed at last is handling form resubmission issue
    $msg.= "succesfully added";
 }

if(isset($_REQUEST['issueBook'])){
$bid=$_POST['book_id'];
$sid=$_POST['std_id'];
    $connection=mysqli_connect("localhost","root","","lms");
    $sselect="SELECT * from students where id='$sid'";
    $sdata=mysqli_query($connection,$sselect);
    if(mysqli_num_rows($sdata)==0){
        // echo "no such id in students exists"."<br>";
        $msg.="no such id in students exists"."<br>";
    }
    $bselect="SELECT * from books where id='$bid'";
    $bdata=mysqli_query($connection,$bselect);
    if(mysqli_num_rows($bdata)==0){
        // echo "no such id in books exists"."<br>";
        $msg.="no such id in books exists"."<br>";
    }
    $iselect="SELECT * from issued where book_id='$bid' and std_id='$sid'";
    $idata=mysqli_query($connection,$iselect);
    if(mysqli_num_rows($idata)!=0){
        // echo "this book already issued to this id"."<br>";
        $msg.="this book already issued to this id"."<br>";
    }
    if(mysqli_num_rows($sdata)!=0 && mysqli_num_rows($bdata)!=0 && mysqli_num_rows($idata)==0){
    $query="INSERT INTO issued(`book_id`, `std_id`, `from_date`, `to_date`) VALUES ('$bid','$sid',CURDATE(),date_add(CURDATE(),INTERVAL 15 DAY))";
    mysqli_query($connection,$query);
    $update=mysqli_query($connection,"UPDATE books set copies=copies-1 where id='$bid'");
    // echo "succesfully issued";
    $msg.="succesfully issued";
    }
    //echo $msg;
                    
                    // <!-- <script type="text/javascript">
                    //     document.getElementById('issue').style.display="block";
                    //     // document.getElementById('search').className="active";
                    // </script> -->
// header("Location:adminTabPortal.php");
    
}
if(isset($_REQUEST['removeBook'])){
    $id=$_POST['id'];
    $connection=mysqli_connect("localhost","root","","lms");
    $select=mysqli_query($connection,"SELECT * from books where id='$id'");
    $pending=mysqli_query($connection,"SELECT * from issued where book_id='$id'");
    if(mysqli_num_rows($select)==0){
        $msg.="no book with such id exists.";
    }    
    elseif(mysqli_num_rows($pending)!=0){
        $msg.="There are some pending due's on this book clear them before removing.";
    }
    else{
        $query="DELETE FROM books WHERE id='$id'";
    mysqli_query($connection,$query);
    // header("Location:adminTabPortal.php");
    $msg.= "succesfully removed";
    }
    
}
 if(isset($_REQUEST['searchBook'])){
$id=$_POST['id'];
    $connection=mysqli_connect("localhost","root","","lms");
    $query="SELECT * FROM books where id='$id'";
    $data=mysqli_query($connection,$query);
    if(mysqli_num_rows($data)==0){
        $table.= "No book with such id exists";
    }
    else{
        $d=mysqli_fetch_array($data);
        $table.= "<table id='search-result' style='margin:10px auto'>
                <tr>
                    <td>
                        name
                    </td>
                    <td>
                        id
                    </td>
                    <td>
                        author
                    </td>
                    <td>
                        publication
                    </td>
                    <td>
                        copies
                    </td>
                </tr>";
        $table.= "<tr>
        <td>".$d['name']."</td>
        <td>".$d['id']."</td>
        <td>".$d['author']."</td>
        <td>".$d['publication']."</td>
        <td contenteditable='true'>".$d['copies']."</td>
        </tr>
        </table>";
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
    // header("Location:adminTabPortal.php");
    $msg.= "Details updated successfully";
    
}
if(isset($_REQUEST['bookReturned'])){
$bid=$_POST['book_id'];
$sid=$_POST['std_id'];
    $connection=mysqli_connect("localhost","root","","lms");
    $sselect="SELECT * from students where id='$sid'";
    $sdata=mysqli_query($connection,$sselect);
    if(mysqli_num_rows($sdata)==0){
        $up_msg.=  "no such id in students exists"."<br>";
    }
    $bselect="SELECT * from books where id='$bid'";
    $bdata=mysqli_query($connection,$bselect);
    if(mysqli_num_rows($bdata)==0){
        $up_msg.=  "no such id in books exists"."<br>";
    }
    $iselect="SELECT * from issued where book_id='$bid' and std_id='$sid'";
    $idata=mysqli_query($connection,$iselect);
    if(mysqli_num_rows($idata)==0){
        $up_msg.=  "no such book is issued"."<br>";
    }
    if(mysqli_num_rows($sdata)!=0 && mysqli_num_rows($bdata)!=0 && mysqli_num_rows($idata)!=0){
    mysqli_query($connection,"DELETE from issued where book_id='$bid' and std_id='$sid'");
    mysqli_query($connection,"UPDATE books set copies=copies+1 where id='$bid'");
    // header("Location:adminTabPortal.php"); no need of this bcoz the script tag plced in last is handling the form resubmission anamoly
    $up_msg.= "<h5>Book successfully Returned</h5>";  
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
                        <a class="navbar-brand" href="#admin-home">Hii
                            <?=$_SESSION['admin_id']['$id']?></a> <!-- navbar-brand is used for styling content in navbar header class -->
                    </div>
                    <div id="menu" class="collapse navbar-collapse">
                        <!-- collapse navbar-collapse class should be used in order to make menu elements collapsable -->
                        <ul class="nav navbar-nav">
                            <!-- nav navbar-nav is used for only styling anchor elements in unordered list -->
                            <li><a href="#admin-home">Home</a></li>
                            <li><a href="#tab-section">My Priviliges</a></li>
                            <li><a target="_blank" href="admin_profile.php">Profile</a></li>
                            <li><a target="_blank" href="admin_settings.php">Settings</a></li>
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
            <div class="tab-box-inner ">
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
                                <button class="tablinks btn btn-lg" onclick="openn(event,'issue')">Issue Book</button>
                            </div>
                            <div class="col-md-2">
                                <button id="button-return" type="button" class="tablinks btn btn-lg" onclick="openn(event,'return')">Retuns</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="tabsection-content">
            <div id="add" class="tabcontent">
                    <div class="align-center">
                    <?php
                        echo $msg;
                    ?>
                </div>
                <?php
                if(isset($_REQUEST['addBookForm'])){
                    ?>
                    <script type="text/javascript">
                        document.getElementById('add').style.display="block";
                    </script>
                    <?php
                }
                ?>
                <fieldset>
                    <legend>Add Book</legend>
                    <form action="" method="POST">
                        <table>
                            <tr>
                                <td>Book Name</td>
                                <td><input type="text" name="name" required></td>
                            </tr>
                            <tr>
                                <td>Book ID</td>
                                <td><input type="text" name="id" required></td>
                            </tr>
                            <tr>
                                <td>Author Name</td>
                                <td><input type="text" name="author" required></td>
                            </tr>
                            <tr>
                                <td>Publication</td>
                                <td><input type="text" name="publication" required></td>
                            </tr>
                            <tr>
                                <td>No. of Copies</td>
                                <td><input type="text" name="copies" required></td>
                            </tr>
                            <tr>
                                <td colspan="2"><input name="addBookForm" type="submit" value="Add"></td>
                            </tr>
                        </table>
                    </form>
                </fieldset>
            </div>
            <div id="remove" class="tabcontent">
                    <div class="align-center">
                    <?php
                        echo $msg;
                    ?>
                </div>
                <?php
                if(isset($_REQUEST['removeBook'])){
                    ?>
                    <script type="text/javascript">
                        document.getElementById('remove').style.display="block";
                    </script>
                    <?php
                }
                ?>
                <fieldset>
                    <legend>Remove Book</legend>
                    <form action="" method="POST">
                        <table>
                            <tr>
                                <td>Book ID</td>
                                <td><input type="text" name="id" required></td>
                            </tr>
                            <tr>
                                <td colspan="2"><input name="removeBook" type="submit" value="Remove"></td>
                            </tr>
                        </table>
                    </form>
                </fieldset>
            </div>
            <div id="search" class="tabcontent">
                <div class="align-center">
                    <?php
                        echo $table;
                    ?>
                </div>
                <?php
                if(isset($_REQUEST['searchBook'])){
                    ?>
                    <script type="text/javascript">
                        document.getElementById('search').style.display="block";
                        // document.getElementById('search').className="active";
                    </script>
                    <?php
                }
                ?>
                <fieldset>
                    <legend>Search Book</legend>
                    <form action="" method="POST">
                        <table>
                            <tr>
                                <td>Book ID</td>
                                <td><input type="text" name="id" required></td>
                            </tr>
                            <tr>
                                <td colspan="2"><input name="searchBook" type="submit" value="Search"></td>
                            </tr>
                        </table>
                    </form>
                </fieldset>
                
            </div>
            <div id="update" class="tabcontent">
                    <div class="align-center">
                    <?php
                        echo $msg;
                    ?>
                </div>
                <?php
                if(isset($_REQUEST['updateBook'])){
                    ?>
                    <script type="text/javascript">
                        document.getElementById('update').style.display="block";
                    </script>
                    <?php
                }
                ?>
                <fieldset>
                    <legend>Update Book</legend>
                    <form action="" method="POST">
                        <table>
                            <tr>
                                <td>Book ID</td>
                                <td><input type="text" name="id" required></td>
                            </tr>
                            <tr>
                                <td>Book Name</td>
                                <td><input type="text" name="name" required></td>
                            </tr>
                            <tr>
                                <td>Author Name</td>
                                <td><input type="text" name="author" required></td>
                            </tr>
                            <tr>
                                <td>Publication</td>
                                <td><input type="text" name="publication" required></td>
                            </tr>
                            <tr>
                                <td>No. of Copies</td>
                                <td><input type="text" name="copies" required></td>
                            </tr>
                            <tr>
                                <td colspan="2"><input name="updateBook" type="submit" value="Update"></td>
                            </tr>
                        </table>
                    </form>
                </fieldset>
            </div>
            <div id="issue" class="tabcontent">
                <div class="align-center">
                    <?php
                        echo $msg;
                    ?>
                </div>
                <?php
                if(isset($_REQUEST['issueBook'])){
                    ?>
                    <script type="text/javascript">
                        document.getElementById('issue').style.display="block";
                        // document.getElementById('search').className="active";
                    </script>
                    <?php
                }
                ?>
                <fieldset>
                    <legend>Issue Book</legend>
                    <form action="" method="POST">
                        <table>
                            <tr>
                                <td>Book ID</td>
                                <td><input type="text" name="book_id" required></td>
                            </tr>
                            <tr>
                                <td>To Student ID</td>
                                <td><input type="text" name="std_id" required></td>
                            </tr>
                            <tr>
                                <td colspan="2"><input name="issueBook" type="submit" value="Issue"></td>
                            </tr>
                        </table>
                    </form>
                </fieldset>
            </div>
            <div id="return" class="tabcontent">
                <div class="align-center">
                    <?php
                        echo $up_msg;
                    ?>
                </div>
                <?php
                if(isset($_REQUEST['bookReturned'])){
                    ?>
                    <script type="text/javascript">
                        document.getElementById('return').style.display="block";
                    </script>
                    <?php
                }
                ?>
                <fieldset>
                    <legend>Book Returned</legend>
                    <form action="" method="POST">
                        <table>
                            <tr>
                                <td>Book ID</td>
                                <td><input type="text" name="book_id" required></td>
                            </tr>
                            <tr>
                                <td>From Student ID</td>
                                <td><input type="text" name="std_id" required></td>
                            </tr>
                            <tr>
                                <td colspan="2"><input name="bookReturned" type="submit" value="Returned"></td>
                            </tr>
                        </table>
                    </form>
                </fieldset>
            </div>
        </div>
        </div>
    </section>
    <!-- jquery -->
    <script src="js/jquery.js"></script>
    <!-- bootstrap JS -->
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <!-- custom -->
    <script src="js/custom.js"></script>
<!--     <script type="text/javascript" onload="refresh_page()"></script> -->
    <!-- to prevent form submission on page reloading in issue book type forms -->
    <script type="text/javascript">
        if(window.history.replaceState){
            window.history.replaceState(null,null,window.location.href);
        }
    </script>
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