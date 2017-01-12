<div class="page-header">
    <h1>Edit url</h1>
</div>
<?php echo $this->Form->create('Url', array('class' => 'form-horizontal','type' => 'file')); ?>
<div class="control-group">
    <div class="controls">
        <?php echo $this->Form->input('Url.content', array('div' => false, 'label' => false)); ?>
        <?php echo $this->Form->input('Url.id')?>
    </div>
</div>


<?php echo $this->Form->submit("Save", array('class' => 'btn btn-success')); ?>