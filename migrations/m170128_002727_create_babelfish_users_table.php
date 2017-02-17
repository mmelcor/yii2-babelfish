<?php

use yii\db\Migration;

/**
 * Handles the creation of table `babelfish_users`.
 */
class m170128_002727_create_babelfish_users_table extends Migration {

    public function init() {

        $this->db = 'babelfishDb';
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function up() {

	$table = Yii::$app->babelfishDb->schema->getTableSchema('babelfish_users');

	if ($table === null) {
	    $tableOptions = null;
	    if ($this->db->driverName === 'mysql') {
		// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
	    }
	    $this->createTable('babelfish_users', [
		'id' => $this->primaryKey(),
		'auth_key' => $this->string(32)->notNull(),
		'password_hash' => $this->string()->notNull(),
		'password_reset_token' => $this->string()->unique(),
		'email' => $this->string()->notNull()->unique(),
		'status' => $this->smallInteger()->notNull()->defaultValue(0),
		'created_at' => $this->integer()->notNull(),
		'updated_at' => $this->integer()->notNull(),
		'firstname' => $this->string(32)->notNull(),
		'lastname' => $this->string(32)->notNull(),
		'avatar_path' => $this->string(250),
		'avatar_base_url' => $this->string(250),
		'language' => $this->string(10),
		'translang' => $this->string(10),
	    ], $tableOptions);
	}
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('babelfish_users');
    }
}
