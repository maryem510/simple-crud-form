<?php

use Core\DB;

include_once "../../core/connect.php";
include_once '../../core/session.php';
include_once("../../core/DB.php");
include_once '../../core/Validation.php';

if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

    //form inputs
    $name = ['name' => 'Category Name', 'value' => $_POST['name']];
    $description = ['name' => 'Category Description', 'value' => $_POST['description']];
    $id = $_POST['id'];
    $sql = "SELECT * FROM `categories`  WHERE `id`='$id' ";
    $result = mysqli_query($conn, $sql);

    //create instance from validation class
    $val = new Validation();

    //validate inputs
    $val->stringVal($name['name'], $name['value']);
    $val->requiredVal($name['name'], $name['value']);
    $val->minVal($name['name'], $name['value'], 3);
    $val->maxVal($name['name'], $name['value'], 50);

    $val->stringVal($description['name'], $description['value']);
    $val->requiredVal($description['name'], $description['value']);
    $val->minVal($description['name'], $description['value'], 3);

    if (!$val->isSuccess()) {
        setSession('errors', $val->getErrors());
        header("Location:../../categories/edit.php");
        die();
    } else {
        //create instance from database class
        $db = new DB();
        $data = ['name' => $name['value'], 'description' => $description['value']];
        $db->table('categories')->where('id', '=', $id)->update($data);
        if ($db->save()) {
            setSession('success', "Category updated Successfully");
            header("Location:../../categories/index.php");
        }
    }
} else {

    header("Location:../../categories/index.php");
    die();
}

