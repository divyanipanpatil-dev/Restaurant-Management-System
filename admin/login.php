<?php

session_start();

if (isset($_SESSION["admin_id"])) {

    header(
        "Location: dashboard.php"
    );

    exit;

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

    <title>Admin Login</title>


    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }


        body {

            font-family: Arial, sans-serif;

            min-height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;

            background:
                linear-gradient(
                    135deg,
                    #d4af37,
                    #b8860b
                );

            padding: 20px;

        }


        .login-box {

            width: 100%;

            max-width: 420px;

            background: white;

            padding: 35px;

            border-radius: 15px;

            box-shadow:
                0 10px 30px
                rgba(0,0,0,0.25);

        }


        .logo {

            text-align: center;

            font-size: 50px;

            margin-bottom: 10px;

        }


        h1 {

            text-align: center;

            color: #4e342e;

            margin-bottom: 30px;

        }


        .form-group {

            margin-bottom: 20px;

        }


        label {

            display: block;

            font-weight: bold;

            margin-bottom: 8px;

            color: #333;

        }


        input {

            width: 100%;

            padding: 13px;

            border: 1px solid #ccc;

            border-radius: 7px;

            font-size: 16px;

        }


        input:focus {

            outline: none;

            border-color: #b8860b;

        }


        .login-btn {

            width: 100%;

            padding: 14px;

            border: none;

            border-radius: 7px;

            background: #4caf50;

            color: white;

            font-size: 17px;

            cursor: pointer;

        }


        .login-btn:hover {

            background: #388e3c;

        }


        .customer-link {

            display: block;

            text-align: center;

            margin-top: 20px;

            color: #2196f3;

            text-decoration: none;

        }

    </style>

</head>


<body>


<div class="login-box">


    <div class="logo">
        🔐
    </div>


    <h1>
        Admin Login
    </h1>


    <form
        action="authenticate.php"
        method="POST"
    >


        <div class="form-group">

            <label>
                Username
            </label>

            <input
                type="text"
                name="username"
                placeholder="Enter username"
                required
            >

        </div>


        <div class="form-group">

            <label>
                Password
            </label>

            <input
                type="password"
                name="password"
                placeholder="Enter password"
                required
            >

        </div>


        <button
            type="submit"
            class="login-btn"
        >

            Login

        </button>


    </form>


    <a
        href="../index.php"
        class="customer-link"
    >

        ← Back to Restaurant Menu

    </a>


</div>


</body>

</html>