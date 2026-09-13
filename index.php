<?php

include "backend/conn.php";

$result = mysqli_query(
    $conn,
    "SELECT * FROM foods ORDER BY id DESC"
);

if (!$result) {
    die("Unable to load food items.");
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

    <title>Restaurant Menu</title>

    <link
        rel="stylesheet"
        href="style.css"
    >

</head>


<body>


<div class="container">


    <!-- HEADER -->

    <div class="header">

        <h1>
            🍽 Restaurant Menu
        </h1>

        <p>
            Order your favourite food
        </p>

    </div>


    <!-- MENU -->

    <div class="menu-grid">


        <?php if (
            mysqli_num_rows($result) > 0
        ): ?>


            <?php while (
                $food =
                mysqli_fetch_assoc($result)
            ): ?>


                <div class="menu-item">


                    <!-- FOOD IMAGE -->

                    <img
                        src="uploads/food/<?= htmlspecialchars(
                            $food["image"],
                            ENT_QUOTES,
                            "UTF-8"
                        ) ?>"
                        alt="<?= htmlspecialchars(
                            $food["name"],
                            ENT_QUOTES,
                            "UTF-8"
                        ) ?>"
                        class="food-image"
                    >


                    <!-- FOOD NAME -->

                    <h3>

                        <?= htmlspecialchars(
                            $food["name"],
                            ENT_QUOTES,
                            "UTF-8"
                        ) ?>

                        -
                        ₹<?= number_format(
                            (float)$food["price"],
                            2
                        ) ?>

                    </h3>


                    <!-- DESCRIPTION -->

                    <p>

                        <?= htmlspecialchars(
                            $food["description"],
                            ENT_QUOTES,
                            "UTF-8"
                        ) ?>

                    </p>


                    <!-- ADD TO CART -->

                    <button
                        class="add-btn"
                        onclick='addToCart(
                            <?= json_encode(
                                $food["name"]
                            ) ?>,
                            <?= (float)$food["price"] ?>
                        )'
                    >

                        Add to Cart

                    </button>


                </div>


            <?php endwhile; ?>


        <?php else: ?>


            <div class="empty-menu">

                <h2>
                    🍽 No food items available
                </h2>

                <p>
                    Please check back later.
                </p>

            </div>


        <?php endif; ?>


    </div>


    <!-- CART -->

    <div class="cart-container">


        <h2>
            🛒 Your Order
        </h2>


        <div id="cart-items">

        </div>


        <div class="total-section">

            <h3>

                Total:
                ₹<span id="total">0.00</span>

            </h3>

        </div>


        <button
            class="order-btn"
            onclick="placeOrder()"
        >

            Place Order

        </button>


    </div>


</div>



<script>


// ==========================================
// CART
// ==========================================

let cart = [];


// ==========================================
// ADD TO CART
// ==========================================

function addToCart(
    item,
    price
) {


    const existingItem =
        cart.find(
            cartItem =>
                cartItem.item === item
        );


    if (existingItem) {

        existingItem.quantity++;

    } else {

        cart.push({

            item: item,

            price: price,

            quantity: 1

        });

    }


    updateCart();

}


// ==========================================
// UPDATE CART
// ==========================================

function updateCart() {


    const cartContainer =
        document.getElementById(
            "cart-items"
        );


    const totalElement =
        document.getElementById(
            "total"
        );


    cartContainer.innerHTML = "";


    if (cart.length === 0) {


        cartContainer.innerHTML = `

            <div class="empty-cart">

                🛒 Your cart is empty

            </div>

        `;


        totalElement.textContent =
            "0.00";


        return;

    }


    let total = 0;


    cart.forEach(
        (cartItem, index) => {


            const itemTotal =
                cartItem.price *
                cartItem.quantity;


            total += itemTotal;


            const div =
                document.createElement(
                    "div"
                );


            div.className =
                "cart-item";


            div.innerHTML = `

                <div class="cart-info">

                    <strong>
                        ${cartItem.item}
                    </strong>

                    <br>

                    <small>

                        ₹${cartItem.price}
                        ×
                        ${cartItem.quantity}
                        =
                        ₹${itemTotal.toFixed(2)}

                    </small>

                </div>


                <div class="quantity-controls">


                    <button
                        class="quantity-btn"
                        onclick="changeQuantity(
                            ${index},
                            -1
                        )"
                    >

                        −

                    </button>


                    <span class="quantity">

                        ${cartItem.quantity}

                    </span>


                    <button
                        class="quantity-btn"
                        onclick="changeQuantity(
                            ${index},
                            1
                        )"
                    >

                        +

                    </button>


                    <button
                        class="delete-btn"
                        onclick="removeFromCart(
                            ${index}
                        )"
                    >

                        Delete

                    </button>


                </div>

            `;


            cartContainer.appendChild(
                div
            );

        }
    );


    totalElement.textContent =
        total.toFixed(2);

}


// ==========================================
// CHANGE QUANTITY
// ==========================================

function changeQuantity(
    index,
    change
) {


    if (
        change === -1 &&
        cart[index].quantity === 1
    ) {

        cart.splice(
            index,
            1
        );

    } else {

        cart[index].quantity +=
            change;

    }


    updateCart();

}


// ==========================================
// REMOVE ITEM
// ==========================================

function removeFromCart(index) {

    cart.splice(
        index,
        1
    );

    updateCart();

}


// ==========================================
// PLACE ORDER
// ==========================================

function placeOrder() {


    if (cart.length === 0) {

        alert(
            "Your cart is empty!"
        );

        return;

    }


    const customerName =
        prompt(
            "Enter your name:"
        );


    if (
        !customerName ||
        customerName.trim() === ""
    ) {

        alert(
            "Please enter your name."
        );

        return;

    }


    let total = 0;


    cart.forEach(
        item => {

            total +=
                item.price *
                item.quantity;

        }
    );


    fetch(
        "backend/save_order.php",
        {

            method: "POST",

            headers: {

                "Content-Type":
                    "application/json"

            },

            body: JSON.stringify({

                name:
                    customerName.trim(),

                items:
                    cart,

                total:
                    total

            })

        }
    )


    .then(
        response => {

            if (!response.ok) {

                throw new Error(
                    "Server error: " +
                    response.status
                );

            }

            return response.json();

        }
    )


    .then(
        data => {


            if (
                data.status ===
                "success"
            ) {


                alert(

                    "✅ Order placed successfully!\n\n" +

                    "Customer: " +
                    customerName +

                    "\nTotal: ₹" +
                    total.toFixed(2)

                );


                cart = [];


                updateCart();


            } else {


                alert(

                    "❌ Order failed!\n\n" +
                    (
                        data.message ||
                        "Unknown error"
                    )

                );

            }

        }
    )


    .catch(
        error => {

            console.error(
                error
            );


            alert(

                "❌ Unable to connect to server.\n\n" +

                "Make sure Apache and MySQL are running."

            );

        }
    );

}


// ==========================================
// INITIAL CART
// ==========================================

updateCart();


</script>


</body>

</html>