<?php

class m140924_190136_core extends CDbMigration
{
	public function up()
	{
            $this->createTable('tbl_user', array(
		    'id' => 'pk',
		    'name' => 'string NOT NULL',
		    'login' => 'string NOT NULL',
		    'password' => 'string NOT NULL',	
            ));
                  
            $this->createIndex('tbl_user_login', 'tbl_user', 'login', true);
            $this->insert('tbl_user', array(
                'name'=>'Admin',
                'login'=>'admin',
                'password'=>User::passwordHash('admin'),
            ));   

            $this->createTable('tbl_project', array(
		    'id' => 'pk',
		    'user_id' => 'int',
		    'name' => 'string NOT NULL',
                    'description'=>'text'
            ));

            $this->createIndex('tbl_project_user_id', 'tbl_project', 'user_id'); 
            if($this->getDbConnection()->driverName  === 'mysql') {
                $this->addForeignKey('FK_tbl_project_user_id', 'tbl_project', 'user_id', 'tbl_user', 'id', 'NO ACTION', 'NO ACTION');
            }
            
            $this->createTable('tbl_task', array(
		    'id' => 'pk',
		    'project_id' => 'int',
                    'start_date'=>'date', 
                    'description'=>'text',
                    'progress'=>'float',
                    'duration'=>'int',
            ));
            
            $this->createTable('tbl_link', array(
		    'id' => 'pk',
		    'source' => 'int',
                    'target'=>'int', 
                    'type'=>'int', 
            ));
            
            $this->createIndex('tbl_task_project_id', 'tbl_task', 'project_id'); 
            
	}

	public function down()
	{
		echo "m140924_190136_core does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
