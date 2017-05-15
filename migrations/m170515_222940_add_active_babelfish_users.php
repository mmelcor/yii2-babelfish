<?php

use yii\db\Migration;

class m170515_222940_add_active_babelfish_users extends Migration
{
	public function init()
	{
		$this->db = 'babelfishDb';
		parent::init();
	}

    public function up()
    {
		$this->addColumn('babelfish_users', [
			'active' => $this->boolean(),
		]);
    }

    public function down()
    {
		$this->dropColumn('babelfish_users', 'active');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
