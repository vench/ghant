<?php

class m140927_112204_task_sorter extends CDbMigration
{
	public function up()
	{
            $this->addColumn('tbl_task', 'sortorder', 'int');
	}

	public function down()
	{
		echo "m140927_112204_task_sorter does not support migration down.\n";
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