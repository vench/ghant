<?php
 

/**
 * Description of InstallController
 *
 * @author vench
 */
class InstallController extends Controller {
    
    public $layout = 'install';


    /**
     * 
     * @return array
     */
    public function accessRules() {
        return array( 
            array('allow',  
		'actions'=>array('index'),
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
        return TRUE;
    }

     /**
     * 
     */
    public function actionIndex() {
        $installForm = new InstallForm();  
        $this->render('index', array(
            '$installForm'=>$installForm,
        ));
    }
}
