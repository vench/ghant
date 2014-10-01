<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProjectHelper
 *
 * @author vench
 */
class ProjectHelper {
    
    /**
     * 
     * @param type $projectID
     * @return boolean
     */
    public static function accessViewProject($projectID) {
         if(self::currentUserIsAdmin()) {
            return true;
        }
        return false;
    }
    
    /**
     * 
     * @param type $projectID
     * @return boolean
     */
    public static function accessEditProject($projectID) {
        if(self::currentUserIsAdmin()) {
            return true;
        }
        return false;
    } 
    
    /**
     * 
     * @return boolean
     */
    public static function currentUserIsAdmin() {
        if(Yii::app()->user->isGuest) {
            return false;
        }
        $model = User::model()->find(array(
                'condition'=>'id=:id',
                'params'=>array(
                    ':id'=>Yii::app()->user->getId(),
                ),
                'select'=>'is_admin',
        ));
        return !is_null($model) && $model->is_admin == 1;
    }
}
