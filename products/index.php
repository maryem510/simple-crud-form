<?php include_once "../inc/header.php"; ?>
<?php include_once "../inc/nav.php"; ?>
<?php include_once '../core/session.php'; ?>
<?php include_once("../core/connect.php");  ?>


<?php 
$sql = "SELECT products.*, categories.name AS category_name, categories.id AS category_id FROM `products` INNER JOIN `categories` ON categories.id = products.category_id; ";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<div class="container">

    <a href="add.php">
        <button class="btn btn-primary my-5">Add Product </button>
    </a>

    <?php include_once "../inc/messages.php"; ?>

    <?php if (mysqli_num_rows($result) >= 1) {  ?>
        <table class="table">
            <thead>
                <tr>

                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Image</th>
                    <th scope="col"> Related category</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($products as $product) {   ?>
                    <tr>
                        <th> <?= $i++; ?> </th>
                        <td> <?= $product['name'] ?></td>
                        <td>
                            <img src="../uploads/images/products/<?= $product['img'] ?>" alt="Photo" style="width:50px;height:70px;border-radius:50%;">
                        </td>

                        <td>
                            <?= $product['category_name'] ?>

                        </td>
                        <td>
                            <a class=" text-light " href="../handelers/products/delete.php?id=<?= $product['id'] ?>">
                                <button class="btn  btn-danger text-light">Delete </button>
                            </a>
                            <a class=" text-light " href=" edit.php?id=<?= $product['id'] ?>">
                                <button class="btn  btn-info text-light">Edit </button>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php  } else {

        echo "<h2>There are no products to show</h2>";
    } ?>
</div>

<?php include_once "../inc/footer.php"; ?>