
<?php
	require_once "./DatabaseConnector.php";
	$myDatabase = new DatabaseConnector();
	session_start();

	if (isset($_POST['submitMessage'])){
		$message = $_POST['message'];
		$name = $_POST['guestName'];
		$email = $_POST['guestEmail'];
		$phone = $_POST['guestPhone'];
		$myDatabase->addMessage($message, $name, $email, $phone);

		header ( "Location: ./message_received.php" );
		
	}

	else if (isset($_POST['deleteMessage'])){
		$id = $_POST['messageID'];
		$myDatabase->deleteMessage($id);
		header("Location: administrator_message.php");
	}

	
	// check user login
	else if (isset($_POST['login'])){
		$username = $_POST['username'];
		$password = $_POST['password'];

		if ($myDatabase -> verifyUser($username, $password)){
			$_SESSION['username'] = $username;
			// set the cookie
			if (isset($_POST['rememberMe'])){	
				setcookie('username', $username, time() + 86400, "/"); 
				setcookie('password', password_hash($password, PASSWORD_DEFAULT), time() + 86400, "/");  
		    }

		    header("Location: ./index.php");
		}

		else{
			header("Location: ./login_failed.html");

		}
	}


	// Check user sign up
	else if (isset($_POST['signUp'])){

		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$email = $_POST['userEmail'];
		$password = $_POST['password']; 	
		$_SESSION['username'] = $email;

		
		if ($myDatabase->addCustomer($firstName, $lastName, $email, $password)){
			header("Location: ./index.php");
			
		}
		else{
			header("Location: ./signup_failed.html");
	
		}
		
	
	}


	else if (isset($_POST['signOut'])){
		session_unset(); 
		session_destroy();
		setcookie("username", '', time()-3600, "/" );
		setcookie("password", '', time()-3600, "/" );
		header ( "Location: ./index.php" );
	}

	// 
	else if (isset($_POST['addToCart'])){
		$movie = $_POST['movieToDownload'];
		$movie_ID = $_POST['movieIDToDownload'];
		
		if( ! isset($_SESSION['moviesToDownload'])){
			$_SESSION['moviesToDownload']= array();	
			$_SESSION['moviesIDToDownload']= array();	
		}
		
		array_push($_SESSION['moviesToDownload'], $movie);
		array_push($_SESSION['moviesIDToDownload'], $movie_ID);
		header("Location: ./index.php");

	}
	else if (isset($_POST['addToOrder'])){
		
		$myDatabase->addOrder($_SESSION['username'],$_SESSION['moviesIDToDownload']);
		$_SESSION['moviesToDownload']= array();
		$_SESSION['moviesIDToDownload']= array();

		header("Location: ./movie_download.php");
	}

	else if (isset($_POST['changeCustomerInfo'])){

		$first_name = $_POST['firstName'];
		$last_name = $_POST['lastName'];
		$old_username = $_POST['oldUsername'];
		$new_username = $_POST['newUsername'];
		echo $first_name;
		echo $last_name;
		echo $old_username;
		echo $new_username;
		
		

		// if ($myDatabase->updateCustomer($first_name, $last_name, $old_username, $new_username)){
		// 	header("Location: ./my_account.php");

			
		// }
		// else{
		// 	header("Location: ./signup_failed.html");
	
		// }


	}
	
	
	else{
		header ( "Location: ./index.php" );
	}


?>