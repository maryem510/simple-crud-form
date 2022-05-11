<?php include_once "../inc/header.php"; ?>
<?php include_once '../core/session.php'; ?>
<?php include_once("../core/connect.php");  ?>

<?php
$id = $_GET['id'];
$sql = "SELECT * FROM `categories`  WHERE `id`='$id' ";
$result = mysqli_query($conn, $sql);
$category = mysqli_fetch_assoc($result);
?>

<div class="container">

    <h1 class="my-5 text-center"> Edit Category <?= $category['name'] ?></h1>

    <?php include_once "../inc/messages.php"; ?>

    <div class="col-md-6 offset-md-3">
        <form action="../handelers/categories/update.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
                <label for="name ">Category Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $category['name'] ?> " placeholder="second category">
            </div>

            <div class="form-group">
                <label for="name "> Category Description</label>
                <input type="text" class="form-control" id="description" name="description" value="<?= $category['description'] ?> " placeholder="Category Description">
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
    </div>
    <?php include_once "../inc/footer.php"; ?>