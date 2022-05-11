<?php

use Core\DB;

include_once '../../core/Validation.php';
include_once '../../core/session.php';
include_once("../../core/DB.php");


if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

    //sanitize inputs
    $name = ['name' => 'Product Name', 'value' => $_POST['name']];
    $category_id = $_POST['category_id'];
    $errors = [];
    $imgName = $_FILES['img']['name'];
    $imgType = $_FILES['img']['type'];
    $imgTmp = $_FILES['img']['tmp_name'];
    $imgSize = $_FILES['img']['size'];

    $allowedExt = ['jpeg', 'jpg', 'png', 'gif'];
    $explodes = explode('.', $imgName);
    $imgExt = strtolower(end($explodes));

    //create instance from validation class
    $val = new Validation();

    //validate product name
    $val->stringVal($name['name'], $name['value']);
    $val->requiredVal($name['name'], $name['value']);
    $val->minVal($name['name'], $name['value'], 3);
    $val->maxVal($name['name'], $name['value'], 50);

    //validate product image
    if (empty($imgName)) {
        $errors[] = "Product image Is Required";
    } elseif (!in_array($imgExt, $allowedExt)) {

        $errors[] = "This extention is not allowed";
    } elseif ($imgSize > 5242880) {

        $errors[] = "Image size should be less than 5MB";
    }


    if (!$val->isSuccess()) {
        setSession('errors', $val->getErrors());
        header("Location:../../products/add.php");
        die();
    } else {
        //move image
        $img = time() . '_' . $imgName;
        move_uploaded_file($imgTmp, "../../uploads/images/products/" . $img);
        //create instance from database class
        $db = new DB();
        $data = ['name' => $name['value'], 'img' => $img, 'category_id' => $category_id];
        $db->table('products')->insert($data);
        if ($db->save()) {
            setSession('success', "Ptoduct inserted Successfully");
            header("Location:../../products/index.php");
            exit();
        }
    }
} else {

    header("Location:../../products/index.php");
    die();
}
