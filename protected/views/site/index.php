<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1><?php echo Yii::t('main', 'Welcome to');?> <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
 
 

<?php   
$this->widget('ext.EFullCalendar.EFullCalendar', array(    
    'themeCssFile'=>'cupertino/theme.css',
    'lang'=>'ru',	  
    'htmlOptions'=>array( 
        'style'=>'width:100%'
    ),  
    'options'=>array(
	'firstDay'=>1,
        'header'=>array(
            'left'=>'prev,next',
            'center'=>'title',
            'right'=>'today'
        ),
        'lazyFetching'=>true,
	'ignoreTimezone'=>false,
        'events'=> $this->createUrl('/project/ajaxList'),   
    )
));