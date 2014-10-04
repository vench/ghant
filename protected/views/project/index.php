<?php
/* @var $this ProjectController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('main','Projects'),
);

$this->menu=array(
	array('label'=>Yii::t('main','Create Project'), 'url'=>array('create')),
	array('label'=>Yii::t('main','Manage Project'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('main', 'Projects');?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
