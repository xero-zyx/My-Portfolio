<?php session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>LOGIN</title>
    <link rel="stylesheet" href="style1.css">
</head>
<?php
if (isset($_GET['error'])) {
    $error_message = $_GET['error'];
    echo "<script>alert('$error_message');</script>";
}
?>

<body>
    <div class="container">
        <form action="loginscript.php" method="post">
            <h2>LOGIN</h2>
            <label>Username</label>
            <input type="text" name="username" placeholder="Username"><br>
            <label>Password</label>
            <input type="password" name="password" placeholder="Password"><br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>