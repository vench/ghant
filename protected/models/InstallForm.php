<?php

 

/**
 * Description of InstallForm
 *
 * @author vench
 */
class InstallForm extends  CFormModel {
    public $dbType;
    public $dbName;
    public $dbUserName;
    public $dbPassword;
    public $dbHost;
    public $siteName;
    public $email;
    
    /**
     * 
     * @return array
     */
    public function rules() {
        return array(
            array('dbType, dbName,siteName,email', 'required'),
            array('dbUserName,dbPassword,dbHost', 'safe'),
            array('email', 'email'),
        );
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
            'mysql',
            'sqlite',
        );        
    }
}
