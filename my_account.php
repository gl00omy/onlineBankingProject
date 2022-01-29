<?php

session_start();

require "php/scripts/connectToDatabase.php";

// require "php/scripts/transactionsVariables.php";
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

			// if( stillHaveTime() ) refactor creating a combination array in the Queries interface
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

			function getSelectedOrderingOption( id )
			{
				let element = document.getElementById( id ).selectedIndex;
				return document.getElementsByTagName( "option" )[ element ].value;
			}

		</script>
	</head>

	<body onload="displayTransactionsTables()">
		<?php require 'php/html_elements/header.php'; ?>

		<main class="container-fluid m-0">
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
		</main>

		<?php require 'php/html_elements/footer.php'; ?>
	</body>
</html>