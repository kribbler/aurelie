<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		echo $this->Html->css('styles');
		echo $this->Html->css('pro_dropdown_2');
		echo $this->Html->script('stuHover');
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		
	?>
	<link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css'>
</head>
<body>
	<div id="container">
		<div id="content">
			<?php echo $this->Html->link($this->Html->image('/img/logo.png'), '/', array('id' => 'logo', 'escape' => false))?>
			<ul id="nav">
				<li class="top">
					<?php echo $this->Html->link('<span class="down">Home</span>', '/', array('class' => 'top_link', 'escape' => false))?>
					<ul class="sub">
						<li><?php echo $this->Html->link('Clear all scraped data', '/scrappers/delete_all')?></li>
					</ul>
				</li>
				<li class="top"><?php echo $this->Html->link('<span class="down">Safira Products</span>', '/products', array('class' => 'top_link', 'escape' => false))?>
					<ul class="sub">
						<li><?php echo $this->Html->link('View products', '/products', array('class' => 'no_fly'))?></li>
						<li><?php echo $this->Html->link('Scrap Images', '/scrappers/scrap_images');?>
						<li><?php echo $this->Html->link('Scrap images', 'javascript:void(0);', array('id' => 'scrap_new_images'))?>
						<li><?php echo $this->Html->link('Scrap\'em all!', '/scrappers/mega_scrap');?></li>
						<li><?php echo $this->Html->link('Export to csv', '/scrappers/export_brute_csv');?></li>
					</ul>
				</li>
			</ul>
			<?php echo $this->Session->flash(); ?>
			<div id="processing" class="message" style="display:none"></div>
			<div id="main"><?php echo $this->fetch('content'); ?></div>
		</div>
	</div>	
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#scrap_new_images').click(function(){
		$.ajax({
			type:	"POST",
			url:	"<?php echo "http://" . $_SERVER['HTTP_HOST']  . $this->base . "/scrappers/ajax_scrap_new_images/";?>",
			success: function(data){
				if (data != 'done'){
					$('#processing').html('Processing another add. Adds left: '+data+'<br />');
					$('#processing').fadeIn('fast');
					$('#scrap_new_images').trigger('click');
				} else {
					$('#processing').html('All images are scraped');
					$('#processing').fadeIn('fast');
					return false;
				}
			}, 
			error: function(data){
				window.location.reload();
			}
		}); 
		return false;
	});

	$('.scrap_new_images').click(function(){
		bjorklund_action_id = $(this).attr('id');
		$('#scrap_bjorklund_new_images').trigger('click');
	});
});
</script>
</body> 
<?php echo $this->element('sql_dump'); ?>	
</html>
