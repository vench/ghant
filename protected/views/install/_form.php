<?php
/* @var $this InstallFormController */
/* @var $model InstallForm */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'install-form-_form-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('main', 'Fields with {sim} are required.', array('{sim}'=>'<span class="required">*</span>'));?></p>

	<?php echo $form->errorSummary($model); ?>

        <fieldset>
            <legend><?php echo Yii::t('install', 'Site oprions'); ?></legend>
            	<div class="row">
		<?php echo $form->labelEx($model,'siteName'); ?>
		<?php echo $form->textField($model,'siteName'); ?>
		<?php echo $form->error($model,'siteName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
        </fieldset>
        
        
        <fieldset>
            <legend><?php echo Yii::t('install', 'Data Base oprions'); ?></legend>
          
	<div class="row">
		<?php echo $form->labelEx($model,'dbType'); ?>
		<?php echo $form->dropDownList($model,'dbType', $model->getDBTypes()); ?>
		<?php echo $form->error($model,'dbType'); ?>
	</div>
           
            <div class="row">
		<?php echo $form->labelEx($model,'dbName'); ?>
		<?php echo $form->textField($model,'dbName'); ?>
		<?php echo $form->error($model,'dbName'); ?>
	</div>
            
            <div class="row">
		<?php echo $form->labelEx($model,'dbUserName'); ?>
		<?php echo $form->textField($model,'dbUserName'); ?>
		<?php echo $form->error($model,'dbUserName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dbPassword'); ?>
		<?php echo $form->textField($model,'dbPassword'); ?>
		<?php echo $form->error($model,'dbPassword'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dbHost'); ?>
		<?php echo $form->textField($model,'dbHost'); ?>
		<?php echo $form->error($model,'dbHost'); ?>
	</div>
            
        </fieldset>      

	



	


	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('install', 'Submit')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->