<?php 
	class Student{

		// declare variables
		public $name;
		public $email;
		public $mobile;
		public $id;

		private $conn;
		private $table_name;


		// constructor
		public function __construct($db){

			$this->conn = $db;
			$this->table_name = "tbl_students";
		}

		public function create_data(){

			// sql query to insert data
			$query = "INSERT INTO ".$this->table_name." SET name = ?, email = ?, mobile = ?";

			// prepare the sql
			$obj = $this->conn->prepare($query);

			// sanitize input variable => basically removes the extra characters like some synmbols as well as if some tags available in input variable

			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->email = htmlspecialchars(strip_tags($this->email));
			$this->mobile = htmlspecialchars(strip_tags($this->mobile));


			// binding parameters with prepare statement
			$obj->bind_param("sss", $this->name, $this->email, $this->mobile);

			if($obj->execute()){ //executing query

				return true;
			}

			return false;
		}


		// read all data
		public function get_all_data(){
			$sql_query = "SELECT * from ".$this->table_name;

			$std_obj = $this->conn->prepare($sql_query); //prepare statement

			//execute query
			$std_obj->execute();


			return $std_obj->get_result();
		}

		// read single student data
		public function get_single_student(){

			$sql_query = "SELECT * FROM ".$this->table_name." WHERE id = ?";

			// prepare statement

			$obj = $this->conn->prepare($sql_query);

			$obj->bind_param("i", $this->id);  //bind parameters with the prepared statement
			$obj->execute();

			$data = $obj->get_result();

			return $data->fetch_assoc();
		}

		// update student information
		public function update_student(){
			// query
			$update_query = "UPDATE tbl_students SET name = ?, email = ?, mobile = ? WHERE id = ? ";

			// prepare statement
			$query_object = $this->conn->prepare($update_query);

			// sanitizing inputs
			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->email = htmlspecialchars(strip_tags($this->email));
			$this->mobile = htmlspecialchars(strip_tags($this->mobile));
			$this->id = htmlspecialchars(strip_tags($this->id));

			// binding parameters with the query
			$query_object->bind_param("sssi", $this->name, $this->email, $this->mobile, $this->id);

			// execute query
			if($query_object->execute()){
				return true;
			}
			return false;
		}


		// delete student
		public function delete_student(){
			$delete_query = "DELETE from ".$this->table_name." WHERE id = ?";
			// prepare query
			$delete_obj = $this->conn->prepare($delete_query);

			// sanitize inputs
			$this->id = htmlspecialchars(strip_tags($this->id));

			//bind parameter
			$delete_obj->bind_param("i",$this->id);

			if($delete_obj->execute()){
				return true;
			}
			return false;
		}
	}



?>