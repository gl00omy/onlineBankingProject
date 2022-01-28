<?php

session_start();

require "php/scripts/connectToDatabase.php";
?>

<!DOCTYPE html>

<html lang="en-us">
	<head>
		<title>My Account Page</title>

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

		<main class="container-fluid m-0">
			<section class="row justify-content-center">
				<?php require "php/scripts/showIncomingTransactions.php"; ?>
				<?php require "php/scripts/showOutgoingTransactions.php"; ?>
			</section>
		</main>

		<?php require 'php/html_elements/footer.php'; ?>
	</body>
</html>