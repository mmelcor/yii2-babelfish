<?php

namespace babelfish\models;

use Yii;
use common\models\Languages;
use babelfish\models\BabelfishUsers;

/**
 * This is the model class for table "translator_language".
 *
 * @property integer $id
 * @property integer $translator
 * @property integer $language
 */
class TranslatorLanguage extends \yii\db\ActiveRecord
{
	public $languages;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'translator_language';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('babelfishDb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['translator', 'language'], 'integer'],
			['languages', 'safe'],
		
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'translator' => 'Translator',
            'language' => 'Language',
        ];
    }

	/**
	 * @inheritdoc
	 */
	public function getLanguage()
	{
		return $this->hasOne(Lanugage::className(), ['lang_id' => 'language']);
	}

	/**
	 * @inheritdoc
	 */
	public function getUser()
	{
		return $this->hasOne(BabelfishUsers::className(), ['id' => 'translator']);
	}
}
