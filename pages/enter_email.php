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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>
<body class="bg-dark text-light">
    <div class="text-center position-absolute top-50 start-50 translate-middle">
	<form class="login-form" action="enter_email.php" method="post">
		<h2 class="form-title">Reset password</h2>
		<div class="py-2">
			<label>Your email address</label>
			<input type="email" name="email">
		</div>
        <?php if (isset($_SESSION['error'])) { ?>
            <div style="color: red;"><?= $_SESSION['error']; ?></div>
        <?php } ?>
		<button type="submit" name="reset-password" class="login-btn my-2 px-4 pb-1 border border-0 rounded">Submit</button>
	</form>
    </div>
</body>
</html>
