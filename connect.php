<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "signin";

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// If the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $number = $_POST['number'];

    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Use prepared statement for insertion
    $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, gender, email, password, number) 
                            VALUES (?, ?, ?, ?, ?, ?)");

    // Check if the prepared statement was successful
    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ssssss", $firstName, $lastName, $gender, $email, $hashedPassword, $number);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error in preparing the statement.";
    }
}

// Close the database connection
$conn->close();
?>
