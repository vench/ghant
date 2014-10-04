<?php

 

/**
 * Description of InstallForm
 *
 * @author vench
 */
class InstallForm extends  CFormModel {
    public $dbType = 'mysql';
    public $dbName;
    public $dbUserName = 'root';
    public $dbPassword;
    public $dbHost = 'localhost';
    public $siteName = 'Ghant Project';
    public $email;
    
    /**
     * 
     * @return array
     */
    public function rules() {
        if($this->dbType === 'mysql') {
           return array(
               array('dbType, dbName,siteName,email,dbUserName,dbHost', 'required'), 
               array('email', 'email'),
               array('dbPassword', 'safe'),
               array('dbType', 'testDbConnection'),
            ); 
        }
        return array(
            array('dbType, dbName,siteName,email', 'required'),           
            array('dbUserName,dbPassword,dbHost', 'safe'),
            array('email', 'email'),
            array('dbType', 'testDbConnection'),
        );
    }
    
    /**
     * 
     */
    public function testDbConnection() {
        $db = $this->getCDbConnection();
        
        try {
            if(!$db->createCommand('select 1')->query()) { 
                $this->addError('dbType', Yii::t('install', 'Error connection to data base'));
            }
        } catch (Exception $e){
            if($e->getCode() === 1049){
                 $this->addError('dbType', Yii::t('install', 'Error connection to data base'));
            } else {
                $this->addError('dbType', $e->getCode() . $e->getMessage());
            }            
        }
    }
    
   /**
    * 
    * @return \CDbConnection
    */
    public function getCDbConnection() {
       $dns = $this->getDNS(); 
       if($this->dbType == 'sqlite') {
           return new CDbConnection($dns);
       }
       return new CDbConnection($dns, $this->dbUserName, $this->dbPassword); 
    }

        /**
     * 
     * @return null|string
     */
    public function getDNS() {
        if($this->dbType == 'mysql') {
            return  'mysql:host='.$this->dbHost.';dbname='.$this->dbName.'';
        }
        if($this->dbType == 'sqlite') {
            $dataPatch = Yii::getPathOfAlias('application.data');
            return 'sqlite:'.$dataPatch.'/'.$this->dbName.'.db';
        }
        return null;  
    }

    /**
     * 
     * @return string
     */
    public function getConnectionStringConfig() {
       $dns = $this->getDNS();  
       if($this->dbType === 'sqlite') {
            return <<<STARTIO
    array(
        'connectionString'=>'{$dns}',
    )          
STARTIO;
       }
       
        return <<<STARTIO
    array(
        'connectionString'=>'{$dns}',
        'emulatePrepare' => true,
	'username' => '{$this->dbUserName}',
	'password' => '{$this->dbPassword}',
	'charset' => 'utf8',
    )            
STARTIO;
    }

    /**
     * 
     * @return array
     */
    public function attributeLabels() {
        return array(
            'dbType'=>Yii::t('install', 'Type database'),
            'dbName'=>Yii::t('install', 'Name database'),
            'dbUserName'=>Yii::t('install', 'User name database'),
            'dbPassword'=>Yii::t('install', 'User password database'),
            'dbHost'=>Yii::t('install', 'Host database'),
            'siteName'=>Yii::t('install', 'Site name'),
            'email'=>Yii::t('install', 'Site email'),
        );
    }
    
    
    
    /**
     * 
     * @return array
     */
    public function getDBTypes() {
        return array(
            'mysql'=>'mysql',
            'sqlite'=>'sqlite',
        );        
    }
}
