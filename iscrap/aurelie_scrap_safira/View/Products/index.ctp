<h1>Scrapped products (<?php echo count($elements)?>)</h1>
<?php if ($elements){?>
<div class="CSS_Table_Example">
	<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<th>Title</th>
			<th>Image</th>
			<th>Variation</th>
		</tr>	
		<?php foreach ($elements as $element):?>
		<tr>
			<td>
				<?php echo $this->Html->link($element['Product']['title'], $element['Product']['url']);?><br />
				<?php echo $element['Product']['description'];?>
			</td>
			<td>
				<?php echo $this->Html->image($element['Product']['image_url'], array('width' => '100px'));?>
			</td>
			<td><?php echo $element['Product']['is_variation'];?></td>
		</tr>
		<?php endforeach;?>
	</table>
</div>
<?php }?>