<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	Yii::t('main','Users')=>array('index'),
	Yii::t('main','Manage'),
);

$this->menu=array(
	array('label'=>Yii::t('main','List User'), 'url'=>array('index')),
	array('label'=>Yii::t('main','Create User'), 'url'=>array('create')),
);

 
?>

<h1><?php echo Yii::t('main', 'Manage Users')?></h1>

 

 

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'login', 
		array('name'=>'is_admin', 'value'=>'$data->isAdminStr()'),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
