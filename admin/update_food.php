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


$id =
    (int)(
        $_POST["id"] ?? 0
    );


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
    $id <= 0 ||
    $name === "" ||
    $description === "" ||
    !is_numeric($price) ||
    $price < 0
) {

    die(
        "Invalid data."
    );

}


$price =
    (float)$price;


// ==========================================
// GET CURRENT IMAGE
// ==========================================

$stmt =
    mysqli_prepare(
        $conn,
        "SELECT image
         FROM foods
         WHERE id = ?"
    );


mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);


mysqli_stmt_execute($stmt);


$result =
    mysqli_stmt_get_result($stmt);


$current =
    mysqli_fetch_assoc($result);


if (!$current) {

    die(
        "Food item not found."
    );

}


$currentImage =
    $current["image"];


// ==========================================
// IF NEW IMAGE PROVIDED
// ==========================================

if (
    isset($_FILES["image"]) &&
    $_FILES["image"]["error"] ===
        UPLOAD_ERR_OK
) {


    $image =
        $_FILES["image"];


    if (
        $image["size"] >
        5 * 1024 * 1024
    ) {

        die(
            "Image must be less than 5 MB."
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
            "Invalid image type."
        );

    }


    $uploadDir =
        "../uploads/food/";


    $newImage =
        uniqid(
            "food_",
            true
        ) .
        "." .
        $allowed[$mime];


    $target =
        $uploadDir .
        $newImage;


    if (
        !move_uploaded_file(
            $image["tmp_name"],
            $target
        )
    ) {

        die(
            "Image upload failed."
        );

    }


    // Delete old image

    $oldImage =
        $uploadDir .
        $currentImage;


    if (
        file_exists($oldImage)
    ) {

        unlink($oldImage);

    }


    $currentImage =
        $newImage;

}


// ==========================================
// UPDATE DATABASE
// ==========================================

$stmt =
    mysqli_prepare(
        $conn,
        "UPDATE foods
         SET name = ?,
             description = ?,
             price = ?,
             image = ?
         WHERE id = ?"
    );


mysqli_stmt_bind_param(
    $stmt,
    "ssdsi",
    $name,
    $description,
    $price,
    $currentImage,
    $id
);


if (
    mysqli_stmt_execute($stmt)
) {

    header(
        "Location: add_food.php?updated=1"
    );

    exit;

}


die(
    "Unable to update food."
);

?>