<?php

namespace babelfish\models;

use yii\base\Model;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class PoMessages extends Model
{
	public $id;
	public $comment;
	public $translator;
	public $translated;
    public $msgctxt;
    public $msgid;
    public $msgstr;

    public function rules()
    {
        return [
			['id', 'integer'],
            [['comment', 'translator', 'translated', 'msgctxt', 'msgid', 'msgstr'], 'string'],
            [['msgctxt', 'msgid', 'msgstr'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
			'id' => 'Translation Index',
			'comment' => 'Comments',
			'translator' => 'Translator',
			'translated' => 'Last Updated',
            'msgctxt' => 'Category',
            'msgid' => 'Original Text',
            'msgstr'  => 'Translated Text',
        ];
    }
}
