<?php  

include('connection.php');
session_start();

$passwords_do_not_match = false;
$username = '';
$fullname = '';
$email = '';

if(isset($_SESSION['user'])) { // If user is authenticated
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['pwd'];
        $password_repeat = $_POST['confirm_pwd'];
        $passwords_do_not_match = $password != $password_repeat;
        $user_id = $_SESSION['user']['id'];
        if (!$passwords_do_not_match) {
            $update_user_stmt->execute();
            header("Location: index.php");
        }
    } else {
        $username = $_SESSION['user']['username'];
        $fullname = $_SESSION['user']['fullname'];
        $email = $_SESSION['user']['email'];
    }
} else { // If user is not authenticated
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['pwd'];
        $password_repeat = $_POST['confirm_pwd'];
        $passwords_do_not_match = $password != $password_repeat;
        if (!$passwords_do_not_match) {
            $create_user_stmt->execute();
            header("Location: index.php");
        }
    }
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>My Blog - Registration Form</title>
		<link href="style.css" type="text/css" rel="stylesheet" />
	</head>
	
	<body>
		<?php include('header.php'); ?>

		<h2>User Details Form</h2>
		<h4>Please, fill below fields correctly</h4>
		<form action="register.php" method="post">
				<ul class="form">
					<li>
						<label for="username">Username</label>
						<input type="text" name="username" id="username" value="<?= $username ?>" required/>
					</li>
					<li>
						<label for="fullname">Full Name</label>
						<input type="text" name="fullname" id="fullname" value="<?= $fullname ?>" required/>
					</li>
					<li>
						<label for="email">Email</label>
						<input type="email" name="email" id="email" value="<?= $email ?>" />
					</li>
					<li>
						<label for="pwd">Password</label>
						<input type="password" name="pwd" id="pwd" required/>
					</li>
					<li>
						<label for="confirm_pwd">Confirm Password</label>
						<input type="password" name="confirm_pwd" id="confirm_pwd" required />
                        <?php if($passwords_do_not_match) { ?> <small style="color: red">Passwords do not match</small><?php } ?>
					</li>
					<li>
						<input type="submit" value="Submit" /> &nbsp; Already registered? <a href="index.php">Login</a>
					</li>
				</ul>
		</form>
	</body>
</html>