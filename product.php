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
if(isset($_GET['atc']) && isset($_GET['cat']))
{
     $p_id=$_GET['atc'];
     $cat=$_GET['cat'];
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

     $query_for_cart=mysqli_query($con,"select * from cart where pro_id='$p_id' AND ip='$ipaddress' AND pro_cat='$cat'");
    if(mysqli_num_rows($query_for_cart)!=0)
    {
        echo "<script>alert('Product is already added');</script>";
        echo "<script>window.history.back();</script>";
        exit();
    }
    else

        {
            $query_for_cartinsert=mysqli_query($con,"insert into cart(ip,pro_id,pro_cat) VALUES('$ipaddress','$p_id','$cat')");
            if($query_for_cartinsert){
            echo "<script>alert('Inserted successfully');</script>";
            echo "<script>window.history.back();</script>";
            exit();}
        }
}
    ?>
    <!-- end of header--->
    <br>
    <!--Product description-->
    <div class="container">
        <ol class="breadcrumb" style="background-color: black">
            <li class="breadcrumb-item"><a class="a" href="index.php">home</a></li>
            <li class="breadcrumb-item"><a class="a" href="Product.php">Product</a></li>
        </ol>
        <?php
        if(isset($_GET['id']) && isset($_GET['cat'])) {
        $id = $_GET["id"];
        $category = $_GET["cat"];
        $query_for_product =mysqli_query($con, "select * from product WHERE PRO_ID='$id'");
        $result_for_product =mysqli_fetch_assoc($query_for_product);
        ?>
    </div>
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4>Product Description</h4>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-4">
                            <div class="thumbnail">
                                <img class="im" src="image/prodcuts/<?php echo $result_for_product["CATEGORY"]?>/<?php echo $result_for_product["IMAGE"]; ?>">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h4><b><?php echo $category; ?></b></h4>
                            <hr style="border: 1px solid black">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <th>Name</th>
                                <th>Details</th>
                                </thead>
                                <tbody>
                                <tr class="info">
                                    <td>Brand Name</td>
                                    <td><?php echo $result_for_product["TITLE"]; ?></td>
                                </tr>
                                <?php
                                if($result_for_product["MODEL"]!=null){
                                ?>
                                <tr>
                                    <td>Model</td>
                                    <td><?php echo $result_for_product["MODEL"]; ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <?php
                                if($result_for_product["IMEI"]!=0){
                                ?>
                                <tr class="info">
                                    <td>Imei</td>
                                    <td><?php echo $result_for_product["IMEI"]; ?></td>
                                </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td>description</td>
                                    <td><?php $desc=explode(",",$result_for_product["DESCRIPTION"]);for ($round=0;$round<sizeof($desc);$round++){echo $desc[$round]."<br>";}?></td>

                                </tr>
                                <tr>
                                    <td>Price</td>
                                    <td><?php echo $result_for_product["PRICE"]; ?></td>
                                </tr>
                                </tbody>
                            </table>
                            <button class=" btn-lg btn-info" type="button" onclick="location.href='product.php?atc=<?php echo $id;?>&cat=<?php echo $category?>'">Add to cart</button>
                            <button class=" btn-lg btn-success"><a class="a" href="cart.php?bn=<?php echo $result_for_product["PRO_ID"];?>&cat=<?php echo $result_for_product["CATEGORY"];?>">Buy now</a></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-body">
                            <?php
                            $c=$result_for_product["CATEGORY"];
                            $result_for_related_Products=mysqli_query($con,"select * from product where CATEGORY='$c' limit 4");
                            while ($fetch_for_related_Products=mysqli_fetch_assoc($result_for_related_Products)) {

                                ?>
                                <div class="col-md-3">
                                    <div class="thumbnail">
                                        <img class="im"
                                             src="image/prodcuts/<?php echo $fetch_for_related_Products["CATEGORY"];?>/<?php echo $fetch_for_related_Products["IMAGE"]; ?>">
                                        <br>
                                        <center>
                                            <label><?php echo $fetch_for_related_Products["TITLE"];?><br>Price :<?php echo $fetch_for_related_Products["PRICE"];?></label>
                                            <br>
                                            <button class="btn-info" type="button" onclick="location.href='product.php?atc=<?php echo $fetch_for_related_Products["PRO_ID"];?>&cat=<?php echo $category;?>'">Add to cart</button>
                                            <button class="btn-success"><a class="a" href="product.php?id=<?php echo $fetch_for_related_Products["PRO_ID"];?>&cat=<?php echo $category;?>">View details>></a></button>
                                        </center>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!--footer starts-->
<?php
}elseif(isset($_GET['cat_type'])) {
    ?>
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <div class="panel-info">
                    <div class="panel-body">
                <?php
                $cat_type = $_GET['cat_type'];
                $query_for_category_type = mysqli_query($con, "select * from product where CATEGORY='$cat_type'");
                $count = 0;
                $compare=0;
                while ($compare<mysqli_num_rows($query_for_category_type)) {
                    if ($count < 2) {
                        $fetch_for_category=mysqli_fetch_assoc($query_for_category_type);
                        ?>
                        <div class="col-md-6">
                            <div class="thumbnail">
                                <img class="im"
                                     src="image/prodcuts/<?php echo $cat_type;?>/<?php echo $fetch_for_category["IMAGE"]; ?>">
                                <br>
                                <center>
                                    <label><?php echo $fetch_for_category["TITLE"];?><br>Price :<?php echo $fetch_for_category["PRICE"];?></label>
                                    <br>
                                    <button class="btn-info" type="button" onclick="location.href='product.php?atc=<?php echo $fetch_for_category['PRO_ID'];?>&cat=<?php echo $cat_type;?>'">Add to cart</button>
                                    <button class="btn-success"><a class="a" href="product.php?id=<?php echo $fetch_for_category['PRO_ID'];?>&cat=<?php echo $cat_type;?>">View details>></a></button>
                                </center>
                            </div>
                        </div>

                        <?php
                        $count++;
                        $compare++;
                    } else {
                        ?>
                        <br>
                        <?php
                        $count = 0;
                    }
                }
                ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}else{?>
<div class="container">
    <div class="col-md-12">
        <div class="row">
            <div class="panel-info">
                <div class="panel-body">
                    <?php
                    $page_no=isset($_GET["pg_id"])?$_GET["pg_id"]:1;
                    $rows=6;
                    $start=($page_no-1)*$rows;
                    $query_for_category_type = mysqli_query($con, "select * from product limit $start,$rows");
                    $count = 0;
                    $compare=0;
                    while ($compare<mysqli_num_rows($query_for_category_type)) {
                        if ($count < 2) {
                            $fetch_for_category=mysqli_fetch_assoc($query_for_category_type);
                            ?>
                            <div class="col-md-6">
                                <div class="thumbnail">
                                    <img class="im"
                                         src="image/prodcuts/<?php echo $fetch_for_category["CATEGORY"]?>/<?php echo $fetch_for_category["IMAGE"];?>">
                                    <br>
                                    <center>
                                        <label><?php echo $fetch_for_category["TITLE"];?><br>Price :<?php echo $fetch_for_category["PRICE"];?></label>
                                        <br>
                                        <button class="btn-info" type="button" onclick="location.href='product.php?atc=<?php echo $fetch_for_category['PRO_ID'];?>&cat=<?php echo $fetch_for_category["CATEGORY"];?>'">Add to cart</button>
                                        <button class="btn-success"><a class="a" href="product.php?id=<?php echo $fetch_for_category['PRO_ID'];?>&cat=<?php echo $fetch_for_category["CATEGORY"];?>">View details>></a></button>
                                    </center>
                                </div>
                            </div>

                            <?php
                            $count++;
                            $compare++;
                        } else {
                            ?>
                            <br>
                            <?php
                            $count = 0;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
    <center>
    <ul class="pagination justify-content-center">
        <?php if($page_no!=1){?>
        <li class="page-item">
            <a class="page-link" href="product.php?pg_id=<?php echo $page_no-1?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li><?php }
        ?>
        <?php

       $count_of_record= mysqli_query($con,"SELECT COUNT(PRO_ID) from product");
        $no_of_pages=ceil((int)mysqli_fetch_assoc($count_of_record)['COUNT(PRO_ID)']/$rows);
        for ($pg_no=1;$pg_no<=$no_of_pages;$pg_no++) {
            ?>

                <?php
                if($page_no==$pg_no) {
                    ?>
                    <li class="page-item">
                    <a  style="color: #f1001e !important;" class="page-link" href="product.php?pg_id=<?php echo $pg_no ?>"><?php echo $pg_no ?></a>
                    </li>
                    <?php
                }
                else {
                    ?>
                    <li class="page-item">
                    <a style="color: black !important;" class="page-link" href="product.php?pg_id=<?php echo $pg_no?>"><?php echo $pg_no?></a>
                    </li>
                    <?php
                }
                ?>

            <?php
        }
        ?>
        <?php if($page_no!=$no_of_pages){?>
        <li class="page-item">
            <a class="page-link" href="product.php?pg_id=<?php echo $page_no+1?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
        <?php
        }
        ?>
    </ul>
    </center>
<?php
        }
include "footer.php";
?>
<!--footer ends-->
<script type="text/javascript" src="vendor/jquery/jquery.js"></script>
</body>
</html>