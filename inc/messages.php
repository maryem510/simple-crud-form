<?php
if (isset($_SESSION['success'])) {
?>
    <div class="alert alert-success"><?= $_SESSION['success']; ?>
    </div>
<?php unset($_SESSION['success']);
} elseif (isset($_SESSION['errors'])) {
?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($_SESSION['errors'] as $error) {
                echo "<li>" . $error . "</li>";
            }
            unset($_SESSION['errors']);
            ?>
        </ul>
    </div>
<?php }  ?>