<?php
    return array(
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Ghant Project',
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
        'connectionString'=>'sqlite:/var/www/html/ghant/protected/data/test.db',
    )          ,
                'errorHandler'=>array( 
			'errorAction'=>'site/error',
		),
        ),
        'params'=>array( 
		'adminEmail'=>'admin@mail.ru',
	),
   );
                