<?php   
include "db.php"; 

$error = "";  

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = mysqli_real_escape_string($connection, $_POST["username"]);
    $email = mysqli_real_escape_string($connection, $_POST["email"]);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);
    $confirm_password = mysqli_real_escape_string($connection, $_POST["confirm_password"]);

    // Provjera da li lozinke odgovaraju
    if($password != $confirm_password) {
        $error = "Passwords don't match";  // Postavi grešku
    } else {
        // Upit za provjeru postojanja korisničkog imena
        $sql = "SELECT * FROM users WHERE username= '$username' LIMIT 1";
        $result = mysqli_query($connection, $sql);

        // Ako postoji korisnik sa istim imenom, postavi grešku
        if(mysqli_num_rows($result) > 0) {
            $error = "Username already exists!";
        } else {
            // Ako korisnik ne postoji, umetni podatke u bazu
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
            if (mysqli_query($connection, $sql)) {
                echo "Data inserted successfully!";
            } else {
                echo "Data not inserted: " . mysqli_error($connection);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
</head>
<body>
    <h2>Register</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="register.php" method="POST">
        <div style="margin-bottom: 10px;">
            <label for="username" style="display: inline-block; width: 150px;">Username:</label>
            <input type="text" id="username" name="username" required minlength="3" style="display: inline-block; width: 200px;">
        </div>

        <div style="margin-bottom: 10px;">
            <label for="email" style="display: inline-block; width: 150px;">Email:</label>
            <input type="email" id="email" name="email" required style="display: inline-block; width: 200px;">
        </div>

        <div style="margin-bottom: 10px;">
            <label for="password" style="display: inline-block; width: 150px;">Password:</label>
            <input type="password" id="password" name="password" required minlength="6" style="display: inline-block; width: 200px;">
        </div>

        <div style="margin-bottom: 10px;">
            <label for="confirm_password" style="display: inline-block; width: 150px;">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required minlength="6" style="display: inline-block; width: 200px;">
        </div>

        <div>
            <input type="submit" value="Register">
        </div>
    </form>

    <div>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>

<?php
mysqli_close($connection);
?>