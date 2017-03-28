<?php

namespace mmelcor\babelfish\models;

use Yii;
use oorrwullie\babelfishfood\models\Languages;
use mmelcor\babelfish\models\BabelfishUsers;

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
    public $newLanguages;

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
     * Checks $newLanguages vs $languages and removes or adds differences.
     */
    public function updateAssociations()
    {
	$deleted = null;
	if(isset($this->languages)) {
		$deleted = array_udiff($this->languages, $this->newLanguages['languages'], [$this, 'compare_languages']);
	}

	if($deleted) {
	    foreach($deleted as $delete) {
		$language = TranslatorLanguage::findOne(['translator' => $this->translator, 'language' => $delete]);
		$language->delete();
	    }
	}
    }

    /**
     * Saves the languages if they do not currently exist.
     *
     * @return true|false if it is able to save.
     */
    public function saveNew()
    {
	foreach($this->newLanguages['languages'] as $lang) {
	    if(!TranslatorLanguage::findOne(['translator' => $this->translator, 'language' => $lang])) {
		$newLang = new TranslatorLanguage();
		$newLang->translator = $this->translator;
		$newLang->language = $lang;

		if(!$newLang->save()) {
		    return false;
		}
	    }
	}
	return true;
    }

    /**
     * Compares arrays
     *
     * @return boolean
     */
    public function compare_languages($languages, $newLanguages)
    {
	return strcmp($languages, $newLanguages);
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
