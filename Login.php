
<!doctype html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-compatible" Content="IE-edge">
    <meta name="viewport" content="width-device-width">
    <title>Studyleague IT Solutions - Web Intermediate</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/ind.css" rel="stylesheet">
</head>
<body>

<!--header starts-->
<?php

include "header.php";

if(isset($_POST["login"]))
{
    $login_username=mysqli_real_escape_string($con,$_POST["login_username"]);
    $login_password=mysqli_real_escape_string($con,$_POST["login_password"]);
    @$remember=mysqli_real_escape_string($con,$_POST["save_me"]);

    $query_to_fetch_salt_and_hash="select * from info WHERE username='$login_username'";
    $exec_salt_and_hash=mysqli_query($con,$query_to_fetch_salt_and_hash);
    if(mysqli_num_rows($exec_salt_and_hash)!=0)
    {
        $salt_hash=mysqli_fetch_assoc($exec_salt_and_hash);
        $salt=$salt_hash["salt"];
        $hash=$salt_hash["hash"];
        $active=$salt_hash["activation"];

        $hash_password=hash('sha256',$login_password.$salt);
        for($round=0;$round<65536;$round++)
        {
            $hash_password=hash('sha256',$hash_password.$salt);

        }


        if($hash_password==$hash) {
            if ($active == 1) {
//                 echo "<script>alert('Successfully login');</script>";
//                 echo "<script>window.open('index.php',_self);</script>";
                $_SESSION["user_name"]=$login_username;
                echo "<script>window.open('index.php','_self')</script>";
                if(isset($_POST["save_me"]))
                {
                    setcookie('uname',$login_username,time()+(86400*15));
                    setcookie('upass',$login_password,time()+(86400*15));
                }
                else
                {
                    if($login_username!=$_COOKIE["uname"]||$login_password!=$_COOKIE["upass"]){
                    setcookie('uname',$login_username,time()-(86400*15));
                    setcookie('upass',$login_password,time()-(86400*15));}
                }

            } else {
                echo "<script>alert('Your account is not activated go to your email and click on activation link');</script>";
                echo "<script>window.history.back()</script>";
                exit();
            }
        }
        else
        {
            echo "<script>alert('password is incorrect');</script>";
            echo "<script>window.history.back()</script>";
            exit();
        }

    }

    else
    {
        echo "<script>alert('Username is not valid')</script>";
        echo "<script>window.history.back()</script>";
        exit();
    }
}
?>
<!-- end of header--->
<br>
<!--Product description-->
<?php if(!isset($_SESSION['user_name'])){?>
<div class="container">
    <ol class="breadcrumb" style="background-color: black">
        <li class="breadcrumb-item"><a class="a" href="index.php">home</a> </li>

    </ol>
</div>
<div class="container-fluid">
<div class="row">
<div class="col-md-offset-4">
    <div class="col-md-6">
        <center>
            <form class="form-inline" method="post" action="">
                <div class="form-group">
                    <label>Username</label>
                    <input class="form-control" type="email" placeholder="Enter your id" style="padding-left: 10px" name="login_username" value="
<?php
                    if(isset($_COOKIE["uname"]))
                    {
                        echo $_COOKIE["uname"];
                    }?>
">
                </div>
                <br>
                <br>
                <div class="form-group">
                    <label>Password</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input class="form-control" type="password" placeholder="Enter your Password" style="padding-left: 10px" name="login_password" value="<?php
                    if(isset($_COOKIE["upass"]))
                    {
                        echo $_COOKIE["upass"];
                    }?>">
                </div>
                <br>
                <br>
                <div class="form-group">
                    &nbsp;&nbsp;&nbsp;&nbsp; <input type="checkbox" name="save_me" value="on">Remember me &nbsp;&nbsp;&nbsp;<a href="forgot.php">forgot password</a>
                </div>
                <br>
                <br>
                <div class="form-group">
                    <input type="submit" class="btn-success btn" value="Login" name="login" >
                </div>
            </form>
        </center>
    </div>
</div>
</div>
</div>
        <?php
                                        }
                                        else
                                            {
                                                echo "<script>window.open('index.php','_self')</script>";
                                            }?>
<!--footer starts-->

<?php
include "footer.php";
?>
<!--footer ends-->
<script type="text/javascript" src="vendor/jquery/jquery.js"></script>
</body>
</html>