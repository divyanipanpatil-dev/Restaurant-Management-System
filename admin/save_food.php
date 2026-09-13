<?php

session_start();


if (
    !isset($_SESSION["admin_id"])
) {

    header(
        "Location: login.php"
    );

    exit;

}


include "../backend/conn.php";


if (
    $_SERVER["REQUEST_METHOD"] !== "POST"
) {

    header(
        "Location: add_food.php"
    );

    exit;

}


$name =
    trim(
        $_POST["name"] ?? ""
    );


$description =
    trim(
        $_POST["description"] ?? ""
    );


$price =
    $_POST["price"] ?? "";


if (
    $name === "" ||
    $description === "" ||
    !is_numeric($price) ||
    $price < 0
) {

    die(
        "Invalid food information."
    );

}


if (
    !isset($_FILES["image"]) ||
    $_FILES["image"]["error"] !== UPLOAD_ERR_OK
) {

    die(
        "Please select a food image."
    );

}


$image =
    $_FILES["image"];


if (
    $image["size"] > 5 * 1024 * 1024
) {

    die(
        "Image size must be less than 5 MB."
    );

}


$mime =
    mime_content_type(
        $image["tmp_name"]
    );


$allowed = [

    "image/jpeg" => "jpg",

    "image/png" => "png",

    "image/webp" => "webp"

];


if (
    !isset($allowed[$mime])
) {

    die(
        "Only JPG, PNG and WEBP images are allowed."
    );

}


$uploadDir =
    "../uploads/food/";


if (
    !is_dir($uploadDir)
) {

    mkdir(
        $uploadDir,
        0755,
        true
    );

}


$extension =
    $allowed[$mime];


$fileName =
    uniqid(
        "food_",
        true
    ) .
    "." .
    $extension;


$target =
    $uploadDir .
    $fileName;


if (
    !move_uploaded_file(
        $image["tmp_name"],
        $target
    )
) {

    die(
        "Failed to upload image."
    );

}


$price =
    (float)$price;


$stmt =
    mysqli_prepare(
        $conn,
        "INSERT INTO foods
        (name, description, price, image)
        VALUES (?, ?, ?, ?)"
    );


mysqli_stmt_bind_param(
    $stmt,
    "ssds",
    $name,
    $description,
    $price,
    $fileName
);


if (
    mysqli_stmt_execute($stmt)
) {

    header(
        "Location: add_food.php?success=1"
    );

    exit;

}


unlink($target);


die(
    "Failed to save food item."
);

?>