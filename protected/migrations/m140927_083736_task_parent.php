<?php

class m140927_083736_task_parent extends CDbMigration
{
	public function up()
	{
            $this->addColumn('tbl_task', 'parent_id', 'int');
            $this->createIndex('tbl_task_parent_id', 'tbl_task', 'parent_id');
	}

	public function down()
	{
		echo "m140927_083736_task_parent does not support migration down.\n";
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