<?php 
	class Post {
        private $results = array();
		private $conn;
		private $sql;
		private $data = array();
		private $info = [];
		private $status =array();
		private $failed_stat = array(
			'remarks'=>'failed!',
			'message'=>'Failed to retrieve the requested records'
		);
		private $success_stat = array(
			'remarks'=>'success!',
			'message'=>'Successfully retrieved the requested records'
		);
		public function __construct($db){
			$this->conn = $db;
		}
// Fuctions ----------------------------------------------------------		

		// SELECT ------- WORKING ------
		function select($table, $filter_data){
			$this->sql = "SELECT * FROM $table";

			if($filter_data!=null){
				$this->sql = "SELECT * tbl_ingredients WHERE prod_id ='$filter_data'";
			}

			if($result = $this->conn->query($this->sql)){
				if($result->num_rows>0){
					while($res = $result->fetch_assoc()){
						array_push($this->data, $res);
					}
					$this->status = $this->success_stat;
					http_response_code(200);
				}
			}
			return array(
				'status'=>$this->status,
				'timestamp'=>date('D M j, Y G:i:s T')
			);
		}
		// GENERAL QUERY ------ WORKING ----
        function generalQuery($query){
            $this->result = $this->conn->query($query);
            $rowCount = $this->result->num_rows;
            if ($this->result->num_rows>0) {
                while($res = $this->result->fetch_assoc()){
                    array_push($this->data,$res);
                }
                return $this->info = array(
                        'status'=>array(
                        'remarks'=>true,
                        'message'=>'success!'
                    ),
                    'data' =>$this->data,
                    'payload'=>$this->data,
                    'dataCount'=>$rowCount,
                    'timestamp'=>date('D M j, Y h:i:s e')
                );
            } 
			else {
                return $this->info = array('status'=>array(
                'remarks'=>false,
                'payload'=>$this->data,
                'dataCount'=>$rowCount,
                'message'=>'failed!'),
                'timestamp'=>date('D M j, Y h:i:s e')
			 	);
            }
        }
		// ADD PRODUCT ------------- WORKING ---------------
		function addProduct($data){
            $this->sql = "INSERT INTO `tbl_products`(`product_id`, `product_name`, `product_price`, `product_type`) 
            VALUES ('$data->id', '$data->product_name', '$data->product_price', '$data->product_type')"; 
            $this->conn->query($this->sql);
            $this->status = $this->success_stat;
			http_response_code(200);
            return array(
				'status'=>$this->status,
				'timestamp'=>date('D M j, Y G:i:s T')
			);
        }
		// DELETE PRODUCT ------------ WORKING ---------------
		function delProduct($data){
            $this->sql = "DELETE FROM tbl_products WHERE product_id = '$data->product_id'"; 
            $this->conn->query($this->sql);
			$this->sql = "DELETE FROM tbl_ingredients WHERE prod_id = '$data->product_id'"; 
            $this->conn->query($this->sql);
            $this->status = $this->success_stat;
			http_response_code(200);
            return array(
				'status'=>$this->status,
				'timestamp'=>date('D M j, Y G:i:s T')
			);
        }
		// UPDATE PRODUCT --------------- WORKING -----------
		function editProduct($data){
            $this->sql = "UPDATE `tbl_products` SET `product_name`='$data->product_name',
            `product_price`='$data->product_price',`product_type`='$data->product_type' WHERE `product_id`='$data->product_id' ";
            $this->conn->query($this->sql);
            $this->status = $this->success_stat;
			http_response_code(200);
            return array(
				'status'=>$this->status,
				'timestamp'=>date('D M j, Y G:i:s T')
			);
        }
        // ADD INGREDIENTS ---- WORKING -------
		function addIngredients($data){
            foreach($data->ingredients as $index => $value){
                $this->sql = "INSERT INTO `tbl_ingredients`(`ing_name`, `ing_quantity`, `prod_id`) VALUES ('$value','{$data->qty[$index]}','$data->id')";
                $this->conn->query($this->sql);
            }
            $this->status = $this->success_stat;
			http_response_code(200);
            return array(
                'status'=>$this->status,
                'timestamp'=>date('D M j, Y h:i:s e')
            );
        }
        function addIngredientProducts($data){
            $this->sql = "INSERT INTO `tbl_ingredients`(`ing_name`, `ing_quantity`, `prod_id`) VALUES ('$data->name','$data->qty','$data->id')";
            $this->conn->query($this->sql);
            $this->status = $this->success_stat;
			http_response_code(200);
            return array(
                'status'=>$this->status,
                'timestamp'=>date('D M j, Y h:i:s e')
            );
        }
        // UPDATE INGREDIENTS ------- WORKING --------
        function editIngredients($data){
            $this->sql = "UPDATE `tbl_ingredients` SET `ing_name`='$data->ing_name',`ing_quantity`='$data->ing_quantity' WHERE ing_id = $data->ing_id";
            $this->conn->query($this->sql);
            $this->status = $this->success_stat;
			http_response_code(200);
            return array(
				'status'=>$this->status,
				'timestamp'=>date('D M j, Y G:i:s T')
			);
        }     
        // DELETE INGREDIENTS ----- WORKING -------s
        function deleteIngredients($data){
            $this->sql="DELETE FROM `tbl_ingredients` WHERE `ing_id` = $data->ing_id";
            $this->conn->query($this->sql);
            $this->status = $this->success_stat;
			http_response_code(200);
            return array(
				'status'=>$this->status,
				'timestamp'=>date('D M j, Y G:i:s T')
			);
        }
        // AVAILABLE --------- WORKING ---------
        function checkAvaialble(){
            $empty = array();
			$this->sql = "SELECT * FROM tbl_ingredients";
            if($result = $this->conn->query($this->sql)){
				if($result->num_rows>0){
					while($res = $result->fetch_assoc()){
                        array_push($this->data, $res);
					} 
				}
			}
            foreach ($this->data as $index => $value){
                if($value['ing_quantity'] == 0){
                    $this->sql = "UPDATE tbl_products SET `available` = 0  WHERE product_id = {$value['prod_id']} ";
                    $this->conn->query($this->sql);
                    array_push($empty, $value);
                }
            }
            if(empty($empty)){
                $this->sql = "UPDATE tbl_products SET `available` = 1  WHERE 1";
                $this->conn->query($this->sql); 
            }
            $this->status = $this->success_stat;
			http_response_code(200);
			return array(
				'status'=>$this->status,
				'timestamp'=>date('D M j, Y G:i:s T')
			);
		}

        // ------------ POINT OF SALES -----------------

        // DECREASE INGREDIENT FROM POS ------ WORKING -------   
        function proccess($data){
            $payload = $data;
            $this->sql = "UPDATE `tbl_ingredients` SET `ing_quantity`= ing_quantity - 1 WHERE prod_id = $data->product_id";
            $this->conn->query($this->sql);
            return array(
				'status'=>$this->status,
				'timestamp'=>date('D M j, Y G:i:s T')
			);
        }
        
        // ---------- INVENTORY -------------------------

        // INCREASE INGREDIENTS FROM INVENTORY ---------
        function addIngredientsQty($data){
            foreach ($data->ingredients as $index => $value) {
                $this->sql = "UPDATE `tbl_ingredients` SET `ing_quantity`='$data->quantity' WHERE `prod_id` = '$data->id' ";
                $this->conn->query($this->sql);
                $this->sql = "UPDATE `tbl_products` SET `available`='1' WHERE `product_id` = '$data->id' ";
                $this->conn->query($this->sql);
            }
            return array(
                'status'=>$this->status,
                'timestamp'=>date('D M j, Y h:i:s e')
            );
        }

	}
?>
