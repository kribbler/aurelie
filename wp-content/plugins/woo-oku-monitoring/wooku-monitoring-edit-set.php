<?php
if ($_POST){
	$set_name = $_POST['set_name'];
	$set_id = $_POST['set_id'];
	$set_values = array();
	
	foreach ($_POST as $key=>$value){
		if (strpos($key, "set_value") === 0){
			if ($value){
				$set_values[] = $value;
			}
		}
	}
	
	edit_set($set_name, $set_values, $set_id);
	
	header('Location: ' . get_admin_url().'tools.php?page=wooku-monitoring');
}

if (!$_GET['page'] == 'wooku-monitoring' || !$_GET['action'] == 'edit-set' || !$_GET['id']){
	header('Location: ' . get_admin_url().'tools.php?page=wooku-monitoring');
} 
?>
<div id="icon-tools" class="icon32"><br /></div>
<h2><?php _e( 'WoOKU Product Monitoring - edit set', 'wooku-monitoring' ); ?></h2>

<?php include ('wooku-monitoring-menu.php');?>
<div class="clear"></div>

<?php
$set = get_monitoring_set_by_id($_GET['id']);
?>

<form enctype="multipart/form-data" method="post" action="<?php echo get_admin_url().'tools.php?page=wooku-monitoring&action=edit-set'; ?>">
<input type="hidden" name="set_id" value="<?php echo $set->id?>" />
<table class="form-table1">
	<tr>
		<th><label for="metaset_name">Set Name</label></th>
		<td>
			<input type="text" name="set_name" value="<?php echo $set->name?>" />
		</td>
	</tr>
	<tr>
		<th><label for="set_value1">Set Value 1</label></th>
		<td>
			<input type="text" name="set_value1" value="<?php echo $set->Values[0]->value?>" />
		</td>
	</tr>
	<tr>
		<th><label for="set_value2">Set Value 2</label></th>
		<td>
			<input type="text" name="set_value2" value="<?php echo $set->Values[1]->value?>" />
		</td>
	</tr>
	<tr>
		<th><label for="set_value3">Set Value 3</label></th>
		<td>
			<input type="text" name="set_value3" value="<?php echo $set->Values[2]->value?>" />
		</td>
	</tr>
	<tr>
		<th></th>
		<td>
			<button class="button-primary" type="submit"><?php _e( 'Save', 'wooku-monitoring' ); ?></button>
		</td>
	</tr>
</table>
</form>