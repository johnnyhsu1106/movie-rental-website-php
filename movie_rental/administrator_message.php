<!DOCTYPE html>
<html>
<head>
	<title>U of A Movie Rental</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	<!-- Login & Sign in Validator -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
	<!-- Jquery Mobile First  -->
	<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
	<!-- <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script> -->

	<!-- Personal Javascript -->
	<!-- <script type="text/javascript" src = "js/script.js"></script> -->

	<!-- Icon -->
	<script src="https://use.fontawesome.com/7d8711138e.js"></script>

	<!-- Personal CSS -->
	<link rel="stylesheet" type="text/css" href="css/style.css">

	

</head>

<body>
	<div class="container">

		<div class= "row">
			<h1 class='center-block text-center col-xs-12 col-md-12 col-lg-12'>Message</h1>
		</div>


	<?php
		require_once "./DatabaseConnector.php";
		
		$myDatabase = new DatabaseConnector();
		$array = $myDatabase->getMessages();
		foreach ($array as $record){
			echo "<div class= 'row'>";
			echo "<div class ='col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'> ";
			// For Local Server Only:
			echo "<form action='./controller.php' method='post'>";

			
			
			echo "<p class='message text-left'>". $record['message'] . "</p>";
			echo "<p class ='text-right'><a class='email' href='mailto:". $record['guest_email'] ."'>".$record['guest_email'] . "</a>". "</p>";
			echo "<p class='name text-right'> ". $record['guest_name'] ." --- ". $record['message_date'] ."</p>";
			echo "<input type ='hidden' class = 'ID' name = 'messageID' value =' " . $record['message_ID']   . "' >" ;
			echo "<button type='submit' name='deleteMessage' class='btn btn-danger active pull-right'> Delete </button>" ;
			echo "</form>";
			echo "</div>";
			echo "</div>";
				
		}
	?>
		<div class="row logout">
			<div class="btn btn-lg text-center col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-4 col-lg-2 col-lg-offset-5">
				<a href="#" class="text-center" data-toggle="modal" data-target="#sign_out_form"><span class="glyphicon glyphicon-log-out"></span> Sign out</a>
			</div>
		</div>
		<!-- End of Container -->
	</div>


	<!-- =============================== Sign Out Form Start =============================== -->
	<div class="container">
	  <!-- Modal -->
		<div class="modal" id="sign_out_form" role="dialog">
			<div class="modal-dialog modal-sm">
			<!-- Modal content-->
				<form class="form-group modal-content" data-toggle="validator" role="form" action="./controller.php" method="post">
			<!--   <div class="modal-content"> -->
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title text-center">Sign out</h4>
					</div>

					<div class="modal-body">
						<div class="help-block">Are you sure you want to sign out?</div>		
					</div>
			
					<div class="modal-footer">
						<div class="help-block with-errors"></div>
						<button type="submit" class="btn btn-primary" name="signOut">Sign out</button>
						<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel
						</button>
					</div>
				</form>
			</div>
		</div>
		  
	</div>
	<!-- ===============================Sign Out Form End=============================== -->


</body>
</html>