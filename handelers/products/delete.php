<?php

use Core\DB;

include_once "../../core/DB.php";
include_once '../../core/Validation.php';
include_once '../../core/session.php';


if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {

    $id = $_GET['id'];
    $sql = "SELECT  * FROM `products` WHERE `id` ='$id'";

    //check if this product exists

        //create instance from database class
        $db = new DB();
        $id = $_GET['id'];
        $db->table('products');
        //delete image  
        unlink("../../uploads/images/products/" . $product['img']);
        if ($db->delete($id)) {
            setSession('success', "Product delete Successfully");
            header("Location:../../products/index.php");
            exit();
        }
    
} else {

    header("Location:../../products/index.php");
}
