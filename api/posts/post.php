<?php

class Post{
  private $conn;
  private $sql;
  private $info = [];
  private $data = array();
  private $status;
  private $failed_stat = array (
    'remarks' => 'failed',
    'message' => 'Failed to retrieve requested records'
  );
  private $success_stat = array (
    'remarks' => 'success',
    'message' => 'Successfully retrieved records'
  );

  public function __construct($db){
			$this->conn = $db;
  }

  function select($table, $filter_data){
    $this->sql="SELECT * FROM `$table` WHERE 1";
    if ($filter_data != null) {
      $this->sql = "SELECT * FROM `$table` WHERE id = $filter_data";
    }
    if ($result = $this->conn->query($this->sql)) {
      if ($result->num_rows > 0) {
          while($res = $result->fetch_assoc()){
            array_push($this->data, $res);
          }
        $this->status = $this->success_stat;
        http_response_code(200);
      }
      else{
        $this->status = $this->failed_stat;
        http_response_code(400);
      }
    }
    return array(
      'status'=>$this->status,
      'payload'=>$this->data,
      'prepared by'=>', FOOD DATA',
      'timestamp'=>date('D M j, Y G:i:s T')
    );
  }
  function select_food_ing($table, $filter_data){
    $this->sql="SELECT tbl_ingredients.prod_id, tbl_ingredients.ing_name, tbl_ingredients.ing_quantity, tbl_products.product_id FROM tbl_ingredients INNER JOIN tbl_products WHERE tbl_products.product_id = tbl_ingredients.prod_id";
    if ($filter_data != null) {
      $this->sql = "SELECT * FROM `$table` WHERE id = $filter_data";
    }
    if ($result = $this->conn->query($this->sql)) {
      if ($result->num_rows > 0) {
          while($res = $result->fetch_assoc()){
            array_push($this->data, $res);
          }
        $this->status = $this->success_stat;
        http_response_code(200);
      }
      else{
        $this->status = $this->failed_stat;
        http_response_code(400);
      }
    }
    return array(
      'status'=>$this->status,
      'payload'=>$this->data,
      'prepared by'=>', FOOD DATA',
      'timestamp'=>date('D M j, Y G:i:s T')
    );
  }
}
 ?>
