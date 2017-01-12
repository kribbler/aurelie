<h1>Products</h1>
<?php //echo $this->Html->link('Add', '/urls/add', array('class' => 'btn btn-success'))?>
<?php 
if ($elements){?>
	<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Image</th>
			<th>Product code</th>
			<th>Description</th>
			<th>Material</th>
			<th>Finishing</th>
			<th>Silver weight</th>
			<th>Approx. weight</th>
			<th>Type</th>
			<th>Size</th>
			<th>Price</th>
			<!--<th>Actions</th>-->
		</tr>
	</thead>
	<tbody>
	<?php foreach ($elements as $element){?>
		<tr>
			<td><?php echo $element['Product']['id']?></td>
			<td><?php echo $this->Html->image($element['Product']['image'], array('width' => 50));?></td>
			<td><?php echo $this->Html->link(
				$element['Product']['product_code'], $element['Url']['content'], 
				array('target' => '_blank')
			);?></td>
			<td><?php echo $element['Product']['description'];?></td>
			<td><?php echo $element['Product']['material'];?></td>
			<td><?php echo $element['Product']['finishing'];?></td>
			<td><?php echo $element['Product']['silver_weight'];?></td>
			<td><?php echo $element['Product']['approx_weight'];?></td>
			<td><?php echo $element['Product']['type'];?></td>
			<td><?php echo $element['Product']['size'];?></td>
			<td><?php echo $element['Product']['price'];?></td>

			<!--
			<td><?php echo $this->Html->link($this->Html->image('/img/edit.png'), '/products/edit/' . $element['Product']['id'], array('escape' => false));?>
			<?php echo $this->Html->link($this->Html->image('/img/delete.png'), '/products/delete/' . $element['Product']['id'], array('escape' => false));?>
			</td>
			-->	
		</tr>
	<?php }?>
	</tbody>
	</table>
<?php 
}
?>