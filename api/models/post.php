<?php 
	class Post {
		private $conn;
		private $sql;
		private $data = array();
		private $info = [];
		private $status =array();
		private $failed_stat = array(
			'remarks'=>'failed',
			'message'=>'Failed to retrieve the requested records'
		);
		private $success_stat = array(
			'remarks'=>'success',
			'message'=>'Successfully retrieved the requested records'
		);
		public function __construct($db){
			$this->conn = $db;
		}
// Fuctions ----------------------------------------------------------		
		// SELECT ------- WORKING ------
		function select($table, $filter_data) {
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
				'payload'=>$this->data,
				'prepared_by'=>'Inventory bois',
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
                        'message'=>'Data retrieval successful.'
                    ),
                    'data' =>$this->data,
                    'payload'=>$this->data,
                    'dataCount'=>$rowCount,
                    'timestamp'=>date('D M j, Y h:i:s e'),
                    'prepared_by'=>'Inventory Admin'
                );
            } 
			else {
                return $this->info = array('status'=>array(
                'remarks'=>false,
                'payload'=>$this->data,
                'dataCount'=>$rowCount,
                'message'=>'Data retrieval failed.'),
                'timestamp'=>date('D M j, Y h:i:s e'),
                'prepared_by'=>'Inventory Admin'
			 	);
            }
        }
		// ADD PRODUCT ------------- WORKING ---------------
		function addProduct($dt) {
            $payload = $dt;
            $this->sql = "INSERT INTO `tbl_products`(`product_id`, `product_name`, `product_price`, `product_type`) 
            VALUES ('$dt->id', '$dt->product_name', '$dt->product_price', '$dt->product_type')"; 
            $this->conn->query($this->sql);
            $this->data = $payload;
            return array(
                'status'=>$this->status,
                'payload'=>$this->data,
                'prepared_by'=>'Inventory Staff',
                'timestamp'=>date('D M j, Y h:i:s e')
            );
        }
		// DELETE PRODUCT ------------ WORKING ---------------
		function delProduct($dt) {
            $payload = $dt;
            $this->sql = "DELETE FROM tbl_products WHERE product_id = '$dt->product_id'"; 
            $this->conn->query($this->sql);
			$this->sql = "DELETE FROM tbl_ingredients WHERE prod_id = '$dt->product_id'"; 
            $this->conn->query($this->sql);
            $this->data = $payload;
            return array(
                'status'=>$this->status,
                'payload'=>$this->data,
                'prepared_by'=>'Inventory Admin',
                'timestamp'=>date('D M j, Y h:i:s e')
            );
        }
		// UPDATE PRODUCT --------------- WORKING -----------
		function editProduct($dt){
            $payload = $dt;
            $this->sql = "UPDATE `tbl_products` SET `product_name`='$dt->product_name',
            `product_price`='$dt->product_price',`product_type`='$dt->product_type' WHERE `product_id`='$dt->product_id' ";
            $this->conn->query($this->sql);
            return $this->select('tbl_products', null);
        }
        // ADD INGREDIENTS ---- WORKING -------
		function addIngredients($dt) {
            $payload = $dt;
            foreach($dt->ingredients as $index => $value){
                $this->sql = "INSERT INTO `tbl_ingredients`(`ing_name`, `ing_quantity`, `prod_id`) VALUES ('$value','{$dt->qty[$index]}','$dt->id')";
                $this->conn->query($this->sql);
            }
            $this->data = $payload;
            return array(
                'status'=>$this->status,
                'payload'=>$this->data,
                'prepared_by'=>'Inventory Staff',
                'timestamp'=>date('D M j, Y h:i:s e')
            );
        }
        // UPDATE INGREDIENTS ------- WORKING --------
        function editIng($dt){
            $payload = $dt;
            $this->sql = "UPDATE `tbl_ingredients` SET `ing_name`='$dt->ing_name',`ing_quantity`='$dt->ing_quantity' WHERE ing_id = $dt->ing_id";
            $this->conn->query($this->sql);
            return $this->select('tbl_ingredients', null);
        }     
        // DECREASE INGREDIENT FROM POS ------ WORKING -------   
        function proccess($dt) {
            $payload = $dt;
            $this->sql = "UPDATE `tbl_ingredients` SET `ing_quantity`= ing_quantity - 1 WHERE prod_id = $dt->product_id";
            $this->conn->query($this->sql);
            return $this->select('tbl_ingredients', null);
        }
	}
?>
