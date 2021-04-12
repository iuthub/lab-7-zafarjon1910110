<?php
$db = new PDO('mysql:dbname=blog', 'dabud', '2.d3fXj%sz]CRR$');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$create_user_stmt = $db->prepare("INSERT INTO users (username, email, password, fullname) VALUES (?, ?, ?, ?)");
$create_user_stmt->bindParam(1, $username);
$create_user_stmt->bindParam(2, $email);
$create_user_stmt->bindParam(3, $password);
$create_user_stmt->bindParam(4, $fullname);


$update_user_stmt = $db->prepare("UPDATE users SET username=?, email=?, password=?, fullname=? WHERE id=?");
$update_user_stmt->bindParam(1, $username);
$update_user_stmt->bindParam(2, $email);
$update_user_stmt->bindParam(3, $password);
$update_user_stmt->bindParam(4, $fullname);
$update_user_stmt->bindParam(5, $user_id);


$authenticate_user_stmt = $db->prepare('SELECT users.id, users.username, users.email, users.fullname, users.password FROM users WHERE users.username=? AND users.password = ?');
$authenticate_user_stmt->bindParam(1, $username);
$authenticate_user_stmt->bindParam(2, $password);


$add_blog_post_stmt = $db->prepare('INSERT INTO posts (title, body, userId) VALUES (?, ?, ?)');
$add_blog_post_stmt->bindParam(1, $title);
$add_blog_post_stmt->bindParam(2, $body);
$add_blog_post_stmt->bindParam(3, $user_id);


$retrieve_blog_posts_stmt = $db->prepare('SELECT * FROM posts WHERE posts.userId = ?');
$retrieve_blog_posts_stmt->bindParam(1, $user_id);

?>