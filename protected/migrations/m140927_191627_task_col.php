<?php

class m140927_191627_task_col extends CDbMigration
{
	public function up()
	{
            $this->addColumn('tbl_task', 'end_date', 'date');
	}

	public function down()
	{
		echo "m140927_191627_task_col does not support migration down.\n";
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