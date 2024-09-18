<?php
$host = 'localhost';
$dbname = 'login_db';
$username = 'root';
$password = '';

$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUser = $_POST['username'];
    $inputPass = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hash password before storing

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $inputUser);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();
        if (password_verify($_POST['password'], $user['password'])) {
            echo "Login successful!";
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid username.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Secure Login</title>
</head>
<body>
    <form method="POST" action="login_secure.php">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
