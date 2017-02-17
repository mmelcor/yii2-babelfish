<?php

namespace babelfish\components;

use Yii;
use yii\base\Component;
use yii\web\IdentityInterface;

class transLang extends Component {

    public $callback;
    public $languages;
    
    /**
     * @inheritdoc
     * @param array $config
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct($config = array())
    {

        parent::__construct($config);
    }
    
    /**
     * @inheritdoc
     */
    public function init()
    {

        $this->initLanguage();

        parent::init();
    }

    /**
     * Setting the language for translations.
     */
    public function initLanguage()
    {
	if (isset($_GET['translang'])) {
	    if ($this->_isValidLanguage($_GET['translang'])) {
                return $this->saveLanguage($_GET['translang']);
            } else if (!Yii::$app->request->isAjax) {
                return $this->_redirect();
            }
        }

        $this->detectLanguage();
    }

    /**
     * Saving language into database.
     * @param string $language - The language to save.
     * @return static
     */
    public function saveLanguage($language) {

        if (is_callable($this->callback)) {
	    call_user_func($this->callback, $language);
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->end();
        }

        return $this->_redirect();
    }

    /**
     * Determine language based on UserAgent.
     */
    public function detectLanguage()
    {
	if(!isset(Yii::$app->translang)) {
	    Yii::$app->translang = 'en';
	}
    }

    /**
     * Redirects the browser to the referer URL.
     * @return static
     */
    private function _redirect()
    {
        $redirect = Yii::$app->request->absoluteUrl == Yii::$app->request->referrer ? '/' : Yii::$app->request->referrer;
        return Yii::$app->response->redirect($redirect);
    }

    /**
     * Determines whether the language received as a parameter can be processed.
     * @param string $language
     * @return boolean
     */
    private function _isValidLanguage($language)
    {
        return is_string($language) && (isset($this->languages[$language]) || in_array($language, $this->languages));
    }

}
