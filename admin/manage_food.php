<?php
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

include "../backend/conn.php";

$result = mysqli_query($conn, "SELECT * FROM foods ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Food</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        h1 {
            color: #333;
        }

        .btn {
            padding: 10px 16px;
            text-decoration: none;
            border-radius: 6px;
            color: white;
            display: inline-block;
            margin-left: 5px;
        }

        .dashboard {
            background: #3498db;
        }

        .add {
            background: #27ae60;
        }

        .food-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .food-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.12);
        }

        .food-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .content {
            padding: 18px;
        }

        .content h2 {
            margin-top: 0;
        }

        .description {
            color: #666;
            min-height: 45px;
        }

        .price {
            font-size: 20px;
            font-weight: bold;
            color: #27ae60;
            margin: 12px 0;
        }

        .edit {
            background: #f39c12;
        }

        .delete {
            background: #e74c3c;
        }

        .actions {
            margin-top: 15px;
        }

        .empty {
            background: white;
            padding: 40px;
            text-align: center;
            border-radius: 10px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">

        <h1>🍔 Manage Food</h1>

        <div>
            <a href="dashboard.php" class="btn dashboard">
                ← Dashboard
            </a>

            <a href="add_food.php" class="btn add">
                + Add Food
            </a>
        </div>

    </div>


    <?php if (mysqli_num_rows($result) > 0): ?>

        <div class="food-grid">

            <?php while ($food = mysqli_fetch_assoc($result)): ?>

                <div class="food-card">

                    <img
                        src="../uploads/food/<?= htmlspecialchars($food["image"]) ?>"
                        alt="<?= htmlspecialchars($food["name"]) ?>"
                    >

                    <div class="content">

                        <h2>
                            <?= htmlspecialchars($food["name"]) ?>
                        </h2>

                        <p class="description">
                            <?= htmlspecialchars($food["description"]) ?>
                        </p>

                        <div class="price">
                            ₹<?= number_format((float)$food["price"], 2) ?>
                        </div>

                        <div class="actions">

                            <a
                                href="edit_food.php?id=<?= (int)$food["id"] ?>"
                                class="btn edit"
                            >
                                ✏️ Edit
                            </a>

                            <a
                                href="delete_food.php?id=<?= (int)$food["id"] ?>"
                                class="btn delete"
                                onclick="return confirm('Are you sure you want to delete this food?');"
                            >
                                🗑️ Delete
                            </a>

                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

        </div>

    <?php else: ?>

        <div class="empty">
            <h2>No Food Items Found</h2>
            <p>Please add a food item first.</p>

            <a href="add_food.php" class="btn add">
                + Add Food
            </a>
        </div>

    <?php endif; ?>

</div>

</body>
</html>