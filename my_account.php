<?php

session_start();

require "php/scripts/connectToDatabase.php";

require "php/scripts/transactionVariables.php";
require "php/scripts/accountTransactions.php";

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

		<script>

			function displayTransactionsTables()
			{
				displayIncomingTransactionsTables();
				displayOutcomingTransactionsTables();
			}

			function displayIncomingTransactionsTables()
			{
				let table = document.getElementById( "incoming-transactions-table" );
				setIncomingTransactionTable( "incoming-ordering-options", table );
			}

			function displayOutcomingTransactionsTables()
			{
				let table = document.getElementById( "outcoming-transactions-table" );
				setOutcomingTransactionTable( "outcoming-ordering-options", table );
			}

			function getSelectedOrderingOption( id )
			{
				let element = document.getElementById( id ).selectedIndex;
				return document.getElementsByTagName( "option" )[ element ].value;
			}

			function setIncomingTransactionTable( tableId, table )
			{
				switch( getSelectedOrderingOption( tableId ) )
				{
					case <?php echo( json_encode( Queries::DROPDOWN_AMOUNT_ASC ) ); ?>:
						table.innerHTML = "<?php echo getIncomingTransactionsTable(
								Queries::AMOUNT_ASC, Queries::DATE_ASC
							);
						?>";
						break;

					case <?php echo( json_encode( Queries::DROPDOWN_AMOUNT_DESC ) ); ?>:
						table.innerHTML = "<?php echo getIncomingTransactionsTable(
								Queries::AMOUNT_DESC, Queries::DATE_ASC
							);
						?>";
						break;

					case <?php echo( json_encode( Queries::DROPDOWN_DATE_ASC ) ); ?>:
						table.innerHTML = "<?php echo getIncomingTransactionsTable(
								Queries::DATE_ASC, Queries::AMOUNT_ASC
							);
						?>";
						break;
						
					case <?php echo( json_encode( Queries::DROPDOWN_DATE_DESC ) ); ?>:
						table.innerHTML = "<?php echo getIncomingTransactionsTable(
								Queries::DATE_DESC, Queries::AMOUNT_ASC
							);
						?>";
						break;
				}
			}

			function setOutcomingTransactionTable( tableId, table )
			{
				switch( getSelectedOrderingOption( tableId ) )
				{
					case <?php echo( json_encode( Queries::DROPDOWN_AMOUNT_ASC ) ); ?>:
						table.innerHTML = "<?php echo getOutcomingTransactionsTable(
								Queries::AMOUNT_ASC, Queries::DATE_ASC
							);
						?>";
						break;

					case <?php echo( json_encode( Queries::DROPDOWN_AMOUNT_DESC ) ); ?>:
						table.innerHTML = "<?php echo getOutcomingTransactionsTable(
								Queries::AMOUNT_DESC, Queries::DATE_ASC
							);
						?>";
						break;

					case <?php echo( json_encode( Queries::DROPDOWN_DATE_ASC ) ); ?>:
						table.innerHTML = "<?php echo getOutcomingTransactionsTable(
								Queries::DATE_ASC, Queries::AMOUNT_ASC
							);
						?>";
						break;
						
					case <?php echo( json_encode( Queries::DROPDOWN_DATE_DESC ) ); ?>:
						table.innerHTML = "<?php echo getOutcomingTransactionsTable(
								Queries::DATE_DESC, Queries::AMOUNT_ASC
							);
						?>";
						break;
				}
			}

			function logout()
			{
				document.location.replace( 'http://localhost/onlineBankingProject/index.php ');
			}

		</script>
	</head>

	<body onload="displayTransactionsTables()">
		<?php require 'php/html_elements/header.php'; ?>

		<main class="container-fluid m-0">
			<div class="row justify-content-center m-5">
				<span class="col-auto align-self-center text-capitalize">Logged in as: <?php echo $connection->getMyFullName(); ?></span>
				<button type="button" class="col-auto btn btn-primary" value="Log out" onclick="logout()">Log Out</button>
			</div>

			<section class="row">
				<label class="row p-5"><span>Incoming transactions:</span>
					<div>
						<label>Order by:
						<select
							id="incoming-ordering-options"
							name="amountOrderingOptions"
							onchange="displayIncomingTransactionsTables()"
						>
							<?php require "php/html_elements/dropdownOrderingMenu.php"; ?>
						</select>
						</label>
					</div>
					
					<div class="col-auto" id="incoming-transactions-table"></div>
				</label>

				<label class="row p-5"><span>Outcoming transactions:</span>
					<div>
						<label>Order by:
						<select
							id="outcoming-ordering-options"
							name="dateOrderingOptions"
							onchange="displayOutcomingTransactionsTables()"
						>
							<?php require "php/html_elements/dropdownOrderingMenu.php"; ?>
						</select>
						</label>
					</div>

					<div class="col-auto" id="outcoming-transactions-table"></div>
				</label>
			</section>

			<section class="row justify-content-center">
				<form class="col-8 pt-5 pb-5" id="transaction-form" method="POST" action="<?php echo( htmlspecialchars( $_SERVER[ "PHP_SELF" ] ) ); ?>">
					<div class="form-group p-2">
						<input
							type="number"
							placeholder="Recipient ID"
							min="1"
							class="form-control"
							id="recipient-input"
							name="recipientId"
							value="<?php echo( $_POST[ "recipientId" ] ); ?>"
							required
						>

						<span class="text-danger"><?php echo( $recipientIdErrMsg ); ?></span>
					</div>
					<div class="form-group p-2">
						<input
							type="number"
							placeholder="Amount"
							min="1"
							max="1000"
							class="form-control"
							id="amount-input"
							name="amount"
							value="<?php echo( $_POST[ "amount" ] ); ?>"
							required
						>

						<span class="text-danger"><?php echo( $amountErrMsg ); ?></span>
					</div>
					<div class="form-group p-2">
						<input
							type="text"
							placeholder="Message *"
							minlength="0" 
							maxlength="100"
							class="form-control"
							id="message-input"
							name="message"
							value="<?php echo( $_POST[ "message" ] ); ?>"
						>

						<span class="text-danger"><?php echo( $messageLengthErrMsg ); ?></span>
					</div>

					<span class="text-danger p-2">* Optional, Must be under 100 characters long</span>

					<div class="form-group row justify-content-center p-2">
						<input type="submit" class="col-auto btn btn-primary" value="Submit">
					</div>

					<span class="row justify-content-center text-success"><?php echo( $excecutionMessage ); ?></span>
				</form>
			</section>

			<section class="row justify-content-center p-5">
				<?php require "php/scripts/showPresentAccounts.php"; ?>
			</section>
		</main>

		<?php require 'php/html_elements/footer.php'; ?>
	</body>
</html>