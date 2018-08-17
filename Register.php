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
if(isset($_GET["activation"]))
{
    $str=mysqli_real_escape_string($con,$_GET["activation"]);
$ar=explode("=",$str,PHP_INT_MAX);
$res_select=mysqli_query($con,"select * from info WHERE username='$ar[0]' AND salt='$ar[1]' AND activation=0");
if(mysqli_num_rows($res_select)==1)
{
    $act_update_result=mysqli_query($con,"update info set activation=1 WHERE username='$ar[0]' AND salt='$ar[1]'");
    if($act_update_result)
    {
        echo "<script>alert('Your account is successfully activated')</script>";
        echo "<script>window.open('index.php',_self)</script>";
    }

}
else
    {
        echo "<script>alert('Account is already activated or something went wrong try again')</script>";
        echo "<script>window.open('index.php',_self)</script>";
    }
}
?>
<!-- end of header--->
<br>
<!--Product description-->
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
                            <label>Name</label>
                            <input class="form-control" type="text" placeholder="Enter your name" style="padding-left: 10px" name="name">
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label>Contact</label>
                            <input class="form-control" type="text" placeholder="### ### ####" style="padding-left: 10px" maxlength="10" name="contact">
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" rows="3" name="address"></textarea>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input class="form-control" type="email" placeholder="Enter your id" style="padding-left: 10px" name="email">
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label>Password</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input class="form-control" type="password" placeholder="Enter your Password" style="padding-left: 10px" name="password">
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label>Confirm Password</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <input class="form-control" type="password" placeholder="Enter your Password" style="padding-left: 10px" name="confirm_password">
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            &nbsp;&nbsp;&nbsp;&nbsp; <input type="checkbox" required>I accept terms &amp; conditions
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <img src="captcha.php ">
                        </div>
                        <br>
                        <br>
                       <div class="form-group">
                           <input class="form-control" type="text" placeholder="Enter the captcha" name="cap" required>
                       </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <input type="submit" class="btn-success btn" value="Register" name="submit">
                        </div>
                    </form>
                </center>
            </div>
        </div>
    </div>
</div>
<?php
if(isset($_POST["submit"]))
{
$name=mysqli_real_escape_string($con,$_POST["name"]);
$contact=mysqli_real_escape_string($con,$_POST["contact"]);
$address=mysqli_real_escape_string($con,$_POST["address"]);
$email=mysqli_real_escape_string($con,$_POST["email"]);
$password=mysqli_real_escape_string($con,$_POST["password"]);
$confirm_password=mysqli_real_escape_string($con,$_POST["confirm_password"]);
$captcha=mysqli_real_escape_string($con,$_POST["cap"]);
if($password==$confirm_password && $captcha==$_SESSION["cap_code"])
{
    $result=mysqli_query($con,"select * from info WHERE username='$email'");
  if(mysqli_num_rows($result)==0)
  {
      $salt=dechex(mt_rand(0,2147483647)).dechex(mt_rand(0,2147483647));
      $user_password=hash('sha256',$password.$salt);
      $active=0;
      for($round=0;$round<65536;$round++)
      {
          $user_password=hash('sha256',$user_password.$salt);
      }
      $insert_query ="insert into info(name,contact,address,username,password,hash,salt,activation) VALUES ('$name','$contact','$address','$email','$password','$user_password','$salt','$active')";
        if(mysqli_query($con,$insert_query))
        {
            $to=$email;
            $subject='Signup Verification';
            $message='Thanks for signing up your account has been created you can login after you have activated your account by clicking below
            
            Pleace click this link to activate your account:http://www.xyz.com/Register.php?activation='.$email.'='.$salt.'';
            $header='Form: conatctus@gmail.com'."\r\n";
            $mail=mail($to,$subject,$message,$header);
            if($mail)
            {
                echo "<script>alert('Registration Successfull & an activation link is sent to your email')</script>";
                echo "<script>window.open('index.php',_self)</script>";
            }
            else
                {
                    echo "<script>alert('Error sending mail')</script>";
                    echo "<script>window.history.back()</script>";
                    exit();
                }
        }
        else
            {
                echo "<script>alert('Email id is already exist')</script>";
                echo "<script>window.history.back()</script>";
                exit();
            }
  }
  else
      {
       echo "<script>alert('Email id is already exist')</script>";
          echo "<script>window.history.back()</script>";
          exit();
      }
}
else
    {
        echo $password!=$confirm_password?"<script>alert('password did not match')</script>":"";
        echo "<script>window.history.back()</script>";
        $password!=$confirm_password?exit():"";
        echo $captcha!=$_SESSION["cap_code"]?"<script>alert('captcha did not match')</script>":"";
        echo "<script>window.history.back()</script>";
        exit();
    }
}
?>
<?php
include "footer.php";?>
<script type="text/javascript" src="vendor/jquery/jquery.js"></script>
</body>
</html>