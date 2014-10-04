<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ChangeUserPassword
 *
 * @author vench
 */
class ChangeUserPassword extends CFormModel {
    
    public $password;
    
    public $password1;

    /**
     * 
     * @return type
     */
    public function rules() {
	return array(
            array('password, password1', 'required'),
            array('password', 'length', 'min'=>4),
            array('password', 'compare', 'compareAttribute'=> 'password1'),
        );
    }
    
    	public function attributeLabels()
	{
		return array(
			'password'=>Yii::t('main', 'Password'),
                        'password1'=>Yii::t('main', 'Confirm password'),
		);
	}
}
