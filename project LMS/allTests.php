		<?php
        $id=$_POST['id'];
    $connection=mysqli_connect("localhost","root","","lms");
    $count=mysqli_query($connection,"SELECT count(*)from issued where book_id='$id'");
    $page=0;
    $rows_per_page=5;
    $query="SELECT * FROM issued where book_id='$id' limit ".$page.", ".$rows_per_page;
    $data=mysqli_query($connection,$query);

//for updating book
echo "<a style='cursor:pointer;' onclick='update_details()'>Update</a>";
                        ?>
                        <script type="text/javascript">
                            function update_details(){
                            var table= document.getElementById('update_id');
                            var one=table.rows[1].cells[0].innerHTML;
                            var two=table.rows[1].cells[1].innerHTML;
                            var three=table.rows[1].cells[2].innerHTML;
                            var four=table.rows[1].cells[3].innerHTML;
                            var five=table.rows[1].cells[4].innerHTML;
                            document.cookie="one=".one;
                            document.cookie="two=".two;
                            document.cookie="three=".three;
                            document.cookie="four=".four;
                            document.cookie="five=".five;
                        }
                        </script>
                        <?php
                        $name=$_COOKIE['one'];
                        $id=$_COOKIE['two'];
                        $author=$_COOKIE['three'];
                        $publication=$_COOKIE['four'];
                        $copies=$_COOKIE['five'];
                        $que="UPDATE books SET name='$name',id='$id',author='$author',publication='$publication',copies='$copies' WHERE id='$id'";
                        mysqli_query($connection,$que);
<fieldset>
                    <legend>Update Book</legend>
                    <form action="" method="POST">
                        <table>
                            <tr>
                                <td>Book ID</td>
                                <td><input type="text" name="id" required></td>
                            </tr>
                            <tr>
                                <td colspan="2"><input name="updateBook" type="submit" value="Show Details"></td>
                            </tr>
                        </table>
                    </form>
                </fieldset>

















		$d=mysqli_fetch_array($data
        for($x=0;$x<5;$x++){
            echo $d[$x]."<br/>";
        }
        foreach ($d as $key => $value) {
            echo $key."=".$value."<br>";
        }
		?>



		<div class="nav nav-tabs">
                            <li class="nav-item">
                                <a href="#add">Add Book</a>
                            </li>
                            <li class="nav-item">
                                <a href="#remove">Add Book</a>
                            </li>
                            <li class="nav-item">
                                <a href="#search">Add Book</a>
                            </li>
                            <li class="nav-item">
                                <a href="#update">Add Book</a>
                            </li>
                            <li class="nav-item">
                                <a href="#issue">Add Book</a>
                            </li>
                            <li class="nav-item">
                                <a href="#add">Add Book</a>
                            </li>
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

            <div id="account-issue" class="tabcontent">
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
                        // document.getElementById('search').className="active";
                    </script>
                    <?php
                }
                ?>
                <div class="container">
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


            if(isset($_REQUEST['bookAccount'])){
    $id=$_POST['id'];
    $connection=mysqli_connect("localhost","root","","lms");
    $query="SELECT * FROM issued where book_id='$id'";
    $data=mysqli_query($connection,$query);
    if(mysqli_num_rows($data)==0){
        $acc_msg.= "No book with such id exists";
    }
    else{
        $d=mysqli_fetch_array($data);
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
        $acc_msg.= "<tr>
        <td>".$d['book_id']."</td>
        <td>".$d['std_id']."</td>
        <td>".$d['from_date']."</td>
        <td>".$d['to_date']."</td>
        </tr>
        </table>";
    }
}