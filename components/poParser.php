<?php

namespace mmelcor\babelfish\components;

use Yii;
use yii\base\Component;
use mmelcor\babelfish\models\PoMessages;

class poParser extends Component {

    public $translations = [];
    public $header = [];
    public $basepath;
    public $filename;

    public function fetch($lang) {

	$po = file($this->basepath.$lang.$this->filename);
	$i = 0;
	$row = 0;
	$len = 0;

	foreach ($po as $line) {
	    $len++;
	    if ($line == "\n" || $line == "\r\n") {
		break;
	    }
	}

	foreach ($po as $line) {
	    if ($row < $len) {
		$row++;
		continue;
	    } else {
		if ($line == "\n" || $line == "\r\n") {
		    $i++;
		}
		if ($line[0] == '#' || substr($line,0,7) == 'msgctxt') {
		    if(!isset($model)){
			$model = new PoMessages();
			$model->id = $i;
		    }
		}
		if ($line[0] == '#') {
		    $commentId = substr($line, 2, 10);
		    if ($commentId == 'TRANSLATED') {
			$model->translated = substr($line, 14, -1);
		    } elseif ($commentId == 'TRANSLATOR') {
			$model->translator = substr($line, 14, -1);
		    } else {
			$model->comment = substr($line, 11, -1);
		    }
		}
		if (substr($line,0,7) == 'msgctxt') {
		    $category = trim(substr(trim(substr($line,7)),1,-1));
		    $model->msgctxt = $category;
		}
		if (substr($line,0,5) == 'msgid') {
		    $id = trim(substr(trim(substr($line,5)),1,-1));
		    $model->msgid = $id;
		}
		if (substr($line,0,6) == 'msgstr') {
		    $msgstr = trim(substr(trim(substr($line,6)),1,-1));
		    $model->msgstr = stripslashes($msgstr);
		    $translations[$i] = $model;
		    unset($model);
		}
	    }
	}
	return [$translations];
    }

    public function save($lang, $translations) {
	
	$len = 0;
	$row = 0;
	$data = '';
	$file = $this->basepath.$lang.$this->filename;
	$po = file($file);

	foreach ($po as $line) {
	    $len++;
	    if ($line == "\n" || $line == "\r\n") {
		break;
	    }
	}

	foreach ($po as $line) {
	    if ($row < $len) {
		    $data .= $line;
		    $row++;
	    }
	}

	foreach ($translations as $translation) {
		if($translation->comment) {
		$data .= '# COMMENT: ' . $translation->comment . "\n";
		}
		if($translation->translator) {
		$data .= '# TRANSLATOR: ' . $translation->translator . "\n";
		}
		if($translation->translated) {
		$data .= '# TRANSLATED: ' . $translation->translated . "\n";
		}
		$data .= 'msgctxt "' . $translation->msgctxt . "\"\n";
		$data .= 'msgid "' . $translation->msgid . "\"\n";
		$data .= 'msgstr "' . addslashes($translation->msgstr) . "\"\n";
	    $data .= "\n";
	}
	return file_put_contents($file, $data);
    }
}
