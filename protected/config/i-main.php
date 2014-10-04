<?php
    return array(
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Мой проект',
        'language'=>'ru', 
	'preload'=>array('log'),
        'import'=>array(
		'application.models.*',
		'application.components.*',
	),
        'components'=>array(
		'user'=>array( 
			'allowAutoLogin'=>true,
		),
                'db'=>     array(
        'connectionString'=>'mysql:host=localhost;dbname=test',
        'emulatePrepare' => true,
	'username' => 'root',
	'password' => '',
	'charset' => 'utf8',
    )            ,
                'errorHandler'=>array( 
			'errorAction'=>'site/error',
		),
        ),
        'params'=>array( 
		'adminEmail'=>'admin@mail.ru',
	),
   );
                