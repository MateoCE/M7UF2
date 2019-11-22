<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
    <h1></h1>
    <?php
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=login", "mateo", "mateo123");
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }
    if (isset($_POST['email']) and !empty($_POST['email'])) {
        $email = $_POST['email'];
    }
    if (isset($_POST['password']) and !empty($_POST['password'])) {
        $password = $_POST['password'];
    }
    if (isset($email) and isset($password)) {
        $hassedPassword = hash("sha256", $password);
        $query = $pdo->prepare("SELECT password FROM user where email = \"$email\"");
        $query->execute();
        $registre = $query->fetch();
        if (!empty($registre)) {
            if ($registre["password"] === $hassedPassword) {
                echo "OK";
            } else {
                echo "KO";
            }
        } else {
            echo "No existe ese usuario";
        }
    } else {
        echo "No recibido post";
    }
    echo "<button onclick=\"window.location.href='login.html'\">Click me</button>";
    ?>
</body>

</html>