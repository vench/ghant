<?php
/* @var $this ProjectController */
/* @var $model Project */

Yii::app()->clientScript->registerCoreScript('cookie');

$this->breadcrumbs=array(
	Yii::t('main','Projects')=>array('index'),
	$model->name,
); 

/*
$this->menu=array(
	array('label'=>Yii::t('main','List Project'), 'url'=>array('index')),
	array('label'=>Yii::t('main','Create Project'), 'url'=>array('create')),
	array('label'=>Yii::t('main','Update Project'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('main','Delete Project'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('main','Manage Project'), 'url'=>array('admin')),
);

 */
?>



<h1><?php echo Yii::t('main', 'View Project');?> #<?php echo $model->name; ?></h1>

<a href="#!" class="fullScreen"><?php echo Yii::t('main', 'Full screen');?></a>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(		 
		array('name'=>'user_id', 'value'=>CHtml::encode($model->user->name),),		 
		array('name'=>'description', ), 
                array('name'=>'',  'type'=>'raw', 
                    'value'=>CHtml::link(Yii::t('main', 'Update Project'), array('update', 'id'=>$model->id))
                        . ' ' .
                        CHtml::link(Yii::t('main', 'Delete Project'), array('delete', 'id'=>$model->id), array('onclick'=>'return confirm("'.Yii::t('main', '?').'")')),)
	),
)); ?>

<h3><?php echo Yii::t('main', 'Diagram');?></h3>
<?php 
$this->widget('application.widgets.GhantProject',array(
    'projectID'=> $model->getPrimaryKey(),
    'readonly'=> !ProjectHelper::accessEditProject($model->getPrimaryKey()),
));
?>

<script type="text/javascript">
$(function(){ console.log(1);
    function checkFullScreen() {        
        if($.cookie('fullscreen') == 1) {
            $('#page').addClass('fullscreen');
        } else {
            $('#page').removeClass('fullscreen');
        }
    }
    $('.fullScreen').click(function(){  
        $.cookie('fullscreen', $('#page').hasClass('fullscreen') ? 0 : 1);
        checkFullScreen();
        return false;
    });
    checkFullScreen();
});
</script>
