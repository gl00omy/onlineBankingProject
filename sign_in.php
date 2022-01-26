<!DOCTYPE html>

<html lang="en-us">
	<head>
		<title>Sign In Page</title>

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

		<link rel="stylesheet" href="css/main.css"/>
	</head>

	<body>
		<?php require 'php/html_elements/header.php'; ?>
		
		<main class="container-fluid">
			<section class="justify-content-center row p-5">
				<?php require_once "php/scripts/signInVariables.php"; ?>

				<form class="col-8" method="POST" action="<?php echo( htmlspecialchars( $_SERVER[ "PHP_SELF" ] ) ); ?>">
					<div class="form-group p-2">
						<label class="form-label" for="first-name-input">First Name <span class="text-danger">*</span></label>
						<input
							type="text"
							placeholder="Enter your first name"
							minlength="3"
							maxlength="30"
							class="form-control"
							id="first-name-input"
							name="firstName"
							value="<?php echo( isset( $_POST[ "firstName" ] ) ? $_POST[ "firstName" ] : '' ); ?>"
							required
						>
					</div>
					<div class="form-group p-2">
						<label class="form-label" for="last-name-input">Last Name <span class="text-danger">*</span></label>
						<input
							type="text"
							placeholder="Enter your last name"
							minlength="3"
							maxlength="30"
							class="form-control"
							id="last-name-input"
							name="lastName"
							value="<?php echo( isset( $_POST[ "lastName" ] ) ? $_POST[ "lastName" ] : '' ); ?>"
							required
						>
					</div>
					<div class="form-group p-2">
						<label class="form-label" for="email-input">Email address</label>
						<input
							type="email"
							placeholder="Enter your email"
							minlength="6" 
							maxlength="254"
							class="form-control"
							id="email-input"
							name="email"
							value="<?php echo( isset( $_POST[ "email" ] ) ? $_POST[ "email" ] : '' ); ?>"
							required
						>
					</div>
					<div class="form-group p-2">
						<label class="form-label" for="password-input">Password <span class="text-danger">**</span></label>
						<input
							type="password"
							placeholder="Enter your password"
							minlength="10"
							maxlength="30"
							class="form-control"
							id="password-input"
							name="password"
							value="<?php echo( isset( $_POST[ "password" ] ) ? $_POST[ "password" ] : '' ); ?>"
							required
						>
					</div>

					<span class="text-danger">* Must be 3-30 characters long, must only contain letters</span>
					<br>
					<span class="text-danger">** Must be 10-30 characters long, must only contain letters</span>

					<div class="d-flex justify-content-center">
						<input type="submit" class="btn btn-primary" name="submit" value="Submit"> 
					</div>
				</form>

				<?php require "php/scripts/registerToDatabase.php"; ?>
			</section>
		</main>

		<?php require 'php/html_elements/footer.php'; ?>
	</body>
</html>