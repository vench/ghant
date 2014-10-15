<?php
 

/**
 * Description of GhantController
 *
 * @author vench
 */
class GhantController extends Controller {

    /**
     *
     * @var array 
     */
    protected $xmlOutput = array();
    
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
		'actions'=>array('Load'),
		'expression' => array($this,'allowGhantLoad'),
            ),
            array('allow',  
		'actions'=>array('Processor'),
		'expression' => array($this,'allowGhantProcessor'),
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
    public function allowGhantLoad() {
        $projectID  = Yii::app()->request->getParam('pid');
        return ProjectHelper::accessViewProject($projectID);
    }
    
    /**
     * 
     * @return boolean
     */
    public function allowGhantProcessor() {         
        return TRUE;
    }

    /**
     * 
     * @param int $pid Project ID
     */
    public function actionLoad($pid = NULL) {
        $tasks = array(); 
        $ids = array();
        $models = Task::model()->findAll(array( 
            'condition'=>'project_id=:project_id',
            'params'=>array(
                ':project_id'=>$pid,
            ),
            'with'=>array(
                'project'=>array(
                    'select'=>'user_id',
                ),
            ),
        ));
        $userId = Yii::app()->user->getId();
        foreach($models as $model) {
            $onwer = $model->project->user_id == $userId;
            $tasks[] = array(
                'id'=>$model->getPrimaryKey(),
                'text'=>$model->description,
                'start_date'=>$model->start_date,
                'duration'=>$model->duration,
                'progress'=>$model->progress,
                'parent'=> $model->parent_id,
                'sortorder'=>$model->sortorder,
                'executor'=>$model->executor,
                //'open'=>true,
                'readonly'=>(!$onwer && $userId !== $model->executor),
                'editable'=>($onwer || $userId == $model->executor),
            );
            $ids[] = $model->getPrimaryKey();
        }
        
        $links = Link::model()->findAllByAttributes(array(
            'source'=>$ids,
        ));

        echo CJSON::encode(array(
            'data' => $tasks,
            'collections'=>array(
                'links'=>$links,
            ),
        ));
        Yii::app()->end();
    }

    /**
     * 
     * @param int $ids
     * @return array
     */
    protected function loadDataByID($ids) {
        $data = array();
        foreach ($_POST as $key => $value) {
            $expl = explode('_', $key, 2);  
            if (sizeof($expl) == 2 && $expl[0] == $ids) {
                $data[$expl[1]] = $value;
            }
        }
        return $data;
    }

    /**
     * 
     * @param int $pid Project ID
     * @param type $editing
     * @param type $gantt_mode
     */
    public function actionProcessor($pid, $editing = '', $gantt_mode = '') {
        $ids = isset($_POST['ids']) ? explode(',', $_POST['ids']) : array();
        foreach($ids as $id) {
            //check access
            if(!ProjectHelper::accessEditProject($pid, $id)) {
               $this->xmlOutputError('Error access', $id); 
               continue;
            }
            $data = $this->loadDataByID($id); 
            $status = isset($data['!nativeeditor_status']) ? $data['!nativeeditor_status'] : '';
            $methodName = 'ghant_'. $gantt_mode.$status;
            if(method_exists($this, $methodName)) {
                call_user_func_array(array($this, $methodName), array($id, $data, $pid));
            } else {
                $this->xmlOutputError('Method not found ['.$methodName.']', $id); 
            }
        }
        
        $this->xmlOutputFlush(); 
    }
    
    
    public function xmlOutputFlush() {
        header('Content-Type: text/xml');
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<data>';
        foreach($this->xmlOutput as $action) {
            echo $action;
        }
        echo '</data>';
        Yii::app()->end(); 
    }
    
    /**
     * 
     * @param type $message
     * @param type $sid
     */
    public function xmlOutputError($message, $sid) {         
          $this->xmlOutput[] = '<action sid="'.$sid.'" type="invalid" message="'.$message.'" />'; 
    }
    
    /**
     * 
     * @param type $type
     * @param type $sid
     * @param type $tid
     */
    public function xmlOutputSuccess($type, $sid, $tid) { 
        $this->xmlOutput[] = "<action type='$type' sid='$sid' tid='$tid' ></action>";          
    }
    
    /**
     * 
     * @param type $sid
     * @param type $data
     */
    protected function ghant_linksinserted($sid, $data) {
        $model = new Link();
        $model->target = isset($data['target']) ? $data['target'] : 0;
        $model->source = isset($data['source']) ? $data['source'] : 0;
        $model->type = isset($data['type']) ? $data['type'] : '';
        if ($model->save()) {
            $this->xmlOutputSuccess('inserted', $sid, $model->getPrimaryKey());
        } else {
            $this->xmlOutputError('Error crate link', $sid);
        }
    }
    
    /**
     * 
     * @param type $sid
     * @param type $data
     */
    protected function  ghant_linksdeleted($sid, $data) {
        $id = isset($data['id']) ? $data['id'] : NULL;
        $model = Link::model()->findByPk($id);
        if(!is_null($model) && $model->delete()) {
            $this->xmlOutputSuccess('deleted', $sid, $model->getPrimaryKey());
        } else {
            $this->xmlOutputError('Error deleted link', $sid);
        }
    }

    /**
     * 
     * @param type $sid
     * @param type $data
     */
    protected function ghant_tasksupdated($sid, $data) {
        $id = isset($data['id']) ? $data['id'] : NULL;
        $model = Task::model()->findByPk($id);
         if(!is_null($model)) {
                $model->description = $data['text'];
                $model->duration = $data['duration'];
                $model->start_date = $data['start_date']; 
                $model->end_date = $data['end_date']; 
                if(isset($data['progress'])) {
                    $model->progress =  $data['progress'];
                }
                if(isset($data['executor'])) {
                    $model->executor =  $data['executor'];
                }
                $model->parent_id = $data['parent'];
               if( $model->save()) {
                    $this->xmlOutputSuccess('updated', $sid, $model->getPrimaryKey());
                    return;
               }
         } 
         $this->xmlOutputError('Error update task', $sid);
    }
    
    /**
     * 
     * @param type $sid
     * @param type $data
     * @param type $pid
     */
    protected function ghant_tasksinserted($sid, $data, $pid) {
        $model = new Task();
        $model->project_id = $pid;
        $model->description = $data['text'];
        $model->duration = $data['duration'];
        $model->start_date = $data['start_date'];
        $model->parent_id = $data['parent'];
        $model->end_date = $data['end_date']; 
        $model->progress = 0; 
        if(isset($data['executor'])) {
                    $model->executor =  $data['executor'];
        }
        if($model->save()) {
             $this->xmlOutputSuccess('inserted', $sid, $model->getPrimaryKey());
             return;
        }
        $this->xmlOutputError('Error create task', $sid);
    }
    
    /**
     * 
     * @param type $sid
     * @param type $data
     */
    protected function  ghant_tasksdeleted($sid, $data) {
        $id = isset($data['id']) ? $data['id'] : NULL;
        $model = Task::model()->findByPk($id);
        if (!is_null($model) && $model->delete()) {
            $this->xmlOutputSuccess('deleted', $sid, $model->getPrimaryKey());
        } else {
            $this->xmlOutputError('Error delete task', $sid);
        }
    }
}
