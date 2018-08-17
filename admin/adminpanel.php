<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Studyleague IT Solutions - Web Intermediate</title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body style="background-color:#A9A9A9;">
    <?php
    include "../connection.php";
    session_start();
    if(isset($_SESSION['logout_session'])) {
        ?>
        <div class="container-fluid" style="background-color:#696969; color:white;">
            <div class="container">
                <center><h1>Admin Panel</h1></center>
                <button class="btn" style="display: inline;float: right"><a href="admin_panel_logout.php">Logout</a> </button>

            </div>
        </div>
        <br>
        <div class="container">

            <ul class="nav nav-tabs nav-justified">
                <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
                <li><a data-toggle="tab" href="#menu1">User Info</a></li>
                <li><a data-toggle="tab" href="#menu2">Add Products</a></li>
                <li><a data-toggle="tab" href="#menu3">Transaction Details</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <h3>HOME</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.</p>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <br>
                    <div class="container">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="panel">
                                    <div class="panel-heading" style="background-color:#d0d0d0;">
                                        <center><h4><b>Users</b></h4></center>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                <th>Sr no.</th>
                                                <th>Name</th>
                                                <th>Email</th>

                                                </thead>
                                                <tbody>
                                                <?php
                                                $abc=mysqli_query($con,"select * from info");
                                                while($result=mysqli_fetch_assoc($abc)){?>
                                                <tr>
                                                    <td><?php echo $result['id'];?></td>
                                                    <td><?php echo $result['name'];?></td>
                                                    <td><?php echo $result['username'];?></td>

                                                </tr>
                                         <?php
                                                }
                                                ?>
                                                <tr>
                                                    <td colspan="4">
                                                        <center>
                                                            <button type="button" class="btn btn-info"
                                                                    data-toggle="modal" data-target="#myModal">ADD NEW
                                                                USER
                                                            </button>
                                                        </center>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <form method="post" action="">
                                            <table class="table table-hover">
                                                <tbody>
                                                <tr>
                                                    <td>Name :</td>
                                                    <td><input type="text" placeholder="name" name="name"></td>
                                                </tr>
                                                <tr>
                                                    <td>Contact :</td>
                                                    <td><input type="text" maxlength="10" placeholder="#### ######" name="contact"></td>
                                                </tr>
                                                <tr>
                                                    <td>Username :</td>
                                                    <td><textarea rows="4" cols="20" placeholder="address" name="address"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td>Username :</td>
                                                    <td><input type="email" placeholder="username" name="email"></td>
                                                </tr>
                                                <tr>
                                                    <td>Password :</td>
                                                    <td><input type="text" placeholder="password" name="password"></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <center>
                                                            <input type="submit" class="btn" value="ADD USER" name="submit">
                                                        </center>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if(isset($_POST['submit']))
                {
                    $name=mysqli_real_escape_string($con,$_POST['name']);
                    $contact=mysqli_real_escape_string($con,$_POST['contact']);
                    $username=mysqli_real_escape_string($con,$_POST['email']);
                    $password=mysqli_real_escape_string($con,$_POST['password']);
                    $address=mysqli_real_escape_string($con,$_POST['address']);
                    $check=mysqli_query($con,"select * from info WHERE username='$username'");
                    if (mysqli_num_rows($check)==0)
                    {
                        $salt=dechex(mt_rand(0,2147483647)).dechex(mt_rand(0,2147483647));
                        $user_password=hash('sha256',$password.$salt);
                        $active=1;
                        for($round=0;$round<65536;$round++)
                        {
                            $user_password=hash('sha256',$user_password.$salt);
                        }
                        $insert_query ="insert into info(name,contact,address,username,password,hash,salt,activation) VALUES ('$name','$contact','$address','$username','$password','$user_password','$salt','$active')";
                        if(mysqli_query($con,$insert_query))
                        {
                            echo "<script>alert('Successfully inserted')</script>";
                            echo "<script>window.open('adminpanel.php','_self')</script>";
                            exit();
                        }
                        else
                        {
                            echo "<script>alert('Something went wrong')</script>";
                            echo "<script>window.history.back()</script>";
                            exit();
                        }
                    }
                    else
                        {
                            echo "<script>alert('Username is already exist')</script>";
                            echo "<script>window.history.back()</script>";
                            exit();
                        }
                }
                ?>
                <div id="menu2" class="tab-pane fade">
                    <br>
                    <div class="container">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="panel">
                                    <div class="panel-heading" style="background-color:#d0d0d0;">
                                        <center><h4><b>Add New Products</b></h4></center>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <tbody>
                                                <tr>
                                                    <td>Product Name :</td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td>Product Price :</td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td>Upload Product Image :</td>
                                                    <td><input type="file" accept="image/*"></td>
                                                </tr>
                                                <tr>
                                                    <td>Product Category :</td>
                                                    <td><input type="text"></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="4">
                                                        <center>
                                                            <button class="btn">Add Product</button>
                                                        </center>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="menu3" class="tab-pane fade">
                    <h3>Menu 3</h3>
                    <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt
                        explicabo.</p>
                </div>
            </div>
        </div>
        <br>
        <br>
        <!-- Footer -->
        <footer class="page-footer font-small blue fixed-bottom">

            <!-- Copyright -->
            <div class="footer-copyright text-center py-3 " float="left">
                © 2018 Copyright. All Rights Reserved.
            </div>
            <div class="footer-copyright text-center py-3">
                Designed and Developed by Studyleague IT Solitions
            </div>

            <!-- Copyright -->

        </footer>
        <!-- Footer -->
        <?php
    }
    ?>
</body>
</html>
