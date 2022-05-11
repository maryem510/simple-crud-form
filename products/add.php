<?php include_once "../inc/header.php"; ?>
<?php include_once '../core/session.php'; ?>
<?php include_once("../core/connect.php");  ?>



<div class="container">

    <h1 class="my-5 text-center"> Add New Product</h1>

    <?php include_once "../inc/messages.php"; ?>

    <form action="../handelers/products/add.php" method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label for="name ">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Product Name">
        </div>

        <div class="mb-3">
            <label for="img "> Product Image</label>
            <input type="file" class="form-control" id="description" name="img">
        </div>

        <div class="mb-3">
            <?php
            $sql = "SELECT `name`,`id` FROM `categories`";
            $result = mysqli_query($conn, $sql);
            $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);  ?>
            <label for="img "> Select category</label>
            <select name="category_id" class="form-control">
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category['id'] ?>"> <?= $category['name'] ?> </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" name="submit">ADD</button>
    </form>
</div>

<?php include_once "../inc/footer.php"; ?>