<?php
if ($_GET['page'] == 'wooku-monitoring' && $_GET['action'] == 'delete-set' && $_GET['id']){
	delete_set($_GET['id']);
	
	header('Location: ' . get_admin_url().'tools.php?page=wooku-monitoring');
}