
<?php include_once '../core/session.php'; ?>
<?php include_once "../inc/header.php"; ?>


<div class="container">

    <h1 class="my-5 text-center"> Add New Category</h1>

    <?php include_once "../inc/messages.php"; ?>

    <form action="../handelers/categories/add.php" method="POST">
        <input type="hidden" value="<?= $id ?> ">
        <div class="mb-3">
            <label for="name ">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Category Name">
        </div>

        <div class="mb-3">
            <label for="name "> Category Description</label>
            <input type="text" class="form-control" id="description" name="description" placeholder="Category Description">
        </div>

        <button type="submit" class="btn btn-primary" name="submit">ADD</button>
    </form>
</div>

<?php include_once "../inc/footer.php"; ?>