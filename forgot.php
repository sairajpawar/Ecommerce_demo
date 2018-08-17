<!doctype html>
<html>
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
<?php
include "header.php";
if(isset($_GET["forgot_password_request"]))
{
    $values=explode("=",mysqli_real_escape_string($con,$_GET["forgot_password_request"]),PHP_INT_MAX);
    $email_check=$values[0];
    $_SESSION["email"]=$email_check;
    $hash_check=$values[1];
    $salt_check=$values[2];
    $result=mysqli_query($con,"select * from info WHERE username='$email_check' AND hash='$hash_check' AND salt='$salt_check'");
    if(mysqli_num_rows($result)==1){
        ?>
<br>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-lg-offset-4">

                <div class="col-md-6">
                    <center>
                        <form class="form-inline" method="post" action="">

                            <div class="form-group">
                                <label>new Password</label>
                                <input class="form-control" type="password" name="new_password" placeholder="Enter your Password" required>
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <label>Confirm password</label>
                                <input class="form-control" type="password" name="confirm_password" placeholder="Enter your Password" required>
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <input class="btn-primary" type="submit" value="reset password" name="reset_password">
                            </div>

                        </form>
                    </center>
                </div>

            </div>
        </div>
    </div>
</div>
        <?php
    }
    else
        {
            echo "<script>alert('Opened link is not valid')</script>";
            echo "<script>window.open('index.php','_self')</script>";
        }
}else{
    ?>
<br>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-lg-offset-4">

                <div class="col-md-6">
                    <center>
                    <form class="form-inline" method="post" action="">

                        <div class="form-group">
                            <label>Username :</label>
                            <input class="form-control" type="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <br>
                        <br>
                         <div class="form-group">
                             <img src="captcha.php">
                         </div>
                          <br>
                          <br>
                         <div class="form-group">
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="form-control" placeholder="Enter the captcha" name="cap" required>
                         </div>
                          <br>
                          <br>
                          <div class="form-group">
                              <input class="btn-primary" type="submit" value="forgot password" name="forgot_password">
                          </div>

                    </form>
                    </center>
                </div>

        </div>
    </div>
</div>
</div>
    <?php
      }
      ?>
    <?php
    if(isset($_POST["forgot_password"]))
    {
        $email=mysqli_real_escape_string($con,$_POST["email"]);
        $captch=mysqli_real_escape_string($con,$_POST["cap"]);
        if($captch==$_SESSION["cap_code"])
        {
            $check_for_record=mysqli_query($con,"select * from info where username='$email'");
            if(mysqli_num_rows($check_for_record)==1)
            {
                $record=mysqli_fetch_assoc($check_for_record);
                $username=$record["username"];
                $hash=$record["hash"];
                $salt=$record["salt"];

                $to=$email;
                $subject='Reset Password';
                $message='Your request for password has accepted change your password by clicking the link below
            
            Pleace click this link to activate your account:http://www.xyz.com/Register.php?activation='.$email.'='.$hash.'='.$salt.'';
                $header='Form: conatctus@gmail.com'."\r\n";
                $mail=mail($to,$subject,$message,$header);
                if($mail)
                {
                    echo "<script>alert('Request accepted reset password link has sent to your mail')</script>";
                    echo "<script>window.open('index.php','_self')</script>";
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
                    echo "<script>alert('Not a valid Username')</script>";
                    echo "<script>window.history.back()</script>";
                    exit();
                }
        }
        else
            {
                echo "<script>alert('Your captcha is not matching')</script>";
                echo "<script>window.history.back()</script>";
                exit();
            }
    }
    elseif (isset($_POST["reset_password"]))
    {
      $new_password=mysqli_real_escape_string($con,$_POST["new_password"]);
      $confirm_password=mysqli_real_escape_string($con,$_POST["confirm_password"]);

      if($new_password==$confirm_password)
      {
          $abc=$_SESSION['email'];
          $boolean_value=false;
          $select_query_from_password=mysqli_query($con,"select * from password WHERE username='$abc'");
          if(mysqli_num_rows($select_query_from_password)>0)
          {
              while ($fetch_my_result=mysqli_fetch_assoc($select_query_from_password))
              {
                  $salt_from_db=$fetch_my_result['salt'];
                  $hash_from_db=$fetch_my_result['hash'];
                  $user_password=hash('sha256',$new_password.$salt_from_db);
                  for($round=0;$round<65536;$round++)
                  {
                      $user_password=hash('sha256',$user_password.$salt_from_db);
                  }
                  if($user_password!=$hash_from_db)
                  {
                      $boolean_value=true;
                  }
                  else
                      {
                          $boolean_value=false;
                          break;
                      }
              }
          }
          if($boolean_value)
          {
              $salt=dechex(mt_rand(0,2147483647)).dechex(mt_rand(0,2147483647));
              $hash_user_password=hash('sha256',$new_password.$salt);
              for($round=0;$round<65536;$round++)
              {
                  $hash_user_password=hash('sha256',$hash_user_password.$salt);
              }
              $update_password_query=mysqli_query($con,"update info set hash='$hash_user_password',password='$new_password',salt='$salt' WHERE username='$abc'");
              session_destroy();
          }
          else
              {
                  echo "<script>alert('You cant set the previously used password')</script>";
                  echo "<script>window.history.back()</script>";
                  exit();
              }

        if($update_password_query)
        {
            echo "<script>alert('Your password has successfully changed')</script>";
            echo "<script>window.open('Login.php','_self')</script>";
            exit();
        }
      }else
          {
              echo "<script>alert('Both the passwords are not matching')</script>";
              echo "<script>window.history.back()</script>";
              exit();
          }
    }
    ?>
</body>
</html>