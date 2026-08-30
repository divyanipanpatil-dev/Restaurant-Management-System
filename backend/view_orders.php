<?php

include "conn.php";


$result = mysqli_query(
    $conn,
    "SELECT * FROM orders
     ORDER BY created_at DESC"
);


if (!$result) {

    die(
        "Error loading orders: " .
        mysqli_error($conn)
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

    <title>Restaurant Orders</title>


    <style>

        * {
            box-sizing: border-box;
        }

        body {

            font-family:
                Arial,
                sans-serif;

            background: #f8f6f1;

            margin: 0;

            padding: 20px;

        }


        .container {

            max-width: 1200px;

            margin: auto;

            background: white;

            padding: 25px;

            border-radius: 12px;

            box-shadow:
                0 6px 20px
                rgba(0,0,0,0.15);

        }


        h1 {

            text-align: center;

            color: #4e342e;

            margin-bottom: 20px;

        }


        .top-bar {

            display: flex;

            justify-content:
                space-between;

            align-items: center;

            margin-bottom: 20px;

        }


        .back-btn {

            background: #2196f3;

            color: white;

            text-decoration: none;

            padding: 10px 15px;

            border-radius: 6px;

        }


        .back-btn:hover {

            background: #1976d2;

        }


        table {

            width: 100%;

            border-collapse:
                collapse;

        }


        th,
        td {

            padding: 14px;

            text-align: left;

            border-bottom:
                1px solid #eee;

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


        tr:hover {

            background: #f9f2dc;

        }


        .badge {

            display:
                inline-block;

            background: #ffe082;

            color: #4e342e;

            padding: 6px 10px;

            margin-bottom: 5px;

            border-radius: 6px;

            font-size: 14px;

            font-weight: bold;

        }


        .total {

            color: #2e7d32;

            font-weight: bold;

        }


        .delete-btn {

            background: #f44336;

            color: white;

            border: none;

            padding: 8px 12px;

            border-radius: 5px;

            cursor: pointer;

        }


        .delete-btn:hover {

            background: #d32f2f;

        }


        .empty {

            text-align: center;

            padding: 30px;

            color: #777;

        }


        @media (max-width: 768px) {

            .container {

                padding: 15px;

            }


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

                margin-bottom: 20px;

                border:
                    1px solid #ddd;

                border-radius: 8px;

                padding: 10px;

            }


            td {

                display: flex;

                justify-content:
                    space-between;

                gap: 15px;

                border: none;

                border-bottom:
                    1px solid #eee;

            }


            td:last-child {

                border-bottom: none;

            }


            td::before {

                content:
                    attr(data-label);

                font-weight: bold;

                color: #4e342e;

            }


            .top-bar {

                flex-direction:
                    column;

                gap: 15px;

                align-items:
                    stretch;

            }


            .back-btn {

                text-align: center;

            }

        }

    </style>


    <script>

        function confirmDelete(id) {

            const answer =
                confirm(
                    "Are you sure you want to delete this order?"
                );


            if (answer) {

                window.location.href =
                    "delete_order.php?id=" +
                    id;

            }

        }

    </script>

</head>


<body>


<div class="container">


    <h1>
        📋 Restaurant Orders
    </h1>


    <div class="top-bar">

        <a
            href="/index.php"
            class="back-btn"
        >
            ← Back to Menu
        </a>

    </div>


    <table>


        <thead>

            <tr>

                <th>ID</th>

                <th>Customer</th>

                <th>Items</th>

                <th>Total</th>

                <th>Date & Time</th>

                <th>Action</th>

            </tr>

        </thead>


        <tbody>


        <?php

        if (
            mysqli_num_rows($result)
            > 0
        ):

        ?>


        <?php

        while (
            $row =
            mysqli_fetch_assoc($result)
        ):

        ?>


            <tr>


                <!-- ID -->

                <td data-label="ID">

                    <?=

                    (int)$row["id"]

                    ?>

                </td>


                <!-- Customer -->

                <td
                    data-label="Customer"
                >

                    <?=

                    htmlspecialchars(
                        $row[
                            "customer_name"
                        ],
                        ENT_QUOTES,
                        "UTF-8"
                    )

                    ?>

                </td>


                <!-- Items -->

                <td
                    data-label="Items"
                >

                <?php

                $items =
                    json_decode(
                        $row["items"],
                        true
                    );


                if (
                    is_array($items)
                ) {

                    foreach (
                        $items
                        as $item
                    ) {

                        ?>

                        <span
                            class="badge"
                        >

                            <?=

                            htmlspecialchars(
                                $item["item"],
                                ENT_QUOTES,
                                "UTF-8"
                            )

                            ?>

                            ×

                            <?=

                            (int)
                            $item["quantity"]

                            ?>

                        </span>

                        <br>

                        <?php

                    }

                }

                ?>

                </td>


                <!-- Total -->

                <td
                    data-label="Total"
                    class="total"
                >

                    ₹

                    <?=

                    number_format(
                        (float)
                        $row["total"],
                        2
                    )

                    ?>

                </td>


                <!-- Time -->

                <td
                    data-label="Date & Time"
                >

                    <?=

                    htmlspecialchars(
                        $row["created_at"],
                        ENT_QUOTES,
                        "UTF-8"
                    )

                    ?>

                </td>


                <!-- Delete -->

                <td
                    data-label="Action"
                >

                    <button
                        class="delete-btn"
                        onclick="confirmDelete(
                            <?= (int)
                            $row["id"] ?>
                        )"
                    >

                        Delete

                    </button>

                </td>


            </tr>


        <?php

        endwhile;

        ?>


        <?php else: ?>


            <tr>

                <td
                    colspan="6"
                    class="empty"
                >

                    No orders found.

                </td>

            </tr>


        <?php endif; ?>


        </tbody>


    </table>


</div>


</body>

</html>


<?php

mysqli_close($conn);

?>