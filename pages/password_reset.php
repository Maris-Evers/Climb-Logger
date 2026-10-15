<?php

include_once('../database/connection.php');


?>

<body>
	<form class="login-form" action="new_pass.php" method="post">
		<h2 class="form-title">New password</h2>
		<?php include('status.php'); ?>
		<div class="form-group">
			<label>New password</label>
			<input type="password" name="new_pass">
		</div>
		<div class="form-group">
			<label>Confirm new password</label>
			<input type="password" name="new_pass_c">
		</div>
		<div class="form-group">
			<button type="submit" name="new_password" class="login-btn">Submit</button>
		</div>
	</form>
</body>