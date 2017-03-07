<?php

namespace backend\modules\babelfish\models;

use yii\base\Model;

class MailModel extends Model
{
	public $sendor;
	public $send_name;
	public $recipients;
	public $language;
	public $body_aug;
	public $trans_names;

	public function rules()
	{
		return [
			[
				[
					'sendor',
					'send_name',
					'body_aug', 
					'trans_names'
				], 
				'string'
			],
			[['recipients', 'language'], 'safe'],
			[['sendor', 'send_name', 'recipients', 'language'], 'required'],
		];	
	}
	
	public function attributeLabels()
	{
		return [
			'sendor' => 'From',
			'recipient' => 'To',
			'language' => 'Language',
			'body_aug' => 'Mail Details',
		];
	}
}
