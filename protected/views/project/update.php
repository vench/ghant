<?php
/* @var $this ProjectController */
/* @var $model Project */

$this->breadcrumbs=array(
	Yii::t('main','Projects')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	 Yii::t('main','Update Project'),
);

$this->menu=array(
	array('label'=> Yii::t('main','List Project'), 'url'=>array('index')),
	array('label'=> Yii::t('main','Create Project'), 'url'=>array('create')),
	array('label'=> Yii::t('main','View Project'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=> Yii::t('main','Manage Project'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('main','Update Project');?>: <?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>