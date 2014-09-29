<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('main','Users'),
);

$this->menu=array(
	array('label'=>Yii::t('main','Create User'), 'url'=>array('create')),
	array('label'=>Yii::t('main','Manage User'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('main', 'Users');?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
