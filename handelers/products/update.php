<?php

use Core\DB;

include_once '../../core/session.php';
include_once '../../core/Validation.php';
include_once "../../core/DB.php";

if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

    //sanitize inputs
    $name = ['name' => 'Product Name', 'value' => $_POST['name']];
    $category_id = $_POST['category_id'];
    $errors = [];
    $id = $_POST['id'];
    $sql = "SELECT * FROM `products`  WHERE `id`='$id' ";
    $result = mysqli_query($conn, $sql);

    //check if this product exists
    if (mysqli_num_rows($result) >= 1) {
        $product = mysqli_fetch_assoc($result);
        $img = $product['img'];
        $imgName = $_FILES['img']['name'];
        $imgType = $_FILES['img']['type'];
        $imgTmp = $_FILES['img']['tmp_name'];
        $imgSize = $_FILES['img']['size'];


        //create instance from validation class
        $val = new Validation();

        //validate product name
        $val->stringVal($name['name'], $name['value']);
        $val->requiredVal($name['name'], $name['value']);
        $val->minVal($name['name'], $name['value'], 3);
        $val->maxVal($name['name'], $name['value'], 50);

        if (!$val->isSuccess()) {
            setSession('errors', $val->getErrors());
            header("Location:../../products/edit.php?id=" . $id);
            exit();
        } else {

            //if user want to update image
            if (!empty($imgName)) {
                $allowedExt = ['jpeg', 'jpg', 'png', 'gif'];
                $explodes = explode('.', $imgName);
                $imgExt = strtolower(end($explodes));

                // Validate Product Image
                if (empty($imgName)) {
                    $errors[] = "Product Image Is Required";
                } elseif (!in_array($imgEXT, $allowedEXT)) {
                    $errors[] = "This Extension Is Not Allowed";
                } elseif ($imgSize > 5242880) {
                    $errors[] = "Image Size Should Be Less Than 5MB";
                }
                //move new image
                $img = time() . '_' . $imgName;
                move_uploaded_file($imgTmp, "../../uploads/images/products/" . $img);
                //delete old image   
                unlink("../../uploads/images/products/" . $product['img']);
            }

            //create instance from database class
            $db = new DB();
            $data = ['name' => $name['value'], 'img' => $img,'category_id'=>$category_id];
            $db->table('products')->where('id', '=', $id)->update($data);
            if ($db->save()) {
                setSession('success', "Product Updated Successfully");
                header("Location:../../products/index.php");
                exit;
            }
        }
    } else {
        header("Location:../../products/index.php");
        die();
    }

}
header("Location:../../products/index.php");
