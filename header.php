<?php session_start();
include "connection.php";
if (isset($_SERVER['HTTP_CLIENT_IP']))
    $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
else if(isset($_SERVER['HTTP_X_FORWARDED']))
    $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
    $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
else if(isset($_SERVER['HTTP_FORWARDED']))
    $ipaddress = $_SERVER['HTTP_FORWARDED'];
else if(isset($_SERVER['REMOTE_ADDR']))
    $ipaddress = $_SERVER['REMOTE_ADDR'];
else
    $ipaddress = 'UNKNOWN';
$count_query=mysqli_query($con,"select * from cart where ip='$ipaddress'");
$cart_value=mysqli_num_rows($count_query);
?>

<!---Top Bar--->
<div class="container-fluid top_bar embed-responsive-1by1" >
    <div class="container">
        <div class="row">
            <div class="col-sm-8 ">
                <div class="col-sm-4">
                <a href="http://www.facebook.com" target="_blank" class="social_icons"> <i class="fa fa-facebook" style="font-size: 20px; color:#fff;"></i></a>
                <a href="http://www.youtube.com" class="social_icons">   <i class="fa fa-youtube" style="font-size: 20px; color:#fff;"></i></a>
                <a href="http://www.twitter.com" class="social_icons">    <i class="fa fa-twitter" style="font-size: 20px; color:#fff;"></i></a>
                <a href="http://mail.google.com" class="social_icons">    <i class="fa fa-google-plus-official" style="font-size: 20px; color:#fff;"></i></a>
                </div>
                <div class="col-sm-8">
                <form method="get" action="product.php"><input style="color: black" type="text" name="_content" placeholder="Search here"><input type="submit" name="Search" value="Search"> </form>
                </div>
            </div>

            <div class="col-sm-4 text-right ">
                <i class="fa fa-envelope"></i> &nbsp;contactus@studyleagueit.com &nbsp;&nbsp; | &nbsp;&nbsp;
               <a class="social_icons" href="cart.php" style="color: white!important;"> <i class="fa fa-shopping-cart"></i>&nbsp; Cart (<?php echo $cart_value;?>)</a>
            </div>
        </div>
    </div>
</div>
<!-- end of Top Bar-->

<!--header-->
<div class="container-fluid">
    <div class="row">
        <div class="nav">
            <div class="col-md-4">
                <a href="index.php"><img src="image/logo/brand.png" style="margin:10px; "alt="logo"></a>
            </div>
            <div class="col-md-8">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="product.php">Product</a></li>
                    <li><a href="Aboutus.php">About</a></li>
                    <li><a href="Contact.php">Contact</a></li>
                    <?php
                    if(!@$_SESSION['user_name']) {
                        ?>
                        <li><a href="Login.php">Login</a></li>
                        <li><a href="Register.php">Register</a></li>
                        <?php
                    }


                    else{
                        ?>

                        <li><a href="logout.php">logout</a></li>
                        <?php
                    }
                    ?>

                </ul>
            </div>
        </div>
    </div>
</div>
