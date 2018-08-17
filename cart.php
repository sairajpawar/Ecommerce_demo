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
include "connection.php";
if(isset($_GET['del'])){
    $delid = $_GET['del'];
    $del1 = "DELETE FROM cart WHERE id='$delid'";
    $del2 = mysqli_query($con,$del1);
    echo"<script>window.open('cart.php','_self')</script>";
}
if(isset($_GET['qty'])){
    $cart_id = $_GET['qty'];
    $new_qty = $_POST['quant'];
    $up1 = "UPDATE cart SET quantity='$new_qty' WHERE id='$cart_id'";
    $up2 = mysqli_query($con,$up1);
    echo"<script>window.open('cart.php','_self')</script>";
}
if(isset($_GET['bn']) && isset($_GET['cat'])){
    $getpro_id = $_GET['bn'];
    $getpro_cat = $_GET['cat'];
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

    $check_pro = "SELECT * FROM cart WHERE ip='$ipaddress' AND pro_id='$getpro_id' AND pro_cat='$getpro_cat'";
    $run_check = mysqli_query($con,$check_pro);
    if(mysqli_num_rows($run_check)>0){
        echo "<script>alert('You have already this product in cart!')</script>";
        echo"<script>window.history.back()</script>";
        exit();
    }else{
        $b1 = "INSERT into cart(ip,pro_id,pro_cat) values('$ipaddress','$getpro_id','$getpro_cat')";
        $b2 = mysqli_query($con,$b1);
        //echo"<script>window.history.back()</script>";
//        exit();
    }
}
?>

<!-- end of header--->
<br>
<!--Product description-->
<div class="container">
    <ol class="breadcrumb" style="background-color: black">
        <li class="breadcrumb-item"><a class="a" href="index.php">home</a> </li>
        <li class="breadcrumb-item"><a  class="a" href="Product.php">Product</a> </li>
        <li class="breadcrumb-item"><a class="a" href="cart.php">Checkout</a> </li>
    </ol>
</div>
<div class="container">
    <div class="col-md-12">
        <div class="row">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <center> <h4>Checkout</h4></center>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <th>Sr.no</th>
                            <th>Name</th>
                            <th>Model</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Delete</th>
                            <?php
                            $_c=mysqli_query($con,"SELECT * FROM cart WHERE ip= '$ipaddress'");
                            if(mysqli_num_rows($_c)>0) {
                                ?>
                                <th>Checkout</th>
                                <?php
                                                        }
                                 ?>
                            </thead>
                            <tbody>
                            <?php
                            $total_p = 0;
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

                            $p1 = "SELECT * FROM cart WHERE ip='$ipaddress' ";
                            $p2 = mysqli_query($con,$p1);
                            $i = 0;
                            while($p3 = mysqli_fetch_assoc($p2)){
                                $pc_id = $p3['id'];
                                $pid = $p3['pro_id'];
                                $pcat = $p3['pro_cat'];
                                $pro1 = "SELECT * FROM product WHERE PRO_ID='$pid' AND CATEGORY='$pcat'";
                                $pro2 = mysqli_query($con,$pro1);
                                $pro3 = mysqli_fetch_assoc($pro2);
                                $title = $pro3['TITLE'];
                                $price = $pro3['PRICE'];
                                $model = $pro3['MODEL'];
                                $qty = $p3['quantity'];
                                $stotal = $qty*$price;
                                $total_p += $stotal;
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td><?php echo $model; ?> </td>
                                    <td><?php echo $price; ?> /-</td>
                                    <form method="POST" action="cart.php?qty=<?php echo $pc_id; ?>">
                                        <td><input type="number" name="quant" min="1" value="<?php echo $qty; ?>"></td>
                                    </form>
                                    <td><?php echo $stotal; ?>/-</td>
                                    <td><button type="button" class="btn btn-danger" onclick="window.location='cart.php?del=<?php echo $pc_id; ?>';" >X</button></td>

                                        <td><button type="button" class="btn btn-success" onclick="window.location='checkout.php?id=<?php echo $pc_id?>';" >Checkout</button></td>


                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="5">Total Price :</td>
                                <td colspan="2"><?php echo $total_p; ?></td>
                                <?php if(mysqli_num_rows($p2)>0)
                                {
                                ?>
                                <td><button type="button" class="btn btn-success" onclick="window.location='checkout.php';">Checkout</button></td>
                                <?php
                                }
                                ?>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--footer starts-->
<?php
include "footer.php";
?>
<!--footer ends-->
<script type="text/javascript" src="vendor/jquery/jquery.js"></script>
</body>
</html>