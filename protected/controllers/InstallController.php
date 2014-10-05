<?php
 

/**
 * Description of InstallController
 *
 * @author vench
 */
class InstallController extends Controller {
    
    public $layout = 'install';


    /**
    * @return array action filters
    */
    public function filters()
    {
        return array(
		'accessControl', // perform access control for CRUD operations 
	);
    }
    
    /**
     * 
     * @return array
     */
    public function accessRules() {
        return array( 
            array('allow',
                'actions'=>array('success'),
                'users'=>array('*'),
            ),
            array('allow',  
		'actions'=>array('index',),
		'expression' => array('InstallController','allowInstall'),
            ),
            array('deny',  // deny all users
		'users'=>array('*'),
            ),
        );
    }
    
    /**
     * 
     * @return boolean
     */
    public function allowInstall() {
        $patch = Yii::getPathOfAlias('application.config').DIRECTORY_SEPARATOR.'i-main.php';       
        return !file_exists($patch);
    }
    
    /**
     * 
     */
    public function actionSuccess() {
        $this->render('success');
    }

    /**
     * 
     */
    public function actionIndex() {
        $installForm = new InstallForm();  
        if(isset($_POST['InstallForm'])) {
            $installForm->attributes = $_POST['InstallForm'];
            if($installForm->validate()) {
                $this->createDB($installForm);
                $this->createCOnfig($installForm);
                $this->redirect(array('success'));
            }
        }
        $this->render('index', array(
            'installForm'=>$installForm,
        ));
    }
    
    protected function createCOnfig(InstallForm $installForm) {
        $patch = Yii::getPathOfAlias('application.config').DIRECTORY_SEPARATOR.'i-main.php';
        $string = <<<START
<?php
    return array(
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'{$installForm->siteName}',
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
                'db'=> {$installForm->getConnectionStringConfig()},
                'errorHandler'=>array( 
			'errorAction'=>'site/error',
		),
        ),
        'params'=>array( 
		'adminEmail'=>'{$installForm->email}',
	),
   );
                
START;
        file_put_contents($patch, $string);        
    }
    
    /**
     * 
     * @param InstallForm $installForm
     */
    protected function createDB(InstallForm $installForm) {
        ob_start();
        $patch = Yii::getPathOfAlias('application.migrations');
        $names = scandir($patch);
        $db = $installForm->getCDbConnection();
        foreach($names as $name) {
            $exp = explode('.', $name);
            if(sizeof($exp) === 2) {
                list($className, $expr) = $exp;   
                if($expr === 'php') {
                    include_once $patch.DIRECTORY_SEPARATOR.$name;
                    if(class_exists($className)) {  
                       $migration = new $className() ;
                       $migration->setDbConnection($db);
                       $migration->up();
                    }
                }
            }
        }
        ob_clean();         
    }
}
