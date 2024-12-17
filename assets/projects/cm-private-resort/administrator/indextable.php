<?php
session_start();
if (!(isset($_SESSION['postname']))) {
    header("Location: administrator.php");
    exit();
}

require_once('dbconn.php');

$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM reservation_data WHERE id='$id'";
    mysqli_query($conn, $sql);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["Accept"])) {
        $id = $_POST["id"];
        $status = 1;

        $stmt = $conn->prepare("UPDATE reservation_data SET status = ? WHERE id = ?");
        $stmt->bind_param("ii", $status, $id);
        $stmt->execute();

        echo "Status updated successfully!";
    } elseif (isset($_POST["Reject"])) {
        $id = $_POST["id"];
        $status = 2;

        $stmt = $conn->prepare("UPDATE reservation_data SET status = ? WHERE id = ?");
        $stmt->bind_param("ii", $status, $id);
        $stmt->execute();

        echo "Status updated successfully!";
    }
}

echo '
<script>
window.addEventListener("beforeunload", function() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "logoutscript.php", false);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send();

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("Session closed successfully.");
        }
    };
});
</script>
';

echo '<link rel="stylesheet" href="style.css">';
echo '<h1>CS-Resort Reservation List</h1>';
echo '<form action="logoutscript.php" method="post" class="logout-form">"!!ALWAYS MAKE SURE TO LOGOUT!!"';
echo '<input type="submit" name="logout" value="Logout">';
echo '</form>';
echo '<style>';
echo '.logout-form {
    position: absolute;
    top: 0;
    right: 0;
    margin-top: 10px;
    margin-right: 10px;
    color: #ee2214;

 }
 .logout-form input[type="submit"] {
    font-size: 24px; 
    padding: 15px 30px;
    border: 1px solid rgb(52, 126, 49);
    border-radius: 5px; 
    cursor: pointer; 
 }form {
    align-items: center;
}


input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 5px 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin: 3px;
}';
echo '</style>';

$sql = "SELECT * FROM reservation_data";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    echo '<table>';
    echo '<tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>MiddleInitial</th>
            <th>Email</th>
            <th>MobileNumber</th>
            <th>ReservationDate</th>
            <th>Note</th>
            <th>Action</th>
            <th>Status Bar</th>
          </tr>';
    echo '<tr>';
    echo '<td>' . $row["id"] . '</td>';
    echo '<td>' . $row["firstname"] . '</td>';
    echo '<td>' . $row["lastname"] . '</td>';
    echo '<td>' . $row["middleinitial"] . '</td>';
    echo '<td>' . $row["email"] . '</td>';
    echo '<td>' . $row["mobilenumber"] . '</td>';
    echo '<td>' . $row["reservationdate"] . '</td>';
    echo '<td>' . $row["note"] . '</td>';
    echo '<form method="post">';
    echo '<td class="action">';
    echo '<input type="submit" name="Accept" value="Accept">';
    echo '<input type="submit" name="Reject" value="Reject">';
    echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
    echo '<input type="submit" name="delete" value="Delete">';
    echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
    echo '</form>';
    echo '</td>';
    echo '</td>';
    echo '</form>';

    $status = $row['status'];

    if ($status == 0) {
        $color = 'yellow';
        $text = 'Pending';
    } elseif ($status == 1) {
        $color = 'green';
        $text = 'Accepted';
    } elseif ($status == 2) {
        $color = 'red';
        $text = 'Rejected';
    } else {
        $color = 'gray';
        $text = 'Unknown';
    }
    echo '<td>' . '<div style="background-color: ' . $color . '; width: 100px; height: 20px; display: inline-block; border-radius: 5px;">' . $text . '</div>' . '</td>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
}

mysqli_close($conn);
