<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	Yii::t('main','Users')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('main','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('main','List User'), 'url'=>array('index')),
	array('label'=>Yii::t('main','Create User'), 'url'=>array('create')),
	array('label'=>Yii::t('main','View User'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('main','Manage User'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('main', 'Update User');?>: <?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

<h3><?php echo Yii::t('main', 'Change password'); ?></h3>
<?php if(Yii::app()->user->hasFlash('passwordChange')) {?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('passwordChange'); ?>
</div>

<?php } ?>
<?php $this->renderPartial('_form_pass', array('model'=>$modelPassword)); ?>