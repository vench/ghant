<?php

class m140927_124337_add_colls extends CDbMigration
{
	public function up()
	{
            $this->addColumn('tbl_task', 'executor', 'int');
            $this->addColumn('tbl_user', 'is_admin', 'int');
            $this->createIndex('tbl_task_executor', 'tbl_task', 'executor');
	}

	public function down()
	{
		echo "m140927_124337_add_colls does not support migration down.\n";
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