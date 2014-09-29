<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - '.Yii::t('main', 'About');
$this->breadcrumbs=array(
	Yii::t('main', 'About'),
);
?>
<h1><?php echo Yii::t('main', 'About'); ?></h1>

<p><?php echo Yii::t('main', 'This application makes it easy to handle projects which involved a team of people.');?></p>
<p><?php echo Yii::t('main', 'You can easily ask those responsible for the task. Control at run time.'); ?></p>
<p><?php echo Yii::t('main', 'On the site {site} you can always download the latest Firmware and get potderzhku.', array(
        '{site}'=>  CHtml::link('vench-master.spb.ru', 'http://vench-master.spb.ru/'),
));?></p>