<?php
/* @var $this ProjectController */
/* @var $model Project */

$this->breadcrumbs=array(
	Yii::t('main','Projects')=>array('index'),
	Yii::t('main','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('main','List Project'), 'url'=>array('index')),
	array('label'=>Yii::t('main','Manage Project'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('main', 'Create Project'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>