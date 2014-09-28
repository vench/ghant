<?php
/**
 * Class GhantProject
 *
 * @author vench
 */
class GhantProject extends CWidget {
    
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
    
    /**
     *
     * @var int Project ID 
     */
    public $projectID = NULL;
    
    /**
     *
     * @var boolean 
     */
    public $readonly = false;



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
            'style'=>'width:100%;height:100%;min-height:340px;'
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
                 gantt.locale.labels.section_executor = "'.Yii::t('main', 'Executor').'";
                 gantt.locale.labels.section_progress = "'.Yii::t('main', 'Progress').'";    
                 gantt.config.row_height = 24;                 
                 gantt.config.readonly = '.($this->readonly ? 'true' : 'false').';
                 gantt.config.lightbox.sections.push(
                  {name: "executor", height: 22, map_to: "executor", type: "select", 
                  options:  '.$users.' }
                );   
                

                gantt.config.lightbox.sections.push({name: "progress", height: 22, map_to: "progress", type: "select", options: [
                        {key:"0", label: "0%"},
                        {key:"0.1", label: "10%"},
                        {key:"0.2", label: "20%"},
                        {key:"0.3", label: "30%"},
                        {key:"0.4", label: "40%"},
                        {key:"0.5", label: "50%"},
                        {key:"0.6", label: "60%"},
                        {key:"0.7", label: "70%"},
                        {key:"0.8", label: "80%"},
                        {key:"0.9", label: "90%"},
                        {key:"1", label: "100%"}
                    ]});
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
