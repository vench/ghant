<?php

class ProjectController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index', 'ajaxList'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create'),
				'users'=>array('@'),
			),
                        array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('view','update'),
				'expression' => array($this,'allowEditProject')
			),
                        array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('view'),
				'expression' => array($this,'allowViewProject')
			),  
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'expression' => array($this,'allowOnlyAdmin')
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
        public function allowEditProject() {
            $projectID  = Yii::app()->request->getParam('id');
            return ProjectHelper::accessEditProject($projectID);
        }
        
        /**
         * @return boolean
         */
        public function  allowViewProject() {
           $projectID  = Yii::app()->request->getParam('id');
            return ProjectHelper::accessViewProject($projectID); 
        }

         /**
         * Query for calendar
         */
        public function actionAjaxList($start, $end) {
            $user_id = Yii::app()->user->getId(); 
            $conditionDate = '(start_date < :end AND end_date > :start)';
            if(Yii::app()->db->driverName == 'sqlite') {
                $conditionDate = '(date(start_date) < date(:end) AND date(end_date) > date(:start))';
            }   
            $tasks = Task::model()->findAll(array(
                'condition'=>$conditionDate
                 .' AND (project.user_id = :user_id OR t.executor =:user_id1 )' ,               
                'params'=>array(
                   ':end'=>date('Y-m-d', $end),
                   ':start'=>date('Y-m-d', $start),
                   ':user_id'=>$user_id,
                   ':user_id1'=>$user_id,
                ),
                'with'=>array(
                    'project'=>array(
                        'select'=>'user_id',
                    ),
                ),
            ));
            $data=array();
            foreach($tasks as $task) {        
                $data[] = array(
                    'title'=>$task->description,
                    'start'=>strtotime($task->start_date),
                    'end'=>strtotime($task->end_date)-1,
                    'url'=>$this->createUrl('/project/view', array('id'=>$task->project_id)), 
                );
            }
             echo CJSON::encode($data);
             Yii::app()->end();
        }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
                $this->layout = '//layouts/column1';
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Project;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Project']))
		{
			$model->attributes=$_POST['Project'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Project']))
		{
			$model->attributes=$_POST['Project'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Project');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Project('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Project']))
			$model->attributes=$_GET['Project'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Project the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Project::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Project $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='project-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
