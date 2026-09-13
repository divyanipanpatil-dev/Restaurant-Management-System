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


$stmt =
    mysqli_prepare(
        $conn,
        "SELECT * FROM foods
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

    die(
        "Food item not found."
    );

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Food</title>


    <style>

        * {
            box-sizing: border-box;
        }


        body {

            font-family: Arial, sans-serif;

            background: #f5f5f5;

            padding: 20px;

        }


        .container {

            max-width: 650px;

            margin: auto;

        }


        .box {

            background: white;

            padding: 30px;

            border-radius: 12px;

            box-shadow:
                0 4px 15px
                rgba(0,0,0,0.10);

        }


        h1 {

            color: #4e342e;

            margin-bottom: 25px;

            text-align: center;

        }


        .form-group {

            margin-bottom: 18px;

        }


        label {

            display: block;

            font-weight: bold;

            margin-bottom: 7px;

        }


        input,
        textarea {

            width: 100%;

            padding: 12px;

            border: 1px solid #ccc;

            border-radius: 6px;

            font-size: 16px;

        }


        textarea {

            min-height: 100px;

        }


        .current-image {

            width: 180px;

            height: 130px;

            object-fit: cover;

            border-radius: 8px;

            margin-bottom: 10px;

        }


        button {

            width: 100%;

            padding: 13px;

            background: #2196f3;

            color: white;

            border: none;

            border-radius: 6px;

            font-size: 17px;

            cursor: pointer;

        }


        .back {

            display: block;

            text-align: center;

            margin-top: 15px;

            text-decoration: none;

        }

    </style>

</head>


<body>


<div class="container">


<div class="box">


<h1>
    ✏️ Edit Food
</h1>


<form
    action="update_food.php"
    method="POST"
    enctype="multipart/form-data"
>


    <input
        type="hidden"
        name="id"
        value="<?= (int)$food["id"] ?>"
    >


    <div class="form-group">

        <label>
            Food Name
        </label>

        <input
            type="text"
            name="name"
            value="<?= htmlspecialchars(
                $food["name"],
                ENT_QUOTES,
                "UTF-8"
            ) ?>"
            required
        >

    </div>


    <div class="form-group">

        <label>
            Description
        </label>

        <textarea
            name="description"
            required
        ><?= htmlspecialchars(
            $food["description"],
            ENT_QUOTES,
            "UTF-8"
        ) ?></textarea>

    </div>


    <div class="form-group">

        <label>
            Price
        </label>

        <input
            type="number"
            name="price"
            min="0"
            step="0.01"
            value="<?= $food["price"] ?>"
            required
        >

    </div>


    <div class="form-group">

        <label>
            Current Image
        </label>

        <br>

        <img
            src="../uploads/food/<?= htmlspecialchars(
                $food["image"],
                ENT_QUOTES,
                "UTF-8"
            ) ?>"
            class="current-image"
        >

    </div>


    <div class="form-group">

        <label>
            Change Image
        </label>

        <input
            type="file"
            name="image"
            accept="image/jpeg,image/png,image/webp"
        >

        <small>
            Leave empty to keep the current image.
        </small>

    </div>


    <button type="submit">

        💾 Update Food

    </button>


</form>


<a
    href="add_food.php"
    class="back"
>
    ← Back to Food Management
</a>


</div>

</div>


</body>

</html>