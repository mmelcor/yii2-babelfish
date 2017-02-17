<?php

namespace babelfish\models;

use Yii;
use babelfish\components\poParser;
use yii\data\ArrayDataProvider;
use babelfish\models\PoMessages;

/**
 * PoMessagesSearch represents the model behind the search form about `babelfish\models\PoMessages`.
 * @property integer $index
 * @property array $all_translations
 * @property array $query_translations
 */
class PoMessagesSearch extends PoMessages
{
	public $index;
	public $all_translations;
	public $query_translations;

	public function getData($lang) 
	{
		$parser = Yii::$app->poParser;
		$this->all_translations = $parser->fetch($lang);
	}
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['translator', 'msgctxt', 'msgid', 'msgstr', 'comment'], 'string'],
		];
	}

	/**
	 *Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ArrayDataProvider
	 */
	public function search($params)
	{
		$this->load($params);
		if(!$this->validate()) {
			$translations = new ArrayDataProvider([
				'allModels' => $this->all_translations[0],
				'pagination' => [
					'pageSize' => 25,
				],
				'sort' => [
					'attributes' => [ 'comment', 'translator', 'translated', 'msgctxt', 'msgid', 'msgstr'],
				],
			]);
		}

		$this->filter([
			'translator' => $this->translator,
			'comment' => $this->comment,
			'msgid' => $this->msgid,
			'msgctxt' => $this->msgctxt,
			'msgstr' => $this->msgstr,
		]);

		$translations = new ArrayDataProvider([
			'allModels' => $this->query_translations,
			'pagination' => [
				'pageSize' => 25,
			],
			'sort' => [
				'attributes' => [ 'comment', 'translator', 'translated', 'msgctxt', 'msgid', 'msgstr'],
			],
		]);
	
		return $translations;
	}
	
	/**
	 * Filter for searching data array.
	 */
	public function filter($params)
	{
		$models = null;
		foreach($params as $param_key => $param_value) {
			if($param_value != null) {
				foreach($this->all_translations[0] as $key => $value) {
					if(strpos($value->$param_key, $param_value) !==false) {
						$models[$key] = $value;
					}
				}
			}
		}

		if(!$models) {
			$models = $this->all_translations[0];
		}

		$this->query_translations = $models;
				
	}

	/**
	 * Function to save changed PoMessages.
	 */
	public function save($lang, $model)
	{
		$this->getData($lang);

		$new_array = array_replace($this->all_translations[0], $model);

		$parser = Yii::$app->poParser;

		return $parser->save($lang, $new_array);
	}
}