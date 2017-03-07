<?php

namespace mmelcor\babelfish\models\search;

use Yii;
use yii\base\Model;
use mmelcor\babelfish\components\poParser;
use yii\data\ArrayDataProvider;

class PoMessagesSearch extends Model
{
    public $comment;
    public $translated;
    public $translator;
    public $msgctxt;
    public $msgid;
    public $msgstr;

    /**
     * @inheritdoc
     */
    public function rules()
    {
	return [
	    [['msgctxt', 'msgid', 'msgstr'], 'string'],
	    [['comment', 'translated', 'translator'], 'safe'],
	];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
	return [
	    'comment' => 'Comment',
	    'translated' => 'Translated',
	    'translator' => 'Translated',
	    'msgctxt' => 'Category',
	    'msgid' => 'Text',
	    'msgstr' => 'Translation',
	];
    }

    /**
     * @param $params
     * @return ArrayDataProvider
     */
    public function search($params)
    {
	$parser = new poParser();
	$data = $parser->fetch('../../common/messages/de/messages.po');
	$items = $data[0];

	print_r($items);
	if ($this->load($params)) {
	    $msgid = strtolower(trim($this->msgid));
	    $items = array_filter($items, function ($role) use ($msgid) {
		return (empty($msgid) || strpos((strtolower(is_object($role) ? $role->msgid : $role['msgid'])), $msgid) !== false);
	    });
	}

	$dataProvider = new ArrayDataProvider(
	    ['key'=>'text',
	    'allModels' => $items,
	    'pagination' => false,
	    'sort' => [
		'attributes' => ['comment', 'translated', 'translator', 'msgctxt', 'msgid', 'msgstr'],
	    ],
	]);
	if (!($this->load($params) && $this->validate())) {
	    return $dataProvider;
	}
    }
}
