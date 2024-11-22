<?php
include 'db.php';

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = mysqli_real_escape_string($connection, $_POST["username"]);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);

    $sql = "SELECT * FROM users WHERE username= '$username' LIMIT 1";
    $result = mysqli_query($connection, $sql);

    // Ako postoji korisnik sa istim imenom, postavi grešku
    if(mysqli_num_rows($result) > 0) {
        $username = mysqli_fetch_assoc($result);
        
        if($username['password'] === $password)
        {
            echo "Password OK";
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username['username'];
            header("Location: admin.php");
            exit;
        }
        else
        {
            $error = "Invalid password!";
        }
    } 
    else 
    {
        $error = "Invalid username!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <h2>Login</h2>

    <form action="login.php" method="POST">
        <div style="margin-bottom: 10px;">
            <label for="username" style="display: inline-block; width: 150px;">Username:</label>
            <input type="text" id="username" name="username" required minlength="3" style="display: inline-block; width: 200px;">
        </div>

        <div style="margin-bottom: 10px;">
            <label for="password" style="display: inline-block; width: 150px;">Password:</label>
            <input type="password" id="password" name="password" required minlength="6" style="display: inline-block; width: 200px;">
        </div>

        <div>
            <input type="submit" value="Login">
        </div>
    </form>

    <div>
    </div>
</body>
</html>

<?php
/*
mysqli_close($connection);
*/
?>