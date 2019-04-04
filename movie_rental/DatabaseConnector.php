<!-- This is a Database Adapter for personal website -->
<?php
	class DatabaseConnector{
	// The instance variable used in every function
		private $DB;
		// Make a connection to an existing data based named 'messages'
		public function __construct(){
			$db = 'mysql:dbname=csc337_final_project;charset=utf8; host=127.0.0.1';
			$user = 'root';
			// Local Server Use Only
			$password = '';
			
			
			try {
				$this->DB = new PDO ( $db, $user, $password );
				$this->DB->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			} 
			catch ( PDOException $e ){
				echo ('Error establishing Connection');
				exit ();
			}
		} 
		// ====================== Function for Message Form =======================

		public function getMessages() {
			$sql = "SELECT * FROM messages ORDER BY message_date DESC ";
			$stmt = $this->DB->prepare ($sql);
			$stmt-> execute();
			return $stmt->fetchAll( PDO::FETCH_ASSOC );
		}

		public function addMessage($message, $name, $email, $phone){
			$sql = "INSERT INTO messages (message, guest_name, guest_phone, guest_email, message_date) 
						VALUES (:message, :name, :phone, :email, now())";
			$stmt = $this ->DB ->prepare($sql) ;
			$stmt -> bindParam (':message', $message );
			$stmt -> bindParam (':name', $name);
			$stmt -> bindParam (':phone', $phone);
			$stmt -> bindParam (':email', $email);
			$stmt -> execute(); 
		}

		public function deleteMessage($messageID){
			$sql = "DELETE FROM messages WHERE message_ID= :messageID";

			$stmt = $this->DB->prepare ($sql);
			$stmt -> bindParam (':messageID', $messageID );
			
			$stmt -> execute();
		}

		// ====================== Function for Login/Sign up Form =======================

		public function addCustomer($firstName, $lastName, $email, $password){
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			try {
				// Insert new user to table users
				$sql_1 = "INSERT INTO users (username, password) 
							VALUES (:email, :hashed_password)";
				$stmt = $this ->DB ->prepare($sql_1);
				$stmt -> bindParam ('email', $email);
				$stmt -> bindParam ('hashed_password', $hashed_password);
				$stmt -> execute();

				$userID = $this ->DB-> lastInsertId();
			

				// Insert new customers to table customers
				$sql_2 = "INSERT INTO customers (first_name, last_name, user_email, user_ID, create_date)
							VALUES (:firstName, :lastName, :email, :userID, now())";
				$stmt = $this ->DB ->prepare($sql_2) ;
				$stmt -> bindParam (':firstName', $firstName);
				$stmt -> bindParam (':lastName', $lastName);
				$stmt -> bindParam (':email', $email);
				$stmt -> bindParam (':userID', $userID);
				$stmt -> execute();
				return 1;

			} 
			catch ( PDOException $e ){
				echo  $e->getMessage();
				return 0;
			}
		}

		public function verifyUser($username, $password){	
			// Option 1
			$sql = "SELECT * FROM users WHERE username = :username";			
			$stmt = $this-> DB-> prepare($sql);
			$stmt-> bindParam ( ':username', $username );
			$stmt -> execute();
			$array = $stmt-> fetchAll( PDO::FETCH_ASSOC );
			foreach ($array as $record){
				return password_verify($password, $record['password']);
			}
		}
		// Untest
		public function updateCustomer($first_name, $last_name, $old_username, $new_username){
			try {
				$sql_1 = "UPDATE users SET username = ':new_username' WHERE username = :old_username";
				
				$stmt = $this-> DB-> prepare($sql_1);

				$stmt-> bindParam ( ':old_username', $old_username );
				$stmt-> bindParam ( ':new_username', $new_username );
				$stmt -> execute();
		

				$sql_2 = "UPDATE customers SET user_email = :new_username,
										   SET first_name = :first_name,
										   SET last_name = :last_name,
				WHERE user_email = :old_username";


				$stmt = $this-> DB-> prepare($sql_2);

				$stmt-> bindParam ( ':first_name', $first_name );
				$stmt-> bindParam ( ':last_name', $last_name );
				$stmt-> bindParam ( ':new_username', $new_username );
				$stmt-> bindParam ( ':old_username', $old_username );
				$stmt -> execute();
				
				return 1;
			}	
			catch ( PDOException $e ){
				echo  $e->getMessage();
				return 0;
			}



		}

		// Elaina is in charge of below.
		// ====================== Function for Order Form =======================
		private function getCustomerID($username){
			$sql =  "SELECT customer_ID
		    		from customers
		    		WHERE user_email = :username";
			 
			$stmt = $this->DB->prepare ($sql);
			$stmt->bindParam ( ':username', $username );
			$stmt-> execute();
			return $stmt->fetchAll( PDO::FETCH_ASSOC );
		}
		
		
		// For Order Page
		 public function addOrder($username, $movie_id){
		 	// $myDatabase = new DatabaseConnector();
		  //   $array=$myDatabase->getCustomer_ID($username);
		 	$array = $this->getCustomerID($username);

            foreach ($array as $record){
	 	       $customer_ID= $record['customer_ID'];
	        }
		 	$sql1 = "INSERT INTO orders (customer_ID,order_date) 
						VALUES (:customer_ID, now())";
			$stmt = $this ->DB ->prepare($sql1) ;
			$stmt -> bindParam (':customer_ID', $customer_ID );
			$stmt -> execute();
			
			$order_ID = $this ->DB-> lastInsertId();
			
			for($i=0; $i<count($movie_id); $i++){
			$sql2 = "INSERT INTO order_details (movie_id,order_ID)
						VALUES (:movie_id,:order_ID)";
			$stmt = $this ->DB ->prepare($sql2) ;
			$stmt -> bindParam (':movie_id', $movie_id[$i] );
			$stmt -> bindParam (':order_ID', $order_ID);
			$stmt -> execute();
			}
		 }

		// ====================== Function for Search Bar =======================
		// For Search Result Page
		public function getMovie($movie) {
		    // Need the "%" symbols to allow like something like a search like *1952*
		    $movie = "%" . $movie . "%";
		    
		    // TODO: Complete this function so it returns all rows
		    // where the parameter is found as a substring, case insensitive
		    $sql ="SELECT DISTINCT movies.movie_ID, movies.name, movies.year, movies.rank, roles.role, actors.first_name, actors.last_name, actors.gender
		    		from movies
		    		JOIN roles ON movies.movie_ID=roles.movie_ID
		    		JOIN actors ON roles.actor_ID=actors.actor_ID
		    		WHERE name like :movie ORDER BY movies.name, movies.year, actors.first_name" ; 
		    
		    $stmt = $this->DB->prepare ($sql);
		    $stmt->bindParam ( ':movie', $movie );
		    $stmt->execute ();
		    return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		  }



		// For My Accout Page: 
		public function getUser($username){
		 	$sql =  "SELECT customer_ID, first_name, last_name, user_email, create_date
		    		from customers
		    		WHERE user_email = :username"; 
		    	
		 	$stmt = $this->DB->prepare ($sql);
		 	$stmt->bindParam ( ':username', $username );
		 	$stmt-> execute();
		 	return $stmt->fetchAll( PDO::FETCH_ASSOC );
		 }
		
		public function getOrder($username){
			// $myDatabase = new DatabaseConnector();
			// $array=$myDatabase->getCustomer_ID($username);
			$array = $this->getCustomerID($username);

			foreach ($array as $record){
				$customer_ID= $record['customer_ID'];
			}
			$sql = "SELECT DISTINCT orders.order_ID,  order_details.order_detail_ID, orders.order_date,  movies.name
				from orders
					JOIN order_details ON orders.order_ID=order_details.order_ID
					JOIN movies ON movies.movie_ID=order_details.movie_id
				WHERE orders.customer_ID=:customer_ID ORDER BY orders.order_date DESC"; // join multi tables
			$stmt = $this->DB->prepare ($sql);
			$stmt -> bindParam (':customer_ID', $customer_ID );
			$stmt-> execute();
			return $stmt->fetchAll( PDO::FETCH_ASSOC );
		}






	}


	// ========================================================================
	// ========================================================================
	//  Function Test Area:
	
	// ========================================================================
	// Test Connection (OK) 
	// $myDatabase = new DatabaseConnector();

	// ========================================================================

	// Test getMessages (OK)
	// $sql = "SELECT * FROM message ORDER BY Vote DESC, AddDate DESC ";
	// $array = $myDatabase->getMessages();
	// foreach ($array as $record){
	// 	echo 'ID: '. $record['ID']. ' Message:'. $record['Message'] . ' Name:'. $record['Name'].  "<br>". PHP_EOL;
	// }


	// ========================================================================
	// Test addMessage (OK)
	// $myDatabase->addMessage("Yesterday is hot day", "Helen Wang", "helen@gmail.com", "555-000-0008");

	// ========================================================================
	// Test deleteMessage (OK) 
	// $id =13 ;
	// $myDatabase ->deleteMessage($id);

	// ========================================================================
	// // Test addCuostomer (OK)
	// $firstName = 'Johnny';
	// $lastName = 'Hsu';
	// $email = 'johnnyhsu1106@gmail.com';
	// $password = '11111111';
	// $myDatabase->addCustomer($firstName, $lastName, $email, $password);
	// echo"Succcessfully add customer";

	// ========================================================================

	// Test verifyUser (OK)
	// $userName = 'johnnyhsu1106@gmail.com';
	// $password = '11111111';
	// $myDatabase->verifyUser($userName, $password);
	// echo"Succcessfully verify user";
	// ========================================================================

     //Test addOrder($username, $movie_id)
	 // $username='johnnyhsu1106@gmail.com';; 
	 // $movie_id=array(17173, 18929);
	 // $myDatabase->addOrder($username, $movie_id);
	 // echo"Successfully add order";
	
	 // ========================================================================
	//Test getUserInfo
	//$username='johnnyhsu1106@gmail.com';
	//$array=$myDatabase->getUserInfo($username);
	//echo json_encode($array);
			
	// ========================================================================
	//Test getMovieInfo

	//$input='#28';
	//$array=$myDatabase->getMovie($input);
	//echo json_encode($array);
    // ========================================================================
	//Test function getOrder($username)
	// $username='johnnyhsu1106@gmail.com';
	// $array=$myDatabase->getOrder($username);
	// print_r($array);
	// echo json_encode($array);

	// Test getMovieID($movie) (OK)
	// $movie ="Aliens";
	// $array = $myDatabase -> getMovieID($movie);
	// print_r($array);

	// // Test updateCustomer()
	// $first_name = "Kevin";
	// $last_name = "Hsu";
	// $old_username = "johnnyhsu1106@gmail.com";
	// $new_username = "johnnyhsu1106@gmail.com";
	// $myDatabase->updateCustomer($first_name, $last_name, $old_username, $new_username);






	
 ?>