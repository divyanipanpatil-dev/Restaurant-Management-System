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


$result = mysqli_query(
    $conn,
    "SELECT * FROM foods
     ORDER BY id DESC"
);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Manage Food</title>


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

            max-width: 1100px;

            margin: auto;

        }


        .top {

            display: flex;

            justify-content:
                space-between;

            align-items: center;

            margin-bottom: 20px;

        }


        .top a {

            text-decoration: none;

            background: #2196f3;

            color: white;

            padding: 10px 15px;

            border-radius: 6px;

        }


        .box {

            background: white;

            padding: 25px;

            border-radius: 12px;

            margin-bottom: 25px;

            box-shadow:
                0 4px 15px
                rgba(0,0,0,0.10);

        }


        h1,
        h2 {

            color: #4e342e;

        }


        h2 {

            margin-bottom: 20px;

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

            resize: vertical;

        }


        .submit-btn {

            width: 100%;

            padding: 13px;

            border: none;

            border-radius: 6px;

            background: #4caf50;

            color: white;

            font-size: 17px;

            cursor: pointer;

        }


        table {

            width: 100%;

            border-collapse:
                collapse;

        }


        th,
        td {

            padding: 12px;

            border-bottom:
                1px solid #eee;

            text-align: left;

        }


        th {

            background:
                linear-gradient(
                    135deg,
                    #d4af37,
                    #b8860b
                );

            color: white;

        }


        .food-image {

            width: 80px;

            height: 60px;

            object-fit: cover;

            border-radius: 6px;

        }


        .edit {

            background: #2196f3;

            color: white;

            padding: 7px 10px;

            border-radius: 5px;

            text-decoration: none;

            display: inline-block;

            margin-right: 5px;

        }


        .delete {

            background: #f44336;

            color: white;

            padding: 7px 10px;

            border-radius: 5px;

            text-decoration: none;

            display: inline-block;

        }


        @media (max-width: 700px) {

            table,
            thead,
            tbody,
            th,
            td,
            tr {

                display: block;

            }


            thead {

                display: none;

            }


            tr {

                background: white;

                margin-bottom: 15px;

                border: 1px solid #ddd;

                border-radius: 8px;

                padding: 10px;

            }


            td {

                display: flex;

                justify-content:
                    space-between;

                gap: 10px;

                border: none;

                border-bottom:
                    1px solid #eee;

            }


            td::before {

                content:
                    attr(data-label);

                font-weight: bold;

            }

        }

    </style>


    <script>

        function deleteFood(id) {

            if (
                confirm(
                    "Are you sure you want to delete this food?"
                )
            ) {

                window.location.href =
                    "delete_food.php?id=" +
                    id;

            }

        }

    </script>

</head>


<body>


<div class="container">


    <div class="top">

        <h1>
            🍔 Food Management
        </h1>

        <a href="dashboard.php">
            ← Dashboard
        </a>

    </div>


    <!-- ADD FOOD FORM -->

    <div class="box">


        <h2>
            ➕ Add New Food Item
        </h2>


        <form
            action="save_food.php"
            method="POST"
            enctype="multipart/form-data"
        >


            <div class="form-group">

                <label>
                    Food Name
                </label>

                <input
                    type="text"
                    name="name"
                    placeholder="Example: Chicken Burger"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Description
                </label>

                <textarea
                    name="description"
                    placeholder="Enter food description"
                    required
                ></textarea>

            </div>


            <div class="form-group">

                <label>
                    Price (₹)
                </label>

                <input
                    type="number"
                    name="price"
                    min="0"
                    step="0.01"
                    placeholder="299"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Food Image
                </label>

                <input
                    type="file"
                    name="image"
                    accept="image/jpeg,image/png,image/webp"
                    required
                >

            </div>


            <button
                type="submit"
                class="submit-btn"
            >

                ➕ Add Food

            </button>


        </form>


    </div>


    <!-- FOOD LIST -->

    <div class="box">


        <h2>
            📋 Existing Food Items
        </h2>


        <table>


            <thead>

                <tr>

                    <th>ID</th>

                    <th>Image</th>

                    <th>Name</th>

                    <th>Description</th>

                    <th>Price</th>

                    <th>Action</th>

                </tr>

            </thead>


            <tbody>


            <?php while (
                $food =
                mysqli_fetch_assoc($result)
            ): ?>


                <tr>


                    <td data-label="ID">

                        <?= (int)$food["id"] ?>

                    </td>


                    <td data-label="Image">

                        <img
                            src="../uploads/food/<?= htmlspecialchars(
                                $food["image"],
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>"
                            class="food-image"
                            alt="Food"
                        >

                    </td>


                    <td data-label="Name">

                        <?= htmlspecialchars(
                            $food["name"],
                            ENT_QUOTES,
                            "UTF-8"
                        ) ?>

                    </td>


                    <td data-label="Description">

                        <?= htmlspecialchars(
                            $food["description"],
                            ENT_QUOTES,
                            "UTF-8"
                        ) ?>

                    </td>


                    <td data-label="Price">

                        ₹<?= number_format(
                            (float)$food["price"],
                            2
                        ) ?>

                    </td>


                    <td data-label="Action">


                        <a
                            href="edit_food.php?id=<?= (int)$food["id"] ?>"
                            class="edit"
                        >
                            Edit
                        </a>


                        <a
                            href="#"
                            onclick="deleteFood(
                                <?= (int)$food["id"] ?>
                            ); return false;"
                            class="delete"
                        >
                            Delete
                        </a>


                    </td>


                </tr>


            <?php endwhile; ?>


            </tbody>


        </table>


    </div>


</div>


</body>

</html>