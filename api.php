<?php
require_once 'koneksi2.php';

class API{
	function index(){
		$connection = new Connection(); 
		$conn 		= $connection->getConnection();

		$json 		= array();

		switch ($_POST['action']) {
		    case "create":
		        $this->CREATEAction($conn);
		        break;
		    case "readAll":
		        $this->READAllAction($conn);
		        break;
		    case "readById":
		        $this->READByIdAction($conn);
		        break;
		    case "update":
		        $this->UpdateByIdAction($conn);
		        break;
		    case "deleteById":
		        $this->DELETEByIdAction($conn);
		        break;
		    default:
		    	echo json_encode(array(
					"STATUS"    => 0,
		            "MESSAGE"   => "Invalid Action"
				));
		    	break;
		}
	}

	private function CREATEAction ($conn){
		$name			= $_POST['name'];
		$description	= $_POST['description'];
		$price			= $_POST['price'];
		$category_id	= $_POST['category_id'];
		
		$query 		= " INSERT INTO tesInsert (name, description, price, category_id) VALUES ('".$name."', '".$description."', '".$price."', '".$category_id."') ";
	
		$sql 		= $conn->prepare($query);
		$sql->execute();

		echo json_encode(array(
			"STATUS"    => 1,
            "MESSAGE"   => "Success"
		));
	}
	
	private function READAllAction ($conn){
		$json 		= array();

		$query 		= " SELECT * FROM tesInsert ";
		$sql 		= $conn->prepare($query);
		$sql->execute();
		$row		= $sql->fetchAll(PDO::FETCH_ASSOC);

		if (!empty($row)){
			foreach ($row AS $data) {
				array_push($json, array(
					"id"				=> $data['id'],
					"name"				=> $data['name'],
					"description"		=> $data['description'],
					"price"				=> $data['price'],
					"category_id"		=> $data['category_id'],
				));
			}
			echo json_encode(array(
				"READ"      => $json,
                "STATUS"    => 1,
                "MESSAGE"   => "Success"
			));
		} else {
			echo json_encode(array(
				"STATUS" 	=> 0,
				"MESSAGE"	=> "No Data"
			));
		}
	}

	private function READByIdAction ($conn){
		$json 		= array();

		$id			= $_POST['id'];
		$token		= $_POST['token'];

		$query 		= " SELECT * FROM tesInsert a,gen_token b WHERE a.id = '".$id."' and b.pin_token = '".$token."'";
		$sql 		= $conn->prepare($query);
		$sql->execute();
		$row		= $sql->fetchAll(PDO::FETCH_ASSOC);

		if (!empty($row)){
			foreach ($row AS $data) {
				array_push($json, array(
					"id"				=> $data['id'],
					"name"				=> $data['name'],
					"description"		=> $data['description'],
					"price"				=> $data['price'],
					"category_id"		=> $data['category_id'],
				));
			}
			echo json_encode(array(
				"READ"      => $json,
                "STATUS"    => 1,
                "MESSAGE"   => "Success"
			));
		} else {
			
			echo json_encode(array(
				"STATUS" 	=> 0,
				"MESSAGE"	=> "No Data"
			));
		}
	}

	private function UpdateByIdAction ($conn){
		$id				= $_POST['id'];
		$name			= $_POST['name'];
		$description	= $_POST['description'];
		$price			= $_POST['price'];
		$category_id	= $_POST['category_id'];

		$query 		= " UPDATE tesInsert SET name = '".$name."', description = '".$description."', price = '".$price."', category_id = '".$category_id."' WHERE id = '".$id."' ";
		$sql 		= $conn->prepare($query);
		$sql->execute();

		if (!empty($row)){
			foreach ($row AS $data) {
				array_push($json, array(
					"id"				=> $data['id'],
					"name"				=> $data['name'],
					"description"		=> $data['description'],
					"price"				=> $data['price'],
					"category_id"		=> $data['category_id'],
				));
			}
			echo json_encode(array(
				"READ"      => $json,
                "STATUS"    => 1,
                "MESSAGE"   => "Data Success to Update"
			));
		} else {
			
			echo json_encode(array(
				"STATUS" 	=> 0,
				"MESSAGE"	=> "No Data"
			));
		}
	}

	private function DELETEByIdAction ($conn){
		$id			= $_POST['id'];
	
		$query 		= " DELETE FROM tesInsert WHERE id = '".$id."' ";
		$sql 		= $conn->prepare($query);
		$sql->execute();

		if (!empty($row)){
			foreach ($row AS $data) {
				array_push($json, array(
					"id"				=> $data['id'],
					"name"				=> $data['name'],
					"description"		=> $data['description'],
					"price"				=> $data['price'],
					"category_id"		=> $data['category_id'],
				));
			}
			echo json_encode(array(
				"READ"      => $json,
                "STATUS"    => 1,
                "MESSAGE"   => "Data Success to Delete"
			));
		} else {
			
			echo json_encode(array(
				"STATUS" 	=> 0,
				"MESSAGE"	=> "No Data"
			));
		}
	}

}
$API = new API();
$API->index();
?>