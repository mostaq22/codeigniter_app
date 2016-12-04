<?php 
                    	//print pagination
echo $render['pagination'];
//array elements of head and row data with key,value pair
$head_elements = array(
	'controller_name'	=>	'Controller Name',
	'description'		=>	'Description',
	'active'			=>	'Status'
	);
//set table heading
$this->table->set_heading($head_elements);
//iteration of data
foreach($render['result'] as $result):
	foreach ($head_elements as $key => $value):
		$row_value_array[$key] = $result->$key;
	endforeach;
	$this->table->add_row($row_value_array);
endforeach;
$this->table->set_template(['table_open' => '<table class="table table-bordered">']);

//generate table
echo $this->table->generate();
?>