<?php


 class Employee extends Db {

 	public function select()
 	{
 		$sql = "SELECT * FROM employess";

 		$result = $this->connect()->query($sql);

 		if($result->rowCount() > 0)
 		{
 			while ($row = $result->fetch()){

 				$data[] = $row;
 			}
 			return $data;
 		}
 	}

 	public function insert($fields){
 		$implodeColumns = implode(', ',array_keys($fields));

 		$implodePlaceholder = implode(", :",array_keys($fields));

 		$sql = "INSERT INTO employess ($implodeColumns) VALUES (:".$implodePlaceholder.")";

 		$stmt = $this->connect()->prepare($sql);

 		foreach ($fields as $field => $value){
 			$stmt->bindValue(':'.$field,$value);
 		}

 		$stmtExec = $stmt->execute();

 		if ($stmtExec){
 			header('Location: index.php');
 		} else {
 			echo('<h1 style="color:red"> error ! </h1>');
 		}
 	}

 	public function edit ($id)
 	{
 		$sql = "SELECT * FROM employess WHERE id=:id";
 		$stmt = $this->connect()->prepare($sql);
 		$stmt->bindValue(":id",$id);
 		$stmt->execute();
 		$result = $stmt->fetch(PDO::FETCH_ASSOC);
 		return $result;
 	}

   public function update($fields, $id){

   		$st = "";
   		$counter = 1;
   		$total_fields =  count($fields);
   		foreach($fields as $key => $value){
   			if($counter == $total_fields){
   				$set = "$key = :".$key;
   				$st = $st.$set;
   			}else{
   				$set = "$key = :".$key.", ";
   				$st = $st.$set;
   				$counter++;
   			}
   		}

   		$sql = " ";
   		$sql.= "UPDATE employess SET ".$st;
   		$sql.=" WHERE id =".$id;
   		
   	$stmt = $this->connect()->prepare($sql);

   	foreach ($fields as $key => $value){
   		$stmt->bindValue(':'.$key, $value);
   	}
    $stmtExec = $stmt->execute();

   	 if($stmtExec){
   	 	header('Location: index.php');
   	 }

   } 

   public function destroye($id){
   	$sql = "DELETE FROM employess WHERE id = :id";
   	$stmt = $this->connect()->prepare($sql);
   	$stmt->bindValue(":id", $id);
   	$stmt->execute();
   }

 }


