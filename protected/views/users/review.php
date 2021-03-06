<?php
/*
 * provides the set of files which are check out by the user and option to checkin
 */	
?>

<?php 

	Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#asset-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php //Grid view that displays the summary text like : Documents checked out by you?>

<script type="text/javascript">
    function updateFileDetailsReview(grid_id) {
 
        var keyId = $.fn.yiiGridView.getSelection(grid_id);
        keyId  = keyId[0]; //above function returns an array with single item, so get the value of the first item
 
        $.ajax({
            url: '<?php echo $this->createUrl('UpdateReviewDocs'); ?>',
            data: {id: keyId},
            type: 'GET',
            success: function(data) {
                $('#file_details_review').html(data);
            }
        });
    }
</script>






<?php

	//display the files in which the user has checkouted 
	//at present only the owner has rights to checkout

	$criteria  = new CDbCriteria;
	$criteria->condition = ('ownerId=$model->uid');

	$this->widget('zii.widgets.grid.CGridView',array(
	'id'=>'asset-grid',
	'dataProvider'=>$model1->search2(),
	'filter'=>$model1,
	'selectionChanged'=>'updateFileDetailsReview',
	'columns'=>array(
		'assetId',
		'assetName',
		'description',
		array('name'=>'createDate','header'=>'Date Created'),
		'size',	
		array('name'=>'owner_name','value'=>'$data->users->name'),
		'type',
		
		
	),
)); ?>

 
<div id="file_details_review">
 //the code here
</div>
