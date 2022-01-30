<?php

session_start();

require "php/scripts/connectToDatabase.php";

require "php/scripts/loginVariables.php";
require "php/scripts/accountLogin.php";

?>

<!DOCTYPE html>

<html lang="en-us">
	<head>
		<title>Log In Page</title>

		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<link
			href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
			rel="stylesheet"
			integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
			crossorigin="anonymous">

		<script
			src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
			integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
			crossorigin="anonymous">
		</script>

		<link rel="stylesheet" href="css/style.css"/>
	</head>
	
	<body>
		<header class='container-fluid bg-light'>
			<nav class='navbar navbar-expand justify-content-center'>
				<ul class='navbar-nav mr-auto'>
					<li class='nav-item active'>
						<a class='nav-link' href='index.php'>Home</a>
					</li>
				</ul>
			</nav>
		</header>

		<main class="container-fluid">
			<section class="row justify-content-center">
				<form class="col-8 pt-5 pb-5" method="POST" action="<?php echo( htmlspecialchars( $_SERVER[ "PHP_SELF" ] ) ); ?>">
					<div class="form-group p-2">
						<input
							type="email"
							placeholder="Email address"
							class="form-control"
							id="email-input"
							name="email"
							value="<?php echo( isset( $_POST[ "email" ] ) ? $_POST[ "email" ] : '' ); ?>"
							required
						>

						<span class="text-danger"><?php echo( $emailErrMsg ); ?></span>
					</div>
					<div class="form-group p-2">
						<input
							type="password"
							placeholder="Password"
							class="form-control"
							id="password-input"
							name="password"
							value="<?php echo( isset( $_POST[ "password" ] ) ? $_POST[ "password" ] : '' ); ?>"
							required
						>

						<span class="text-danger"><?php echo( $passwordErrMsg ); ?></span>
					</div>

					<div class="d-flex justify-content-center mt-5">
						<input type="submit" class="btn btn-primary"value="Submit">
						<a class='nav-link' href='signin.php'>Don't have an account yet?</a>
					</div>
				</form>
			</section>

			<section class="row justify-content-center p-5">
				<?php require "php/scripts/showPresentAccounts.php"; ?>
			</section>
		</main>
		
		<?php require 'php/html_elements/footer.php'; ?>
	</body>
</html>