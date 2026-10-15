<?php

include_once('../database/connection.php');
unset($_SESSION['error']);

if (isset($_POST['reset-password'])) {
    $email = $_POST['email'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    var_dump($user);



    if (empty($email)) {
        $_SESSION['error'] = "Your email is required.";
    }else if(empty($user)) {
        $_SESSION['error'] = "No user with that email exists in our database, did you write the right email?";
    }

    $token = bin2hex(random_bytes(50));

    if (!isset($_SESSION['error'])) {
        $sql = "INSERT INTO password_reset_request(email, token) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email, $token]);

        $to = $email;
        $subject = "Reset your password for climblogger.com";
        $msg = "Hi there, click on this <a href=\"password_reset.php?token=" . $token . "\">link</a> to reset your password on our site";
        $msg = wordwrap($msg,70);
        $headers = "From: noreply@climblogger.com";
        mail($to, $subject, $msg, $headers);
        header('location: pending.php?email=' . $email);
    }
}


?>

<body>
	<form class="login-form" action="enter_email.php" method="post">
		<h2 class="form-title">Reset password</h2>
		<div class="form-group">
			<label>Your email address</label>
			<input type="email" name="email">
		</div>
        <?php if (isset($_SESSION['error'])) { ?>
            <div style="color: red;"><?= $_SESSION['error']; ?></div>
        <?php } ?>
		<div class="form-group">
			<button type="submit" name="reset-password" class="login-btn">Submit</button>
		</div>
	</form>
</body>