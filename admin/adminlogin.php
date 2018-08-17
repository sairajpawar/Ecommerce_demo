<!doctype html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-compatible" Content="IE-edge">
        <meta name="viewport" content="width-device-width">
        <title>Studyleague IT Solutions - Web Intermediate</title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body style="background-color:#a9a9a9;">
    
        <div class="container-fluid" style="background-color:#696969; color:white;">
            <div class="container">
                <center><h1>Admin Panel</h1></center>
            </div>
        </div>
        
        <br>
       <br>
       <div class="container"> 
        <div class="col-md-12">   
        <div class="row">
            <center>
                <div class="col-md-offset-4 col-md-4">
                    
                    <form class="form-inline" method="post" action="">
                       
                        <div class="form-group">
                            <label>Username:</label>
                            <input type="email" class="form-control" placeholder="enter your email" name="username">
                            <br><br>
                        </div>
                        <div class="form-group">
                                <label>Password:</label>
                            <input type="password" class="form-control" placeholder="enter your password" name="password">
                    
                        </div>
                        <br><br>
                         
                        <div class="form-group">
                            <input type="submit" class="btn" value="Login" name="login">
                        </div>
                    </form>
                </div>
            </center>
        
        </div>
        
           </div>
        </div>
        <br><br>
        <?php
        session_start();
        include "../connection.php";
        if(isset($_POST['login']))
        {
            $username=mysqli_real_escape_string($con,$_POST['username']);
            $password=mysqli_real_escape_string($con,$_POST['password']);
            $check_for_valid_admin=mysqli_query($con,"select * from admin WHERE username='$username'");
            if(mysqli_num_rows($check_for_valid_admin)>0)
            {
                $result=mysqli_fetch_assoc($check_for_valid_admin);
                $salt=$result['salt'];
                $hash=$result['hash'];
                $user_password=hash('sha256',$password.$salt);
                for($round=0;$round<65536;$round++)
                {
                    $user_password=hash('sha256',$user_password.$salt);
                }
                if($user_password==$hash)
                {
                    $_SESSION['logout_session']=$username;
                    echo "<script>window.open('adminpanel.php','_self');</script>";
                }else
                    {
                        echo "<script>alert('Password is not matching');</script>";
                        echo "<script>window.history.back();</script>";
                        exit();
                    }
            }
            else
                {
                    echo "<script>alert('Not a valid username');</script>";
                    echo "<script>window.history.back();</script>";
                    exit();
                }

        }?>
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

        <script type="text/javascript" src="vendor/jquery/jquery.js"></script>
    </body>
</html>