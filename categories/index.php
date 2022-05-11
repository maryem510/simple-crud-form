<?php include_once "../inc/header.php"; ?>
<?php include_once "../inc/nav.php"; ?>
<?php include_once '../core/session.php'; ?>
<?php include_once("../core/connect.php");  ?>




<?php
$sql = "SELECT * FROM `categories`";
$result         = mysqli_query($conn, $sql);
$categories     = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<div class="container">

  <a href="add.php">
    <button class="btn btn-primary my-5">Add Category </button>
  </a>

  <?php include_once "../inc/messages.php"; ?>

  <?php  if(mysqli_num_rows($result) >= 1){ ?>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 0;
        foreach ($categories as $category) {
        ?>
          <tr>
            <th> <?= $i++; ?> </th>
            <td> <?= $category['name'] ?></td>
            <td> <?= $category['description'] ?></td>
            <td>
              <a class=" text-light " href="../handelers/categories/delete.php?id=<?= $category['id'] ?>">
                <button class="btn  btn-danger text-light">Delete </button>
              </a>

              <a class=" text-light " href=" edit.php?id=<?= $category['id'] ?>">
                <button class="btn  btn-info text-light">Edit </button>
              </a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php  } else {
    echo "<h2>There are no categories to show</h2>";
  } ?>
</div>

<?php include_once "../inc/footer.php"; ?>