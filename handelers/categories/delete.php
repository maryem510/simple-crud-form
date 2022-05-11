<?php

use Core\DB;

include_once '../../core/session.php';
include_once "../../core/DB.php";

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {

    //create instance from database class
    $db = new DB();
    $id = $_GET['id'];
    $db->table('categories');
    if ($db->delete($id)) {
        setSession('success', "Category Deleted Successfully");
        header("Location:../../categories/index.php");
        exit();
    }
} else {

    header("Location:../../categories/index.php");
    die();
}
