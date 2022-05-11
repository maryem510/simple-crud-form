<?php include_once "../inc/header.php"; ?>
<?php include_once '../core/session.php'; ?>
<?php include_once("../core/connect.php");  ?>


<?php

$id = $_GET['id'];
$sql = "SELECT products.*, categories.name AS category_name, categories.id AS category_id 
FROM `products` INNER JOIN `categories` ON categories.id = products.category_id 
WHERE products.id='$id' ;  ";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

?>

<div class="container">

    <h1 class="my-5 text-center"> Edit Product- <?= $product['name'] ?></h1>
    <?php include_once "../inc/messages.php"; ?>

    <div class="col-md-6 offset-md-3">
        <form action="../handelers/products/update.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
                <label for="name ">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $product['name'] ?> ">
            </div>

        
            <div class="form-group">
                <label for="img "> Product Image</label>
                <input type="file" class="form-control" id="description" name="img">
            </div>


            <div class="mb-3">
              
                <?php
                $sql = "SELECT `name`,`id` FROM `categories`  ";
                $result = mysqli_query($conn, $sql);
                $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
                ?>
                <label  > Category Name </label>
                <select  name="category_id"  class="form-control"  >
                
                    <?php foreach ($categories as $category) {    ?>
                        <option <?php if($product ['category_id']===$category['id']) { echo "selected"; } ?> svalue="<?= $category['id'] ?>"> <?= $category['name'] ?> </option>
                    <?php } ?>
                
                </select>
                
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Edit</button>
        </form>
    </div>
    <?php include_once "../inc/footer.php"; ?>