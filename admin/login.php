<?php

require '../config.php';

session_start();
if (!$_SESSION['login']) {
    if ($_POST) {
        if (!isset($_POST["username"]) && !isset($_POST["password"])) {
            $_SESSION['login'] = false;
            $_SESSION['username'] = "";
            $_SESSION['password'] = "";
            header("Location: login.php?error=true");
            die();
        } else {
            $access = false;
            $username = $_POST["username"];
            $password = $_POST["password"];
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $myfile = fopen("Credentials.json", "r") or die("Unable to open file!");
            $array = json_decode(fread($myfile, filesize("Credentials.json")))->values;
            foreach ($array as $struct) {
                if ($username == $struct->username) {
                    if ($password == $struct->password) {
                        $_SESSION['login'] = true;
                        header("Location: index.php?login=true");
                        die();
                    }
                }
            }
            fclose($myfile);
        }
    }
} else {
    header("Location: index.php?login=true");
    die();
}

$color = 'black';
if ($_REQUEST["error"] || $_REQUEST['missmatch']) {
    $color = "red";
}
?>
<!DOCTYPE html>
<html>

<head>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            margin: 50px auto;
            text-align: center;
            width: 800px;
        }

        h1 {
            font-family: 'Passion One';
            font-size: 2rem;
            text-transform: uppercase;
        }

        label {
            width: 150px;
            display: inline-block;
            text-align: left;
            font-size: 1.5rem;
            font-family: 'Lato';
        }

        input {
            border: 2px solid #ccc;
            font-size: 1.5rem;
            font-weight: 100;
            font-family: 'Lato';
            padding: 10px;
        }

        form {
            margin: 25px auto;
            padding: 20px;
            border: 5px solid #ccc;
            width: 500px;
            background: #eee;
        }

        div.form-element {
            margin: 20px 0;
        }

        button {
            padding: 10px;
            font-size: 1.5rem;
            font-family: 'Lato';
            font-weight: 100;
            background: yellowgreen;
            color: white;
            border: none;
        }

        p.success,
        p.error {
            color: white;
            font-family: lato;
            background: yellowgreen;
            display: inline-block;
            padding: 2px 10px;
        }

        p.error {
            background: orangered;
        }
    </style>
</head>

<body>
    <form method="post" name="signup-form">
        <div class="form-element">
            <label style="color: <?php echo $color; ?>">Username</label>
            <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
        </div>
        <div class="form-element">
            <label style="color: <?php echo $color; ?>">Password</label>
            <input type="password" name="password" required />
        </div>
        <button type="submit" name="register" value="register">Login</button>
    </form>
</body>

</html>