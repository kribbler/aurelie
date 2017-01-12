<hr />
<a href="<?php echo get_admin_url().'tools.php?page=wooku-monitoring'?>">Home</a> | <a href="<?php echo get_admin_url().'tools.php?page=wooku-monitoring&action=create_new_set'?>">Create a new set</a>
<?php if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1'){?>
 | <a href="<?php echo get_admin_url().'tools.php?page=wooku-monitoring&action=delete_all_products'?>">Delete all products</a>
<?php }?>
<br />
<hr />
<br />