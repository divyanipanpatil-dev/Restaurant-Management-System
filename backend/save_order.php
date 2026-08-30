<?php

header(
    "Content-Type: application/json"
);

include "conn.php";


// Only POST allowed

if (
    $_SERVER["REQUEST_METHOD"] !== "POST"
) {

    echo json_encode([
        "status" => "error",
        "message" =>
            "Invalid request method."
    ]);

    exit;
}


// Get JSON

$input =
    file_get_contents(
        "php://input"
    );


$data =
    json_decode(
        $input,
        true
    );


// Check JSON

if (!is_array($data)) {

    echo json_encode([
        "status" => "error",
        "message" =>
            "Invalid JSON data."
    ]);

    exit;
}


// Get customer name

$customer_name =
    trim(
        $data["name"] ?? ""
    );


// Get items

$items =
    $data["items"] ?? [];


// Get total

$total =
    $data["total"] ?? 0;


// Validate name

if ($customer_name === "") {

    echo json_encode([
        "status" => "error",
        "message" =>
            "Customer name is required."
    ]);

    exit;
}


// Validate items

if (
    !is_array($items) ||
    count($items) === 0
) {

    echo json_encode([
        "status" => "error",
        "message" =>
            "No items found."
    ]);

    exit;
}


// Convert items to JSON

$items_json =
    json_encode(
        $items,
        JSON_UNESCAPED_UNICODE
    );


// Convert total

$total =
    (float)$total;


// Prepared statement

$sql = "
    INSERT INTO orders
    (
        customer_name,
        items,
        total
    )
    VALUES
    (?, ?, ?)
";


$stmt =
    mysqli_prepare(
        $conn,
        $sql
    );


if (!$stmt) {

    echo json_encode([
        "status" => "error",
        "message" =>
            "Database statement error."
    ]);

    exit;
}


// Bind values

mysqli_stmt_bind_param(
    $stmt,
    "ssd",
    $customer_name,
    $items_json,
    $total
);


// Execute

if (
    mysqli_stmt_execute($stmt)
) {

    echo json_encode([
        "status" => "success",
        "message" =>
            "Order saved successfully.",
        "order_id" =>
            mysqli_insert_id($conn)
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "message" =>
            "Unable to save order."
    ]);

}


// Close

mysqli_stmt_close($stmt);

mysqli_close($conn);

?>