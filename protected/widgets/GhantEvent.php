<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GhantEvent
 *
 * @author vench
 */
class GhantEvent extends CWidget {
    
    /**
     *
     * @var type 
     */
    public $baseScriptUrl = NULL;

    /**
     *
     * @var string 
     */
    public $locale = 'ru';
    
    /**
     * broadway, meadow, skyblue, terrace
     * @var string
     */
    public $skin =  null;
    
    /**
     *
     * @var string 
     */
    public $routeLoad = 'ghant/load';

    /**
     *
     * @var string 
     */
    public $routeProcessor = 'ghant/processor';
    
    public $projectID = NULL;

    /**
     * 
     */
    public function run() {
        if(is_null($this->projectID)) {
            throw new CException("Error set param projectID");
        }
        
        $this->loadJS();
        $this->loadCSS();
        echo CHtml::tag('div', array(
            'id'=>'gantt_here', 
            'style'=>'width:100%;height:100%;min-height:200px;'
        ), '');
    }
    
    /**
     * 
     */
    public function loadJS() {
        $baseUrl = $this->getBaseScriptUrl();
        $cs=Yii::app()->getClientScript();
        $cs->registerScriptFile($baseUrl.'/dhtmlxgantt.js',CClientScript::POS_HEAD);
        
        if (!is_null($this->locale)) {
            $cs->registerScriptFile($baseUrl . '/locale/locale_' . $this->locale . '.js', CClientScript::POS_HEAD);
        }
         
        $actionProcessor = Yii::app()->createUrl($this->routeProcessor, array('pid'=>$this->projectID,));
        $actionLoad = Yii::app()->createUrl($this->routeLoad, array('pid'=>$this->projectID,));
 
        
        $users = CJavaScript::encode($this->getUsers());
        
        $cs->registerScript(__CLASS__.'#'.$this->id,
                ' 
                 gantt.locale.labels.section_executor = "executor";
   
                 gantt.config.lightbox.sections.push(
                  {name: "executor", height: 22, map_to: "executor", type: "select", 
                  options:  '.$users.' }
                );   
		 gantt.init("gantt_here");
		 gantt.load("'.$actionLoad.'" );
                
                
var dp=new dataProcessor("'.$actionProcessor.'");   
    
dp.init(gantt);
');
        
    }
    
    /**
     * 
     */
    public function loadCSS() { 
        $baseUrl = $this->getBaseScriptUrl();
        $cs=Yii::app()->getClientScript();
        $cs->registerCssFile($baseUrl.'/dhtmlxgantt.css');
        if(!is_null($this->skin)) {
            $cs->registerCssFile($baseUrl.'/skins/dhtmlxgantt_'.$this->skin.'.css');
        }
    }
    
    /**
     * 
     * @return string
     */
    public function getBaseScriptUrl() {
        if(is_null($this->baseScriptUrl)) {
            $this->baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.ghtmlghant.codebase'));
        }
        return $this->baseScriptUrl;
    }
    
    /**
     * 
     * @return array
     */
    public function getUsers() {
        $data = array();
        $users = User::model()->findAll(array(
            'select'=>'id,name',
        ));
        foreach($users as $user)  {
           $data[] = array(
               'key'=>$user->getPrimaryKey(),
               'label'=>$user->name,
           ); 
        }
        return $data;
    }
}
