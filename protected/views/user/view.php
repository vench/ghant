<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	Yii::t('main','Users')=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('main','List User'), 'url'=>array('index')),
	array('label'=>Yii::t('main','Create User'), 'url'=>array('create')),
	array('label'=>Yii::t('main','Update User'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('main','Delete User'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('main','Manage User'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('main', 'View User');?> #<?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'login', 
		array('name'=>'is_admin', 'value'=>$model->isAdminStr()),
	),
)); ?>
