<?php
session_start();
if(!$_SESSION['logout_session'])
{
    header("location:index.php");
}
else{
    include "../connection.php";
?>
    <html>
    <head>
        <title>Adding new product</title>
<!--        <script src="time"-->
    </head>
    <body>
    <a href="adminpanel.php">back to home</a>
    <form action="admin_product.php" method="post" enctype="multipart/form-data">
        <table align="center" width="750" border="2" bgcolor="orange">
            <tr align="center">
                <td colspan="8"><h2>Add new Product</h2></td>
            </tr>
            <tr>
                <td align="center">Select category:</td>

            <td>
                <select name="select_cat" onchange="location = this.options[this.selectedIndex].value;">
                    <?php
                    $mycategory=mysqli_query($con,"select distinct category from product");
                    echo "<option value='admin_product.php?cat'>Select category</option>";
                    while($rows=mysqli_fetch_assoc($mycategory))
                    {
                        $category=$rows["category"];
                        echo "<option value='admin_product.php?cat_name=$category' >$category</option>";
                    }
                    ?>
                </select>
                </select>
            </td>
            </tr>
        </table>
    </form>
    </body>
    </html>
<?php
}
?>
