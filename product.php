<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zain";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $email = $_POST['customer-email'];
    $phone = $_POST['customer-phone'];
    $address = $_POST['address'];
    
    // SQL query to insert data into the table
    $sql = "INSERT INTO customers (first_name, last_name, email, phone, address)
            VALUES ('$firstName', '$lastName', '$email', '$phone', '$address')";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
}
?>
