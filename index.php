<?php
include('connection.php');
session_start();

if(isset($_GET['logout']) && $_GET['logout'] == 1) {
    session_unset();
}

$username = '';
$password = '';
$user_does_not_exist = false;
if(isset($_SESSION['user'])) { // If session already populated with credentials
    $is_authenticated = true;
    $user = $_SESSION['user'];
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['function']) && $_POST['function'] == 'authenticate') { // If user tried to authenticate with form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = $authenticate_user_stmt->execute();
    $user = $authenticate_user_stmt->fetchAll();
    if(count($user) == 0) {
        $is_authenticated = false;
        $user_does_not_exist = true;
    } else {
        $user = $user[0];
        $_SESSION['user'] = $user;
        $is_authenticated = true;
    }
    if($_POST['remember']) { // Store username in cookies if "remember" is checked
        setcookie('username', $username, time()+60*60*24*365);
    } else { // Destroy cookies if "remember" is unchecked
        setcookie('username', '', time()-1);
    }
}
else {
    $is_authenticated = false;
    if(isset($_COOKIE['username'])) { // Get username from cookie if exists
        $username = $_COOKIE['username'];
    }
}

// Add new blog post
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['function']) && $_POST['function'] == 'add_post' && $is_authenticated) {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $user_id = intval($user['id']);
    $add_blog_post_stmt->execute();
}
// Retrieve blog posts if authenticated
if($is_authenticated) {
    $user_id = $user['id'];
    $retrieve_blog_posts_stmt->execute();
    $posts = $retrieve_blog_posts_stmt->fetchAll();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>My Personal Page</title>
		<link href="style.css" type="text/css" rel="stylesheet" />
	</head>
	
	<body>
		<?php include('header.php'); ?>

		<?php if(!$is_authenticated) { ?>
            <!-- Show this part if user is not signed in yet -->
            <div class="twocols">
                <form action="index.php" method="post" class="twocols_col">
                    <ul class="form">
                        <?php if($user_does_not_exist) { ?> <li style="color: red; text-align: center">User with entered credentials does not exist</li> <?php } ?>
                        <input type="hidden" name="function" value="authenticate">
                        <li>
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" value="<?= $username ?>" />
                        </li>
                        <li>
                            <label for="pwd">Password</label>
                            <input type="password" name="password" id="pwd" value="<?= $password ?>" />
                        </li>
                        <li>
                            <label for="remember">Remember Me</label>
                            <input type="checkbox" name="remember" id="remember" checked />
                        </li>
                        <li>
                            <input type="submit" value="Submit" /> &nbsp; Not registered? <a href="register.php">Register</a>
                        </li>
                    </ul>
                </form>
                <div class="twocols_col">
                    <h2>About Us</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur libero nostrum consequatur dolor. Nesciunt eos dolorem enim accusantium libero impedit ipsa perspiciatis vel dolore reiciendis ratione quam, non sequi sit! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio nobis vero ullam quae. Repellendus dolores quis tenetur enim distinctio, optio vero, cupiditate commodi eligendi similique laboriosam maxime corporis quasi labore!</p>
                </div>
            </div>
        <?php } else { ?>
            <!-- Show this part after user signed in successfully -->
            <div class="logout_panel"><a href="register.php">My Profile</a>&nbsp;|&nbsp;<a href="index.php?logout=1">Log Out</a></div>
            <h2>New Post</h2>
            <form action="index.php" method="post">
                <input type="hidden" name="function" value="add_post">
                <ul class="form">
                    <li>
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" required/>
                    </li>
                    <li>
                        <label for="body">Body</label>
                        <textarea name="body" id="body" cols="30" rows="10" required></textarea>
                    </li>
                    <li>
                        <input type="submit" value="Post" />
                    </li>
                </ul>
            </form>
            <div class="onecol">
                <?php foreach ($posts as $post) { ?>
                    <div class="card">
                        <h2><?= $post['title'] ?></h2>
                        <h5><?= $post['publishDate'] ?></h5>
                        <p><?= $post['body'] ?></p>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
	</body>
</html>