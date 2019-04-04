<?php
	session_start();
?>

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
	
	<!-- Login & Sign up Validator -->
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
	<header id="home">
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">
				    	<img src="image/online-movie-rental-logo.png" alt="online movie rental logo" class="img-responsive"> 
				    </a>

					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation" aria-expanded="false">
						<span class="sr-only">Toggle nahomvigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
				    </button>
				   
				</div>

				<div class="collapse navbar-collapse" id="navigation">	
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle text-center" data-toggle="dropdown">
								Your Favorite Movie Genre <span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li><a href="#">Action</a></li>
								<li><a href="#">Family</a></li>
								<li><a href="#">Romance</a></li>
								<li><a href="#">Comedy</a></li>
								<li><a href="#">Honor</a></li>
								<li><a href="#">Sci-Fi and Fantancy</a></li>
								<li><a href="#">Drama</a></li>
								<li><a href="#">Kids</a></li>
								<li><a href="#">Suspense</a></li>
							</ul>
						</li>
					</ul>



<!--=============================== Chooseer different header based on guest or user =============================== -->
<?php
	require_once "./DatabaseConnector.php";
	$myDatabase = new DatabaseConnector();
	
	// =============================== if it is user ===============================
	if (isset ($_SESSION['username']) || (!empty($_COOKIE['username']) && isset($_COOKIE['username']) )){
	
		echo '
					<ul class="nav navbar-nav navbar-right">
						<li ><a href="index.php" class="text-center"><span class="glyphicon glyphicon-home"></span> Home<span class="sr-only">(current)</span></a></li>
						<li ><a href="my_account.php" class="text-center" "><span class="glyphicon glyphicon-user"></span> My Account</a></li>
						<li ><a href="#" class="text-center" data-toggle="modal" data-target="#sign_out_form"><span class="glyphicon glyphicon-log-out"></span> Sign out</a></li>';

		if (isset($_SESSION['moviesToDownload']) and !empty($_SESSION['moviesToDownload'])){
			echo "<li><a><span class='glyphicon glyphicon-shopping-cart'></span><span class='badge'>"; 
			echo count($_SESSION['moviesToDownload'])."</span>";
			echo "</a></li>";

		}
		else{
			echo "<li><a><span class='glyphicon glyphicon-shopping-cart'></span><span class='badge'>". 0 . "</span>";
			echo "<i class='fa fa-angle-right'></i></a></li>";
		}
		echo '				
					</ul>
					
				</div>
			</div>
		</nav>

	</header>

	<!-- =============================== Sign Out Form Start =============================== -->

	<div class="container">
	  	<!-- Modal -->

		<div class="modal" id="sign_out_form" role="dialog">
			<div class="modal-dialog modal-sm">
			<!-- Modal content-->
				<form class="form-group modal-content" data-toggle="validator" role="form" action="./controller.php" method="post">
		
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
	';

	}
	// =============================== if it is guest ===============================
	else{
		echo '
					<ul class="nav navbar-nav navbar-right">
						<li ><a href="index.php" class="text-center"> <span class="glyphicon glyphicon-home"></span> Home<span class="sr-only">(current)</span></a></li>
						<li ><a href="#" class="text-center" data-toggle="modal" data-target="#login_form"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
						<li ><a href="#" class="text-center" data-toggle="modal" data-target="#sign_up_form"><span class="glyphicon glyphicon-user"></span> Sign up</a></li>
						
					</ul>
				</div>
			</div>
		</nav>

	</header>

		<!-- =============================== Login Form Start =============================== -->
	<div class="container">
	  <!-- Modal -->
		<div class="modal" id="login_form" role="dialog">
			<div class="modal-dialog modal-sm">

			<!-- Modal content-->
				<form class="form-group modal-content" data-toggle="validator" role="form" action="./controller.php" method="post">
	
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title text-center">Login</h4>
					</div>

					<div class="modal-body">

						<div class="text-center input-group">
							<label for="login_username" class="hidden">username</label>
							 <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input type="text" name="username" id="login_username"  class="form-control" placeholder="Email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" data-error="This email address is invalid">
						</div>
						<div class="text-center input-group">
							<label for="login_password" class="hidden">password</label>
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input type="password" name="password" id="login_password" class="form-control"  placeholder="Password" required>
						</div>
						<div class="help-block">Minimum of 8 characters</div>
						
						
						<div class="text-center checkbox">
							<input type="checkbox" id="remember-me" name="rememberMe" value="1"><label for="remember-me"> Remember me</label>
						</div>
					</div>
			
					<div class="modal-footer">
						<div class="help-block with-errors"></div>
						<div class="help-block"><a href="">Forget your password ?</a></div>
						<button type="submit" class="btn btn-primary" name="login">Login</button>
					</div>

				</form>
			</div>
		</div>
		  
	</div>
	<!-- =============================== Login Form End =============================== -->

	
	<!-- =============================== Sign Up Form Start =============================== -->
	<div class="container-fluid">
	  <!-- Modal -->
		<div class="modal" id="sign_up_form" role="dialog">
			<div class="modal-dialog modal-md">
			<!-- Modal content-->
				<form class="form-group modal-content" data-toggle="validator" role="form" action="./controller.php" method="post">
	
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title text-center">Sign Up</h4>
					</div>

					<div class="modal-body has-feedback">

						<div class="row">

							<div class="col-sm-5 col-sm-offset-1">
								<div class="text-center input-group ">
									<label for="first_name" class="hidden">First Name</label>
									<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									<input type="text" name="firstName" id="first_name" class="form-control" placeholder="First Name" required>
								</div>
							</div>

							<div class="col-sm-5">
								<div class="text-center input-group">
									<label for="last_name" class="hidden">Last Name</label>
									<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									<input type="text" name="lastName" id="last_name" class="form-control" placeholder="Last Name" required>
								</div>
							</div>

						</div>

						<div class="row">
							<div class="col-sm-10 col-sm-offset-1">

								<div class="text-center input-group">
									<label for="signin_username" class="hidden">Email</label>
									 <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
									<input type="text" name="userEmail" id="signin_username"  class="form-control" placeholder="Email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" data-error="This email address is invalid">
								</div>

							</div>
						</div>


						<div class="row">

							<div class="col-sm-5 col-sm-offset-1">
								<div class="text-center input-group">
									<label for="signin_password" class="hidden">password</label>
									<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
									<input type="password" name="password" id="signin_password" data-minlength="8" class="form-control"  placeholder="Password" required>
								</div>
								<div class="help-block">Minimum of 8 characters</div>

							</div>

							<div class="col-sm-5">
								<div class="text-center input-group">
									<label for="confirm_password" class="hidden">confirm password</label>
									<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
									<input type="password" name="password" id="confirm_password" data-minlength="" class="form-control"  placeholder="Confirm Password" data-match="#signin_password" data-match-error="Password doesn\'t match" required>
								</div>

								<div class="help-block with-errors"></div>
							</div>

						</div>
						

					</div>

					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" name="signUp">Sign up</button>
					</div>


				</form>
			</div>
		</div>
		  
	</div>
	<!-- =============================== Sign Up Form End ===============================-->

	';
	}
?>


	<main>
		<section class="container-fluid">
			<div class= "row">
				<div class ="col-xs-12 col-sm-6  col-sm-offset-3">
		<?php
		// require_once "./DatabaseConnector.php";
		// $myDatabase = new DatabaseConnector();	
		// print_r($_SESSION['moviesToDownload']);
		echo "<section class='container-fluid' >";
		echo "<div class= 'row'>";
		echo "<div class ='col-xs-12 col-sm-8  col-sm-offset-2'>";
		echo "<h3>Your Shopping Cart List</h3>";
		
		echo "<form action='controller.php' method = 'post'>";
		echo "<ul class='list-group'>";

		foreach ($_SESSION['moviesToDownload'] as $movieName ){
	
			
			echo "<li class='text-left'> ". "<b> Movie: </b>". $movieName."</h4>";

		}
		echo "</ul>";
		echo "<div class='text-right'> <button id='". $movieName ."' name='addToOrder' type='submit' class='btn btn-primary add-to-cart text-center''> Click to Download </button></div>";
		echo "</form>";
		echo "</div>";
		echo "</div>";
		echo "</section>";


		?>
				</div>
			</div>
		</section>
	</main>


<!--=============================== Footer Start =============================== -->
	<footer>
		<div class="container-fluid">
			<div class="row"> 
				<div class="col-xs-5 col-xs-offset-1 col-sm-2 col-sm-offset-0">
					<h4 class="">Find</h4>
					<ul class="list-group">
						<li><a href="">New Movie</a></li>
						<li><a href="">All Movies</a></li>
						<li><a href="">Top 10 Movie</a></li>
					</ul>
				</div>
				<div class="col-xs-5 col-sm-2">
					<h4 class="">Accounts</h4>
					<ul class="list-group">
						<li><a href="">My Rentals</a></li>
						<li><a href="">My Account Info</a></li>
						<li><a href="">Create an Account</a></li>
						
						
					</ul>
				</div>

				<div class="col-xs-5 col-xs-offset-1 col-sm-2 col-sm-offset-0">
					<h4 class="">Contact Us</h4>
					<ul class="list-group">
						<li><a href="">FAQ</a></li>
						<li><a href="">Forum</a></li>
						<li><a href="">Need Help?</a></li>
					</ul>
				</div>
				
				<div class="col-xs-5 col-sm-2">
					<h4 class="">About Us</h4>
					<ul class="list-group">
						<li><a href="">News</a></li>
						<li><a href="">Careers</a></li>
						<li><a href="">Company</a></li>
						<li><a href="">Media Center</a></li>
					</ul>
				</div>


				<!-- =============================== Socail Icon Start =============================== -->
				<div class="col-xs-12 col-sm-4">
					<h4 class="text-center">Follow Us</h4>
					<div class="text-center" id="social_icon">
						<a href="#" title= "Tweeter" target="_blank"><i class="fa fa-twitter fa-2x" aria-hidden="true"></i></a>
						<a href="#" title="Facebook" target="_blank" ><i class="fa fa-facebook fa-2x" aria-hidden="true"></i></a>
						<a href="#" title="Instagram" target="_blank"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a>
						<a href="" title="Youtube" target="_blank"><i class="fa fa-youtube-play fa-2x" aria-hidden="true"></i></a>
						<a href="" title="Email" target="_blank"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i></a>
						
					</div>
					
                    <h4 class="text-center"> Get The App                        
                    </h4>
         
                   	<div class="text-center">
                    <a id="social_iphone"  href="" target="_blank">
                    	<img src="image/apple-app-store-icon.png" alt="" class="float-xs-left img-responsive" >
                    </a>
                    <a id="social_android"  href="" target="_blank">
						<img src="image/google-play-store-icon.png" alt="" class="float-xs-left img-responsive">
					</a>
					</div>

                </div>
                <!-- =============================== Socail Icon End =============================== -->

			</div>
	
		</div>

		<div class="row"> 
			<h6 class="text-center"> &copy; 2016 CSC337 Web Programming Final Project
			</h6>
		</div>

		
	</footer>
</body>
</html>