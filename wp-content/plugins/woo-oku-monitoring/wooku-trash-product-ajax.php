<?php 

trash_product($_POST['id']);

echo json_encode(array(
	'id' => $_POST['id']
));

die();