<?php 
if (save_paused_process($_POST)){
	echo 'saved';
} else {
	echo 'not saved';
}
	
die();