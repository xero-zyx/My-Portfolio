<?php
session_start();

// Set the session timeout
$timeout = 5; // 30 minutes

// Check if the session has expired
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    // Perform the logout action
    logout();
}

// Update the last activity something
$_SESSION['last_activity'] = time();

// Check if the user is not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page
    header('Location: login.html');
    exit();
}
setcookie('session_id', session_id(), time() + 10, '/'); // Set the expiration time of cookie

function logout()
{
    // delete the session and cookie when the session expire
    session_destroy();
    setcookie('session_id', '', time() - 10, '/'); // Expire the session cookie
}
require_once('dbconn.php');

$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM booking_data WHERE id='$id'";
    mysqli_query($conn, $sql);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["Accept"])) {
        $id = $_POST["id"];
        $status = 3;

        $stmt = $conn->prepare("UPDATE booking_data SET status = ? WHERE id = ?");
        $stmt->bind_param("ii", $status, $id);
        $stmt->execute();

        echo "Status updated successfully!";
    } elseif (isset($_POST["Reject"])) {
        $id = $_POST["id"];
        $status = 1;

        $stmt = $conn->prepare("UPDATE booking_data SET status = ? WHERE id = ?");
        $stmt->bind_param("ii", $status, $id);
        $stmt->execute();

        echo "Status updated successfully!";
    }
}

echo '<style>body {
    background: linear-gradient(90deg, rgba(11, 20, 31, 1) 50%, rgba(0, 4, 68, 1) 100%);
    color: #fff;
}

table {
    border-collapse: collapse;
    width: 100%;
}

.titletable {
    font-size: 20px;
    font-weight: 600;
}

h1 {
    width: 100%;
    text-align: center;
    font-family: sans-serif;
    font-weight: 600;
    font-size: 60px;
}

th,
td {
    text-align: left;
    border-bottom: 1px solid #ddd;
    border-style: inset;
}

th {
    background-color: rgb(0, 0, 0);
    border-style: inset;
}

tr {
    background-color: rgba(0, 0, 0);
    padding-bottom: 5px;
}

.container {
    padding: 6px;
    margin: 60px;
    background-color: #fff;
    border-radius: 10px;

}

.action {
    text-align: center;
    padding-top: 1px;
}

.action form {
    display: inline-block;
    width: auto;
}

.action button {
    color: #fff;
    border: none;
    padding: 6px;
    margin-right: 5px;
    border-radius: 3px;
    cursor: pointer;
}

.action #accept {
    background-color: green
}

.action #reject {
    background-color: red
}

.action #delete {
    background-color: gray
}


.status-bar {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 3px;
    text-transform: uppercase;
}

.statusbar {
    text-align: center;
    width: auto;
}

.status-pending {
    background-color: rgb(190, 190, 0);
}

.status-rejected {
    background-color: red;
}

.status-accepted {
    background-color: green;
}

.status-unknown {
    background-color: gray;
}

.reveal {
    opacity: 0;
    animation: reveal 1s forwards;
}

@keyframes reveal {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }

    100% {
        opacity: 1;
        transform: translateY(0);
    }
    
}</style>';
echo '<head>
<link rel="shortcut icon" href="images/AJP-Car-Rental-logo.png" type="image/svg+xml">
<script>
// Function to send logout request
function sendLogoutRequest() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "logout.php", true);
  xhr.send();
}

// Add event listener for beforeunload event
window.addEventListener("unload", function(event) {
  // Call the sendLogoutRequest() function
  sendLogoutRequest();
  // Customize the confirmation message (optional)
  event.returnValue = "Are you sure you want to leave this page? Your session will be closed.";
});
</script></head>';

echo '<h1 class="reveal">AJP Rental</h1>';
echo '<div class = "container reveal">';
echo '<table>';
echo '<tr class = "titletable">
        <th>ID</th>
        <th>Car</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Miles</th>
        <th>Note</th>
        <th>Action</th>
        <th>Status Bar</th>
    </tr>';
$sql = "SELECT * FROM booking_data";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $row["id"] . '</td>';
    echo '<td>' . $row["car"] . '</td>';
    echo '<td>' . $row["firstname"] . '</td>';
    echo '<td>' . $row["lastname"] . '</td>';
    echo '<td>' . $row["email"] . '</td>';
    echo '<td>' . $row["number"] . '</td>';
    echo '<td>' . $row["start_date"] . '</td>';
    echo '<td>' . $row["end_date"] . '</td>';
    echo '<td>' . $row["miles"] . '</td>';
    echo '<td>' . $row["note"] . '</td>';
    echo '<td class="action">';
    echo '<form method="post">';
    echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
    echo '<button id="accept" type="submit" name="Accept" value="Accept">Accept</button>';
    echo '<button id="reject" type="submit" name="Reject" value="Reject">Reject</button>';
    echo '<button id="delete"type="submit" name="delete" value="Delete">Delete</button>';
    echo '</form>';
    echo '</td>';

    $status = $row['status'];

    if ($status == 0) {
        $class = 'status-pending';
        $text = 'Pending';
    } elseif ($status == 1) {
        $class = 'status-rejected';
        $text = 'Rejected';
    } elseif ($status == 2) {
        $class = 'status-unknown';
        $text = 'Unknown';
    } elseif ($status == 3) {
        $class = 'status-accepted';
        $text = 'Accepted';
    }
    echo '<td class="statusbar">
            <div class="status-bar ' . $class . '">' . $text . '</div>
        </td>';
    echo '</tr>';
}
echo '</div>';
mysqli_close($conn);
