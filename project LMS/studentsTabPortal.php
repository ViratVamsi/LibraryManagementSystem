
<?php
session_start();
$msg='';
if(!isset($_SESSION['user_id']['$id'])){
        header("Location:studentsSignIn.php");
    }
    else{
        if(isset($_REQUEST['searchBook'])){
            $_SESSION['book_id']=$_POST['id'];
            ?>
            <script type="text/javascript" language="javascript">window.open('std_search.php');</script>
            <?php
        }
        ?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
    <!-- bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <!-- font-awesome -->
    <link rel="stylesheet" type="text/css" href="css/font-awesome/css/font-awesome.min.css">
    <!-- animate.css for animation effects as well as for wow jquery library for scrolling effects -->
    <link rel="stylesheet" href="css/animate/animate.css">
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
                        <!-- <a class="navbar-brand" href="#student-home">Hii</a> --> <!-- navbar-brand is used for styling content in navbar header class -->
                    </div>
                    <div id="menu" class="collapse navbar-collapse">
                        <!-- collapse navbar-collapse class should be used in order to make menu elements collapsable -->
                        <ul id="students-nav" class="nav navbar-nav">
                            <!-- nav navbar-nav is used for only styling anchor elements in unordered list -->
                            <li><a href="#student-home">Home</a></li>
                            <li><a target="_blank" href="std_account.php">Account Details</a></li>
                            <li><a target="_blank" href="std_profile.php">Profile</a></li>
                            <li><a target="_blank" href="">Settings</a></li>
                            <li><a href="">Logout</a></li>
                        </ul>
                        <div class="search-bar">
                            <form action="" method="POST">
                                <input type="text" name="id" placeholder="search book">
                                <!-- <a target="_blank" href="srd_search.php"></a> -->
                                <input class="btn btn-primary" type="submit" name="searchBook" value="GO">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <section id="student-home">
        <div class="student-home-cover">
            <div class="home-content">
                <div class="home-content-inner animated zoomIn">
                    <div class="inner-content" >
                        <h2>Welcome to the Jntuv Library<br></h2>
                        <h2>Students Portal</h2>
                    </div>
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
    <!-- to prevent form submission on page reloading in issue book type forms -->
    <script type="text/javascript">
        if(window.history.replaceState){
            window.history.replaceState(null,null,window.location.href);
        }
    </script>
</body>

</html>
<?php
}
?>