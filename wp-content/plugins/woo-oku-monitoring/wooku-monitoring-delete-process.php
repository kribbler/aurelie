<?php 
if ($_GET['page'] == 'wooku-monitoring' && $_GET['action'] == 'delete-process' && $_GET['id']){
	delete_process($_GET['id']);
	
	header('Location: ' . get_admin_url().'tools.php?page=wooku-monitoring');
}