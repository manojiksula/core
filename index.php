<?php  

require_once 'core/dsr.php';
$object = new Dsr();
$array = array(
			'dsr_name' => 'dkjhshjzbvhj',
			'dsr_date'=>date("Y-m-d")
		);
// echo $object->insert('dsr',$array);
$deleteRow = array('dsr_id'=>3);
echo "<pre>";
$selected = $object->select('dsr','*',$deleteRow);
// print_r($selected->fetch(PDO::FETCH_ASSOC));
print_r($selected->fetchAll(PDO::FETCH_ASSOC));
?>