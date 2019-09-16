<?php
session_start();
$table='';
$add_msg='';
$iss_msg='';
$acc_msg='';
$rmv_msg='';
$up_msg='';
$ret_msg='';
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
            $add_msg.= "succesfully added";
        }

if(isset($_REQUEST['issueBook'])){
    $bid=$_POST['book_id'];
    $sid=$_POST['std_id'];
    $connection=mysqli_connect("localhost","root","","lms");
    $sselect="SELECT * from students where id='$sid'";
    $sdata=mysqli_query($connection,$sselect);
    if(mysqli_num_rows($sdata)==0){
        // echo "no such id in students exists"."<br>";
        $iss_msg.="no such id in students exists"."<br>";
    }
    $bselect="SELECT * from books where id='$bid'";
    $bdata=mysqli_query($connection,$bselect);
    if(mysqli_num_rows($bdata)==0){
        $iss_msg.="no such id in books exists"."<br>";
    }
    $cdata=mysqli_fetch_array($bdata);
    if(mysqli_num_rows($bdata)!=0){
        if($cdata['copies']<=0){
            $iss_msg.="No copies left. Look for book details"."<br>";
        }
    }
    $iselect="SELECT * from issued where book_id='$bid' and std_id='$sid'";
    $idata=mysqli_query($connection,$iselect);
    if(mysqli_num_rows($idata)!=0){
        // echo "this book already issued to this id"."<br>";
        $iss_msg.="this book already issued to this id"."<br>";
    }    
    if(mysqli_num_rows($sdata)!=0 && mysqli_num_rows($bdata)!=0 && $cdata['copies']>0 && mysqli_num_rows($idata)==0){
    $query="INSERT INTO issued(`book_id`, `std_id`, `from_date`, `to_date`) VALUES ('$bid','$sid',CURDATE(),date_add(CURDATE(),INTERVAL 15 DAY))";
    mysqli_query($connection,$query);
    $update=mysqli_query($connection,"UPDATE books set copies=copies-1 where id='$bid'");
    $iss_msg.="succesfully issued";
    }
    //echo $msg;
                    
                    // <!-- <script type="text/javascript">
                    //     document.getElementById('issue').style.display="block";
                    //     // document.getElementById('search').className="active";
                    // </script> -->
}
if(isset($_REQUEST['bookAccount'])){
    $id=$_POST['id'];
    $connection=mysqli_connect("localhost","root","","lms");
    $c=mysqli_query($connection,"SELECT * from issued where book_id='$id'");
    $count=mysqli_num_rows($c);
    $page=$_GET['page'];
    $rows_per_page=5;
    if($page==""){
        $from=0;
    }
    else{
        $from=($page*$rows_per_page)-$rows_per_page;
    }
    $total_pages=ceil(($count)/($rows_per_page));
    $query="SELECT * FROM issued where book_id='$id' limit ".$from.", ".$rows_per_page;
    $data=mysqli_query($connection,$query);
    if(mysqli_num_rows($data)==0){
        $acc_msg.= "No book with such id exists";
    }
    else{
        $acc_msg.= "<table class='search-result' style='margin:10px auto'>
                <tr>
                    <td>
                        Book ID
                    </td>
                    <td>
                        Student ID
                    </td>
                    <td>
                        From Date
                    </td>
                    <td>
                        To Date
                    </td>
                </tr>";
        while($d=mysqli_fetch_array($data)){
        $acc_msg.="<tr>
        <td>".$d['book_id']."</td>
        <td>".$d['std_id']."</td>
        <td>".$d['from_date']."</td>
        <td>".$d['to_date']."</td>
        </tr>";
    }
    $acc_msg.="</table>"; 
    }
}
if(isset($_REQUEST['removeBook'])){
    $id=$_POST['id'];
    $connection=mysqli_connect("localhost","root","","lms");
    $select=mysqli_query($connection,"SELECT * from books where id='$id'");
    $pending=mysqli_query($connection,"SELECT * from issued where book_id='$id'");
    if(mysqli_num_rows($select)==0){
        $rmv_msg.="no book with such id exists.";
    }    
    elseif(mysqli_num_rows($pending)!=0){
        $rmv_msg.="There are some pending due's on this book clear them before removing.";
    }
    else{
        $query="DELETE FROM books WHERE id='$id'";
    mysqli_query($connection,$query);
    // header("Location:adminTabPortal.php");
    $rmv_msg.= "succesfully removed";
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
    $table.= "<table class='search-result' style='margin:10px auto'>
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
    $up_msg.= "Details updated successfully";
    //new code
    // $id=$_POST['id'];
    // $connection=mysqli_connect("localhost","root","","lms");
    // $query="SELECT * FROM books where id='$id'";
    // $data=mysqli_query($connection,$query);
    // if(mysqli_num_rows($data)==0){
    //     $up_msg.= "No book with such id exists";
    // }
    // else{
    // $d=mysqli_fetch_array($data);
    // $up_msg.= "<table id='update_id' class='search-result' style='margin:10px auto'>
    // <tr>
    //     <td>
    //         name
    //     </td>
    //     <td>
    //         id
    //     </td>
    //     <td>
    //         author
    //     </td>
    //     <td>
    //         publication
    //     </td>
    //     <td>
    //         copies
    //     </td>
    // </tr>";
    // $up_msg.= "<tr>
    // <td contenteditable='true'>".$d['name']."</td>
    // <td contenteditable='true'>".$d['id']."</td>
    // <td contenteditable='true'>".$d['author']."</td>
    // <td contenteditable='true'>".$d['publication']."</td>
    // <td contenteditable='true'>".$d['copies']."</td>
    // </tr>
    // </table>";
    // }  
}
if(isset($_REQUEST['bookReturned'])){
    $bid=$_POST['book_id'];
    $sid=$_POST['std_id'];
    $connection=mysqli_connect("localhost","root","","lms");
    $sselect="SELECT * from students where id='$sid'";
    $sdata=mysqli_query($connection,$sselect);
    if(mysqli_num_rows($sdata)==0){
        $ret_msg.=  "no such id in students exists"."<br>";
    }
    $bselect="SELECT * from books where id='$bid'";
    $bdata=mysqli_query($connection,$bselect);
    if(mysqli_num_rows($bdata)==0){
        $ret_msg.=  "no such id in books exists"."<br>";
    }
    $iselect="SELECT * from issued where book_id='$bid' and std_id='$sid'";
    $idata=mysqli_query($connection,$iselect);
    if(mysqli_num_rows($idata)==0){
        $ret_msg.=  "no such book is issued"."<br>";
    }
    if(mysqli_num_rows($sdata)!=0 && mysqli_num_rows($bdata)!=0 && mysqli_num_rows($idata)!=0){
    mysqli_query($connection,"DELETE from issued where book_id='$bid' and std_id='$sid'");
    mysqli_query($connection,"UPDATE books set copies=copies+1 where id='$bid'");
    // header("Location:adminTabPortal.php"); no need of this bcoz the script tag plced in last is handling the form resubmission anamoly
    $ret_msg.= "<h5>Book successfully Returned</h5>";  
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
    <!-- font-awesome -->
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
    <!-- animate.css for animation effects as well as for wow jquery library for scrolling effects -->
    <link rel="stylesheet" href="css/animate/animate.css">
    <!-- style.css -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body data-spy="scroll" data-target=".navbar-fixed-top" data-offset="65">
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
                            <li><a class="smooth-scroll" href="#admin-home">Home</a></li>
                            <li><a class="smooth-scroll" href="#tab-section">My Priviliges</a></li>
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
        <div class="admin-home-cover">
            <div class="home-content">
                <div class="home-content-inner animated zoomIn">
                    <div class="inner-content" >
                        <h2>Welcome to the Admin Portal<br></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="tab-section">
        <div class="tabs wow zoomIn" data-wow-delay="0s" data-wow-duration="1s">
            <div class="containter-fluid ">
                <div class="row wow bounceInUp" data-wow-delay=".5s" data-wow-duration="1s">
                    <div class="col-md-2">
                        <button class="tablinks btn btn-lg" id="add-tab" onclick="openn(event,'add')">Add Book</button>
                    </div>
                    <div class="col-md-2">
                        <button class="tablinks btn btn-lg" id="remove-tab" onclick="openn(event,'remove')">Remove Book</button>
                    </div>
                    <div class="col-md-2">
                        <button class="tablinks btn btn-lg" id="search-tab" onclick="openn(event,'search')">Search</button>
                    </div>
                    <div class="col-md-2">
                        <button class="tablinks btn btn-lg" id="update-tab" onclick="openn(event,'update')">Update</button>
                    </div>
                    <div class="col-md-2">
                        <button class="tablinks btn btn-lg" id="acc-iss-tab" onclick="openn(event,'account-issue')">Book Account and Issue's</button>
                    </div>
                    <div class="col-md-2">
                        <button id="return-tab" type="button" class="tablinks btn btn-lg" onclick="openn(event,'return')">Retuns</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="tabsection-content">
            <div id="add" class="tabcontent">
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
                <div class="align-center">
                    <?php
                        echo $add_msg;
                    ?>
            </div>
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
                    <div class="align-center">
                    <?php
                        echo $rmv_msg;
                    ?>
                </div>
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
                    <div class="align-center">
                        <?php
                        if(isset($_REQUEST['updateBook'])){
                            echo $up_msg;
                        }
                    ?>
                    </div>
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
            <div id="account-issue" class="tabcontent">
                <div class="containter">
                    <div class="row">
                        <div class="col-md-6">
                            <button class="tablinks btn btn-lg" onclick="openn(event,'book-details')">Account Details</button>
                        </div>
                        <div class="col-md-6">
                            <button class="tablinks btn btn-lg" onclick="openn(event,'issue')">Issue Book</button>
                        </div>
                    </div>
                </div>
                
            </div>
            <div id="book-details" class="tabcontent">
                <div class="align-center">
                    <?php
                    if(isset($_REQUEST['bookAccount'])){
                        echo $acc_msg;
                        $next_page=$page+1;
                        ?>
                        <a href="adminTabPortal.php?page=<?php echo $next_page ?>">Next</a>
                        <?php
                    }
                    ?>
                    <?php
                if(isset($_REQUEST['bookAccount'])){
                    ?>
                    <script type="text/javascript">
                        document.getElementById('book-details').style.display="block";
                    </script>
                    <?php
                }
                ?>
                </div>
                    <fieldset>
                        <legend>Book Account</legend>
                        <form action="" method="POST">
                            <table>
                                <tr>
                                    <td>Book ID</td>
                                    <td><input type="text" name="id" required></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><input name="bookAccount" type="submit" value="View Details"></td>
                                </tr>
                            </table>
                        </form>
                    </fieldset>
            </div>
            <div id="issue" class="tabcontent">

                    <fieldset>
                <div class="align-center">
                    <?php
                        echo $iss_msg;
                    ?>
                </div>
                <?php
                if(isset($_REQUEST['issueBook'])){
                    ?>
                    <script type="text/javascript">
                        document.getElementById('issue').style.display="block";
                    </script>
                    <?php
                }
                
                ?>
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
                <div class="align-center">
                    <?php
                        echo $ret_msg;
                    ?>
                </div>
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
    <!-- animation on scroll -->
    <script src="js/wow/wow.min.js"></script>
    <!-- custom.js -->
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