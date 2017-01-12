<h1>Urls</h1>
<?php echo $this->Html->link('Add', '/urls/add', array('class' => 'btn btn-success'))?>
<?php 
if ($elements){?>
	<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Url</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($elements as $element){?>
		<tr>
			<td><?php echo $element['Url']['id']?></td>
			<td><?php echo $element['Url']['content'];?></td>
			<td><?php echo $this->Html->link($this->Html->image('/img/edit.png'), '/urls/edit/' . $element['Url']['id'], array('escape' => false));?>
			<?php echo $this->Html->link($this->Html->image('/img/delete.png'), '/urls/delete/' . $element['Url']['id'], array('escape' => false));?>
			</td>
		</tr>
	<?php }?>
	</tbody>
	</table>
<?php 
}
?>