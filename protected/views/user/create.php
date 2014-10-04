<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	Yii::t('main','Users')=>array('index'),
	Yii::t('main','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('main','List User'), 'url'=>array('index')),
	array('label'=>Yii::t('main','Manage User'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('main', 'Create User')?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>