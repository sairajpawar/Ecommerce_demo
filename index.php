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
<!--    header started-->
    <?php
    include "header.php";
    ?>
        <!-- end of header--->

        <!---banner-->
            <div class="container-fluid">
                <div class="row">
                    <img src="image/banner/<?php $bannerresult=mysqli_query($con,"select * from banner");$banner_fetch=mysqli_fetch_assoc($bannerresult);echo $banner_fetch["banner"];?>" alt="" style="width:100%; height:450px;">
                </div>
            </div>
        <br>
    <?php
    $cat_result=mysqli_query($con,"select distinct CATEGORY from product");
    $count=1;
    while ($cat=mysqli_fetch_assoc($cat_result)) {
        $category=$cat['CATEGORY'];
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <?php
                    if($count==1){
                    ?>
                    <div class="thumbnail">
                        <img src="image/images/Diary-of-a-Wimpy-Kid-SDL908778899-1-634c9.jpg" alt="">
                        <br>
                        <center>
                            <button type="button" class="btn-lg btn-danger">View</button>
                        </center>
                    </div>
                    <?php
                    $count=0;
                    }

                    ?>
                </div>

                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <a href="product.php?cat_type=<?php echo $category;?>">><?php echo $category;?></a>
                                </div>
                                <div class="panel-body">
                                    <?php
                                    $count2=0;
                                    $select_query=mysqli_query($con,"select * from product WHERE CATEGORY='$category'");
                                    while ($p3 = mysqli_fetch_assoc($select_query)) {
                                        if($count2<4) {
                                            $product_id = $p3["PRO_ID"];
                                            $product_title = $p3["TITLE"];
                                            $product_name = $p3["MODEL"];
                                            $product_value = $p3["PRICE"];
                                            $product_img = $p3["IMAGE"];
                                            ?>
                                            <div class="col-md-3">

                                                <div class="thumbnail">
                                                    <a href="product.php?id=<?php echo $product_id ?>&cat=<?php echo $category ?>""><img class="im"
                                                                     src="image/prodcuts/<?php echo $category; ?>/<?php echo $product_img; ?>"></a>
                                                    <br>
                                                    <center>
                                                        <label>Product Name:<?php echo $product_title; ?>
                                                            <br>Price:<?php echo $product_value; ?></label>
                                                        <br>
                                                        <button class="btn-info" type="button"
                                                                onclick="location.href='product.php?atc=<?php echo $product_id; ?>&cat=<?php echo $category; ?>'">
                                                            Add to cart
                                                        </button>
                                                        <button class="btn-success"><a class="a"
                                                                                       href="product.php?id=<?php echo $product_id ?>&cat=<?php echo $category ?>">View
                                                                details>></a></button>
                                                    </center>
                                                </div>

                                            </div>
                                            <?php
                                            $count2++;
                                        }
                                        else
                                            {
                                                break;
                                            }
                                    }
                                    ?>


                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php
    }
    ?>

        <!--end of banner-->
<!--footer started-->
<?php
include "footer.php";
?>
<!--end of footer-->
        <script type="text/javascript" src="vendor/jquery/jquery.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>