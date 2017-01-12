<?php 
if ($_POST){
	$set_name = $_POST['set_name'];
	$set_values = array();
	
	foreach ($_POST as $key=>$value){
		if (strpos($key, "set_value") === 0){
			if ($value){
				$set_values[] = $value;
			}
		}
	}
	
	create_new_set($set_name, $set_values);
	
	header('Location: ' . get_admin_url().'tools.php?page=wooku-monitoring');
}
?>

<div id="icon-tools" class="icon32"><br /></div>
<h2><?php _e( 'WoOKU Product Monitoring', 'wooku-monitoring' ); ?></h2>
<h3>Create new set</h3>

<?php include ('wooku-monitoring-menu.php');?>

<form enctype="multipart/form-data" method="post" action="<?php echo get_admin_url().'tools.php?page=wooku-monitoring&action=create_new_set'; ?>">
<table class="form-table1">
	<tr>
		<th><label for="metaset_name">Set Name</label></th>
		<td>
			<input type="text" name="set_name" />
		</td>
	</tr>
	<tr>
		<th><label for="set_value1">Set Value 1</label></th>
		<td>
			<input type="text" name="set_value1" />
		</td>
	</tr>
	<tr>
		<th><label for="set_value2">Set Value 2</label></th>
		<td>
			<input type="text" name="set_value2" />
		</td>
	</tr>
	<tr>
		<th><label for="set_value3">Set Value 3</label></th>
		<td>
			<input type="text" name="set_value3" />
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