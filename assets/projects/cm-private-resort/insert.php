<?php
// Get form data
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$middleinitial = $_POST['middleinitial'];
$contactnumber = $_POST['mobilenumber'];
$email = $_POST['email'];
$date = $_POST['reservationdate'];
$note = $_POST['note'];

// Connect to MySQL database
$servername = "localhost";
$username = "admin";
$password = "12345";
$dbname = "form_data";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert form data into database
$sql = "INSERT INTO reservation_data (`firstname`, `lastname`, `middleinitial`, `email`, `mobilenumber`, `reservationdate`, `note`)
                                VALUES ('$firstname', '$lastname', '$middleinitial', '$email','$contactnumber', '$date', '$note')";
if ($conn->query($sql) === TRUE) {
    header("Location: index.html");
    echo "Form data inserted successfully!";
} else {
    echo "Error: something happened!!!" . $sql . "<br>" . $conn->error;
}

// Close database connection
$conn->close();