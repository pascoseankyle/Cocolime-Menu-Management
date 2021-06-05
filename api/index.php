<?php 
	date_default_timezone_set('Asia/Manila'); 
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: PUT, POST, PATCH, OPTIONS, GET');
	header('Content-Type: application/json');       

    include_once './config/Database.php';
    include_once './models/post.php';
	include_once './models/auth.php';
    
	$database = new Database();
	$db = $database->connect(); // Database.php -> Database Clasee -> connect
	$post = new Post($db); // Post.php -> Post Class -> construct (db) _> Post functions
	$auth = new Auth($db);
	$data = array();
	$req = explode('/', rtrim($_REQUEST['request'], '/'));
	  switch ($_SERVER['REQUEST_METHOD']) {		
		  case 'POST':
			  switch ($req[0]) {
				// -------------------- Post Class ---------------------

				// ------------ INGREDIENTS -----------
				case 'ingredients': // Get All Ingredients
					$d = json_decode(base64_decode(file_get_contents("php://input")));
					echo json_encode($post->generalQuery("SELECT * FROM tbl_ingredients WHERE prod_id  = '$d->product_id'"));					
				break;
				case 'get_productId': // Get Product id
					echo json_encode($post->generalQuery("SELECT * FROM `tbl_products` ORDER BY product_id DESC LIMIT 1"));					
				break;
				case 'add_ingredients': // Add Ingredients
					$d = json_decode(base64_decode(file_get_contents("php://input")));
					echo json_encode($post->addIngredients($d));
				break;
				case 'update_ing': // Update Ingredients
					$d = json_decode(base64_decode(file_get_contents("php://input")));
					echo json_encode($post->editIng($d));
				break;
				// --------------- MENU -----------------
				case 'all_menu': // Get All Menu
					$d = json_decode(base64_decode(file_get_contents("php://input")));
					echo json_encode($post->generalQuery("SELECT * FROM tbl_products WHERE product_name LIKE '%$d%'"));					
				break;
				case 'add_menu': // Add Product
					$d = json_decode(base64_decode(file_get_contents("php://input")));
					echo json_encode($post->addProduct($d));
				break;
				case 'update_menu': // Update Product 
					$d = json_decode(base64_decode(file_get_contents("php://input")));
					echo json_encode($post->editProduct($d));
				break;
          		case 'delete_menu': // Delete Product 
					$d = json_decode(base64_decode(file_get_contents("php://input")));
                    echo json_encode($post->delProduct($d));
				break;

				// ----------- PROCESS | TO BE TESTED !! WARNING ---
				case 'proccess': // Process 
					$d = json_decode(base64_decode(file_get_contents("php://input")));
                    echo json_encode($post->proccess($d));
				break;
				
				// -------------------- Auth Class --------------------
				case 'register': // Add User
					$d = json_decode(base64_decode(file_get_contents("php://input")));
					echo json_encode($auth->registerUser($d));
				break;

				case 'login': //  Login User
					$d = json_decode(base64_decode(file_get_contents("php://input")));
					echo json_encode($auth->loginUser($d));
				break;

				default:
					http_response_code(400);
					echo "Bad Request";
				break;
			  }
		  break;
		  case 'GET':
			  switch ($req[0]) {

			  }
		  break;
		  default:
			  http_response_code(400);
			  echo "Bad Request";
		  break;
	  }

?>
