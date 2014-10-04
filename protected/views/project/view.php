<?php
/* @var $this ProjectController */
/* @var $model Project */

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
