<?php
class table {

 protected $table = "";
 
 public function insert($data) 
 {
  global $conn;


  foreach ($data as $key=>$value)
  {
   $field[] = $key;
  }

  $fields = implode(",", $field);
  $values = implode("','", $data);


                //  $get_key_val = get_arr_key_value($data);
  //extract $get_key_val;
  $statement = "INSERT INTO $this->table ($fields) VALUES ('$values')";

  $conn->exec($statement) or die(print_r($conn->errorInfo()));
 
  return $conn->lastInsertId();

 }

 public function select_all() {
  global $conn;

  $statement = 'SELECT * FROM ' . $this->table ;
  $q = $conn->query($statement);
  $results = $q->fetchAll(PDO::FETCH_ASSOC);
  $results = json_encode($results);
  echo $results;
 }

 public function select_where($wh) {
  global $conn;
  $statement = 'SELECT * FROM ' . $this->table . ' WHERE '. $wh;
  $q = $conn->query($statement);
  $results = $q->fetchAll(PDO::FETCH_ASSOC);
  $results = json_encode($results);
  return $results;
 }

 public function select_fields_order_by($fields,$orderby) {
  global $conn;
    //  echo $fields." ".$orderby;

  $statement = "SELECT $fields FROM {$this->table} ORDER BY $orderby" ;

  $q = $conn->query($statement);

  $results = $q->fetchAll(PDO::FETCH_ASSOC);

  return $results;

 }

 /**
  * @desc Selects the records from the table based on the given condition
  * @param array $fields - the columns to be selected
  * @param array $conditions set of conditions
  * @return Returns an array when there are results and 0 when none.
  */
 public function select_fields_where($fields,$conditions) {
             global $conn;

  //construct the conditions
  foreach ($conditions as $k=>$v) {
   $wh[] = $k . " = '" . $v . "'";
  }
  $where = implode(" AND ", $wh);
              
  $statement = 'SELECT '.implode(',',$fields).' FROM ' . $this->table . ' WHERE ' . $where ;
         //       var_dump($statement);die();
  try {

   if (!$q = $conn->query($statement)) {
     
    throw new PDOException(serialize($conn->errorInfo()));
     
   }
   $results = $q->fetchAll(PDO::FETCH_ASSOC);

   if (!empty($results)) {
    return $results;
   }else{
    return 0;
   }
  }catch (PDOException $e){

   echo get_class($this)."->".__FUNCTION__." : ERROR = ".$e->getMessage();
  }
   
 }
 
 
 public function update($data,$conditions) {
    global $conn;

  if ($conditions) {
   //constructs the conditions
   foreach ($conditions as $k=>$v) {
    $wh[] = $k . " = '" . $v . "'";
   }
   $where = implode(" AND ", $wh);

   //constructs the data
   foreach ($data as $k=>$v){
    $update[] = $k . " = '" . $v . "'";
   }

   $updates = implode(", ", $update);

   $statement = "UPDATE {$this->table} SET $updates WHERE $where" ;
	
  }else{
   $statement = "UPDATE {$this->table} SET $updates" ;
  }
  if ($conn->exec($statement)) {
   return true;
  }else{
   return false;
  }

 }
 
 public function select_all_where($conditions) {
   global $conn;

  //construct the conditions
  foreach ($conditions as $k=>$v) {
   $wh[] = $k . " = '" . $v . "'";
  }
  $where = implode(" AND ", $wh);
              
  $statement = 'SELECT * FROM ' . $this->table . ' WHERE ' . $where ;
                //var_dump($statement);die();
  try {

   if (!$q = $conn->query($statement)) {
     
    throw new PDOException(serialize($conn->errorInfo()));
     
   }
   $results = $q->fetchAll(PDO::FETCH_ASSOC);

   if (!empty($results)) {
    return $results;
   }else{
    return 0;
   }
  }catch (PDOException $e){

   echo get_class($this)."->".__FUNCTION__." : ERROR = ".$e->getMessage();
  }
   
 }
 
 	/**
	 * @desc Checks the existence of a record based on a given array
	 * @param array $data set of data to be checked
	 * @return Returns true when the record exists and false when it does not.
	 */
	public function check_existence($data)	{

		$result = $this->select_where($data);
		$count = ($result == "[]" ) ? 0 : count($result);
		
		//echo var_dump($count);
        //echo sizeof($count);die();
		if ($count == 0 ) {

			return false;
				
		}else{
				
			return true;
				
		}

	}
	
	/**
	  *  SELECT COUNT -JX
	  *
	**/

	public function select_count() {
		global $conn;

		$statement = 'SELECT COUNT(*) as count_result FROM ' . $this->table ;
		$q = $conn->query($statement);
		$results = $q->fetchAll(PDO::FETCH_ASSOC);

		return $results[0]['count_result'];

	}
	
	/**
	  *  SELECT COUNT where-JX
	  *
	**/

	public function select_count_where($wh) {
		global $conn;

		$statement = 'SELECT COUNT(*) as count_result FROM ' . $this->table.' where '.$wh ;
		$q = $conn->query($statement);
		$results = $q->fetchAll(PDO::FETCH_ASSOC);
		return $results[0]['count_result'];
	}
	/*
	 Function:select_join_where()
	 Desc: capable of joining two tables 
	 params: {$arr: [name_of_table] => array(
								      ['fields']=>(field1,field2,field3),
									  ['condition']=> array([field_name_1] => 'fullname',[field_name_2] => 'sample'  ),
									  [FIELD_OF_INTERSECTION ] => 'user_id',
					[name_of_table_2] => etc....	,			  
			  $join_type : 'LEFT JOIN',	
			  )
	 

	
	
	*/
	public function select_join_where($arr,$join_type) {
	
 
	}
 

   
}

 ?>