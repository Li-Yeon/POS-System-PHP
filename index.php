<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>POS System</title>
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
</head>

<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="assets/images/loginlogo.png" alt="logo">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Login</h4>
							<form method="POST" class="my-login-validation" action="./PHP/login.php">
								<div class="form-group">
									<label>Username</label>
									<input type="text" class="form-control" name="username" value="" required autofocus>
								</div>

								<div class="form-group">
									<label>Password
									</label>
									<input type="password" class="form-control" name="password" required data-eye>
								</div>

								<div class="form-group m-0">
									<button class="btn btn-primary btn-block" name="Login">
										Login
									</button>
								</div>
							</form>
						</div>       
					</div>

					<div class="footer">
						Copyright &copy; 2021 &mdash; LiyeonTech
					</div>

				</div>
			</div>
		</div>
	</section>

</body>
</html>