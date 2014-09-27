<?php

/**
 * This is the model class for table "tbl_task".
 *
 * The followings are the available columns in table 'tbl_task':
 * @property integer $id
 * @property integer $project_id
 * @property string $start_date
 * @property string $description
 * @property double $progress
 * @property integer $duration
 * @property integer $parent_id
 * @property integer $sortorder
 * @property integer $executor
 */
class Task extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_task';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('project_id, duration, parent_id, sortorder, executor', 'numerical', 'integerOnly'=>true),
			array('progress', 'numerical'),
			array('start_date, description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, project_id, start_date, description, progress, duration, parent_id, sortorder, executor', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'project'=>array(self::BELONGS_TO, 'Project', 'project_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('main','ID'),
			'project_id' => Yii::t('main','Task Project'),
			'start_date' => Yii::t('main','Task Start Date'),
			'description' => Yii::t('main','Task Description'),
			'progress' => Yii::t('main','Task Progress'),
			'duration' => Yii::t('main','Task Duration'),
			'parent_id' => Yii::t('main','Task Parent'),
			'sortorder' => Yii::t('main','Task Sortorder'),
			'executor' => Yii::t('main','Task Executor'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('project_id',$this->project_id);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('progress',$this->progress);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('sortorder',$this->sortorder);
		$criteria->compare('executor',$this->executor);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Task the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
