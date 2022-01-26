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
		<?php require 'php/html_elements/header.php'; ?>

		<main class="container-fluid">
			<section class="justify-content-center row p-5">
				<form class="col-8" method="POST">
					<div class="form-group">
						<label for="email-input">Email address</label>
						<input type="email" class="form-control" id="email-input" placeholder="Enter your email">
					</div>
					<br>
					<div class="form-group">
						<label for="password-input">Password</label>
						<input type="password" class="form-control" id="password-input" placeholder="Enter your password">
					</div>
					<br>
					<div class="d-flex justify-content-center">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</section>

			<section class="justify-content-center row p-5">
				<?php require "php/scripts/showPresentAccounts.php"; ?>
			</section>
		</main>
		
		<?php require 'php/html_elements/footer.php'; ?>
	</body>
</html>