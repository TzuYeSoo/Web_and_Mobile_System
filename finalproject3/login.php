    <?php
        require_once "connection.php";
        session_start();

        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT username, firt_name, last_name FROM user_account WHERE username=? AND user_password=? AND position='admin'");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $_SESSION['username'] = $row['username'];
                $_SESSION['firt_name'] = $row['firt_name'];
                $_SESSION['last_name'] = $row['last_name'];
                header("Location: dashboard.html");
                exit();
            } else {
                alert("invalid credentials");
                header("Location: Login.html");
                exit();
            }

        $stmt->close();
        $conn->close();
    ?>

