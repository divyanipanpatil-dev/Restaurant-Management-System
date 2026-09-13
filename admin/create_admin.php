<?php

include "../backend/conn.php";

$username = "admin";

$password = "admin123";

$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO admins (username, password)
     VALUES (?, ?)"
);

mysqli_stmt_bind_param(
    $stmt,
    "ss",
    $username,
    $hashedPassword
);

if (mysqli_stmt_execute($stmt)) {

    echo "Admin account created successfully.<br>";
    echo "Username: admin<br>";
    echo "Password: admin123<br>";
    echo "<br>Please delete create_admin.php after this.";

} else {

    echo "Error: " .
         mysqli_error($conn);

}

?>