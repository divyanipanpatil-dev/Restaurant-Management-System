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


$foodResult = mysqli_query(
    $conn,
    "SELECT * FROM foods
     ORDER BY id DESC"
);


$orderResult = mysqli_query(
    $conn,
    "SELECT * FROM orders
     ORDER BY created_at DESC"
);


$foodCount =
    mysqli_num_rows($foodResult);


$orderCount =
    mysqli_num_rows($orderResult);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Admin Dashboard</title>


    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }


        body {

            font-family: Arial, sans-serif;

            background: #f5f5f5;

        }


        /* NAVBAR */

        .navbar {

            background:
                linear-gradient(
                    135deg,
                    #d4af37,
                    #b8860b
                );

            color: white;

            padding: 18px 30px;

            display: flex;

            justify-content:
                space-between;

            align-items: center;

        }


        .navbar h2 {

            font-size: 22px;

        }


        .logout {

            background: #f44336;

            color: white;

            padding: 9px 15px;

            border-radius: 6px;

            text-decoration: none;

        }


        .container {

            max-width: 1200px;

            margin: auto;

            padding: 30px 20px;

        }


        /* WELCOME */

        .welcome {

            margin-bottom: 25px;

        }


        .welcome h1 {

            color: #4e342e;

            margin-bottom: 5px;

        }


        /* CARDS */

        .cards {

            display: grid;

            grid-template-columns:
                repeat(
                    auto-fit,
                    minmax(220px, 1fr)
                );

            gap: 20px;

            margin-bottom: 30px;

        }


        .card {

            background: white;

            padding: 25px;

            border-radius: 12px;

            box-shadow:
                0 4px 15px
                rgba(0,0,0,0.10);

        }


        .card-icon {

            font-size: 35px;

        }


        .card h3 {

            margin-top: 10px;

            color: #555;

        }


        .card p {

            font-size: 30px;

            font-weight: bold;

            color: #2e7d32;

            margin-top: 5px;

        }


        /* ACTIONS */

        .actions {

            display: grid;

            grid-template-columns:
                repeat(
                    auto-fit,
                    minmax(220px, 1fr)
                );

            gap: 20px;

        }


        .action {

            display: block;

            background: white;

            padding: 25px;

            border-radius: 12px;

            text-decoration: none;

            color: #333;

            box-shadow:
                0 4px 15px
                rgba(0,0,0,0.10);

            transition: 0.3s;

        }


        .action:hover {

            transform:
                translateY(-4px);

        }


        .action-icon {

            font-size: 40px;

            margin-bottom: 10px;

        }


        .action h3 {

            color: #4e342e;

            margin-bottom: 8px;

        }


        .action p {

            color: #777;

        }

    </style>

</head>


<body>


<nav class="navbar">


    <h2>
        🍽 Restaurant Admin Panel
    </h2>


    <a
        href="logout.php"
        class="logout"
    >

        Logout

    </a>


</nav>


<div class="container">


    <div class="welcome">

        <h1>
            Welcome, <?= htmlspecialchars(
                $_SESSION["admin_username"]
            ) ?>
        </h1>

        <p>
            Manage your restaurant from here.
        </p>

    </div>


    <!-- STATISTICS -->

    <div class="cards">


        <div class="card">

            <div class="card-icon">
                🍔
            </div>

            <h3>
                Food Items
            </h3>

            <p>
                <?= $foodCount ?>
            </p>

        </div>


        <div class="card">

            <div class="card-icon">
                📋
            </div>

            <h3>
                Orders
            </h3>

            <p>
                <?= $orderCount ?>
            </p>

        </div>


    </div>


    <!-- ADMIN ACTIONS -->

    <div class="actions">


        <a
            href="add_food.php"
            class="action"
        >

            <div class="action-icon">
                ➕🍔
            </div>

            <h3>
                Add Food
            </h3>

            <p>
                Add a new food item with image,
                description and price.
            </p>

        </a>


        <a
            href="manage_food.php"
            class="action"
        >

            <div class="action-icon">
                ✏️
            </div>

            <h3>
                Manage Food
            </h3>

            <p>
                Edit or delete existing food items.
            </p>

        </a>


        <a
            href="../backend/view_orders.php"
            class="action"
        >

            <div class="action-icon">
                📋
            </div>

            <h3>
                View Orders
            </h3>

            <p>
                View customer orders.
            </p>

        </a>


        <a
            href="../index.php"
            class="action"
        >

            <div class="action-icon">
                🍽
            </div>

            <h3>
                View Restaurant
            </h3>

            <p>
                Open the customer menu.
            </p>

        </a>


    </div>


</div>


</body>

</html>