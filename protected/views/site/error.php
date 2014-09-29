<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - '.Yii::t('main', 'Error');
$this->breadcrumbs=array(
	Yii::t('main','Error'),
);
?>

<h2><?php echo Yii::t('main','Error');?> <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>