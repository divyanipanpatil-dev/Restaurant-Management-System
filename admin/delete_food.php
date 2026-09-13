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
        $_GET["id"] ?? 0
    );


if ($id <= 0) {

    header(
        "Location: add_food.php"
    );

    exit;

}


// Get image

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


$food =
    mysqli_fetch_assoc($result);


if (!$food) {

    header(
        "Location: add_food.php"
    );

    exit;

}


// Delete database record

$stmt =
    mysqli_prepare(
        $conn,
        "DELETE FROM foods
         WHERE id = ?"
    );


mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);


if (
    mysqli_stmt_execute($stmt)
) {


    $imagePath =
        "../uploads/food/" .
        $food["image"];


    if (
        file_exists($imagePath)
    ) {

        unlink($imagePath);

    }


    header(
        "Location: add_food.php?deleted=1"
    );

    exit;

}


die(
    "Unable to delete food."
);

?>