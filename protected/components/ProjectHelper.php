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
     * Текущей пользователь  получает право на просмотр если:
     * Администратор, создатель проекта, учавствует хотя бы  в одном задании
     * @param type $projectID
     * @return boolean
     */
    public static function accessViewProject($projectID) {
         if(self::currentUserIsAdmin()) {
            return true;
        }
         if(!is_null(Project::model()->find(array(
            'select'=>'id',
            'condition'=>'id=:id AND user_id=:user_id',
            'params'=>array(
                ':id'=>$projectID,
                ':user_id'=>Yii::app()->user->getId(),
        ))))) {
            return true;
        }
          if(!is_null(Task::model()->find(array(
            'select'=>'id',
            'condition'=>' project_id=:project_id AND executor=:user_id',
            'params'=>array( 
                ':project_id'=>$projectID,
                ':user_id'=>Yii::app()->user->getId(),
             )    
        )))) {
            return true;
        }
        return false;
    }
    
    /**
     * Получает доступ к редактированию проекту если:
     * Администратор, содатель проекта, участник конкретного действия.
     * @param type $projectID
     * @return boolean
     */
    public static function accessEditProject($projectID, $taskId = NULL) {
        if(self::currentUserIsAdmin()) {
            return true;
        }
        if(!is_null(Project::model()->find(array(
            'select'=>'id',
            'condition'=>'id=:id AND user_id=:user_id',
            'params'=>array(
                ':id'=>$projectID,
                ':user_id'=>Yii::app()->user->getId(),
        ))))) {
            return true;
        }
        if(!is_null($taskId) && !is_null(Task::model()->find(array(
            'select'=>'id',
            'condition'=>'id=:id  AND project_id=:project_id AND executor=:user_id',
            'params'=>array(
                ':id'=>$taskId,
                ':project_id'=>$projectID,
                ':user_id'=>Yii::app()->user->getId(),
             )    
        )))) {
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
