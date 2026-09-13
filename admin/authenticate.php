<?php

session_start();

include "../backend/conn.php";


if (
    $_SERVER["REQUEST_METHOD"] !== "POST"
) {

    header(
        "Location: login.php"
    );

    exit;

}


$username =
    trim(
        $_POST["username"] ?? ""
    );


$password =
    $_POST["password"] ?? "";


if (
    $username === "" ||
    $password === ""
) {

    die(
        "Username and password are required."
    );

}


$stmt = mysqli_prepare(
    $conn,
    "SELECT id, username, password
     FROM admins
     WHERE username = ?
     LIMIT 1"
);


mysqli_stmt_bind_param(
    $stmt,
    "s",
    $username
);


mysqli_stmt_execute($stmt);


$result =
    mysqli_stmt_get_result($stmt);


$admin =
    mysqli_fetch_assoc($result);


if (
    $admin &&
    password_verify(
        $password,
        $admin["password"]
    )
) {

    session_regenerate_id(true);


    $_SESSION["admin_id"] =
        $admin["id"];


    $_SESSION["admin_username"] =
        $admin["username"];


    header(
        "Location: dashboard.php"
    );

    exit;

}


echo "

<!DOCTYPE html>

<html>

<head>

<title>Login Failed</title>

</head>

<body>

<h2>❌ Invalid username or password</h2>

<a href='login.php'>
    Try Again
</a>

</body>

</html>

";


mysqli_stmt_close($stmt);

mysqli_close($conn);

?>