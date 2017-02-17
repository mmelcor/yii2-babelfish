<?php

use yii\db\Migration;

/**
 * Handles the creation of table `translator_language`.
 */
class m170206_213741_create_translator_language_table extends Migration
{
    public function init() {

        $this->db = 'babelfishDb';
        parent::init();
    }
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('translator_language', [
            'id' => $this->primaryKey(),
			'translator' => $this->integer(),
			'language' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('translator_language');
    }
}
