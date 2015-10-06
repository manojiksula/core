<?php
//http://www.tipocode.com/database/mysql-php-oop-database-connection/
//http://stackoverflow.com/questions/8474876/connect-to-mysql-database-using-php-oop-concept
class Connection
{	
	protected $host = "localhost";
    protected $dbname = "reporting";
    protected $user = "root";
    protected $pass = "root";
    protected $conn;

    function __construct() {

        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function closeConnection() {

        $this->conn = null;
    }

    /* 
		insert function table name, array value
        $values = array('first_name' => 'pramod','last_name'=> 'jain');
    */

        public function insert($table,$values)
        {
        	$sql = "INSERT INTO $table SET ";
        	$c=0;
        	if(!empty($values)){
        		foreach($values as $key=>$val){
        			print_r($values);
        			if($c==0){
        				$sql .= "$key='".htmlentities($val, ENT_QUOTES)."'";
        			}else{
        				$sql .= ", $key='".htmlentities($val, ENT_QUOTES)."'";
        			}
        			$c++;
        		}
        	}else{
        		return false;
        	}
        	$this->conn->exec($sql) or die(PDO::errorInfo());
		return $this->conn->lastInsertId();//mysqli_insert_id($this->conn);
	}

	/* update function table name, array value
        $values = array('first_name' => 'pramod','last_name'=> 'jain');
        $condition = array('id' =>5,'first_name' => 'pramod!');
     */        
        public function update($table,$values,$condition)
        {
        	$sql="update $table SET ";
        	$c=0;
        	if(!empty($values)){
        		foreach($values as $key=>$val){
        			if($c==0){
        				$sql .= "$key='".htmlentities($val, ENT_QUOTES)."'";
        			}else{
        				$sql .= ", $key='".htmlentities($val, ENT_QUOTES)."'";
        			}
        			$c++;
        		}
        	}
        	$k=0;    
        	if(!empty($condition)){
        		foreach($condition as $key=>$val){
        			if($k==0){
        				$sql .= " WHERE $key='".htmlentities($val, ENT_QUOTES)."'";
        			}else{
        				$sql .= " AND $key='".htmlentities($val, ENT_QUOTES)."'";
        			}
        			$k++;
        		}
        	}else{
        		return false;
        	}
        	$result = $this->conn->exec($sql) or die(mysqli_error());
        	return $result;
        }

     /* delete function table name, array value
        $where = array('id' =>5,'first_name' => 'pramod');
     */    
        public function delete($table,$where)
        {
        	$sql = "DELETE FROM $table ";
        	$k=0;    
        	if(!empty($where)){
        		foreach($where as $key=>$val){
        			if($k==0){
        				$sql .= " where $key='".htmlentities($val, ENT_QUOTES)."'";
        			}else{
        				$sql .= " AND $key='".htmlentities($val, ENT_QUOTES)."'";
        			}
        			$k++;
        		}
        	}else{
        		return false;
        	}
        	$del = $result = $this->conn->query($sql) or die(mysqli_error());
        	if($del){
        		return true;
        	}else{
        		return false;
        	}
        }


    /* select function
       $rows = array('id','first_name','last_name');
       $where = array('id' =>5,'first_name' => 'pramod!');
       $order = array('id' => 'DESC');
       $limit = array(20,10);
    */
       public function select($table, $rows = '*', $where = null, $order = null, $limit = null)
       {
       	if($rows != '*'){
       		$rows = implode(",",$rows);
       	}

       	$sql = 'SELECT '.$rows.' FROM '.$table;
       	if($where != null){
       		$k=0;
       		foreach($where as $key=>$val){
       			if($k==0){
       				$sql .= " where $key='".htmlentities($val, ENT_QUOTES)."'";
       			}else{
       				$sql .= " AND $key='".htmlentities($val, ENT_QUOTES)."'";
       			}
       			$k++;
       		}    
       	}

       	if($order != null){
       		foreach($order as $key=>$val){
       			$sql .= " ORDER BY $key ".htmlentities($val, ENT_QUOTES)."";
       		}    
       	}    

       	if($limit != null){
       		$limit = implode(",",$limit);
       		$sql .= " LIMIT $limit";

       	}
       	
       	$result = $this->conn->query($sql);
       	return $result;

       }  

       public function query($sql){
       	$result = $this->conn->query($sql);
       	return $result;
       }

       public function result($result){
       	$row = $result->fetch_array();
       	$result->close();
       	return $row;
       }

       public function row($result){
       	$row = $result->fetch_row();
       	$result->close();
       	return $row;
       }

       public function numrow($result){
       	$row = $result->num_rows;
       	$result->close();
       	return $row;
       }
       public function fetchAll($result){
       	$row = $result->fetchAll();
       	// $result->close();
       	return $row;
       }
}

?>