<?php
namespace mmelcor\babelfish\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use mmelcor\babelfish\models\BabelfishUsers;
use trntv\filekit\behaviors\UploadBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * New User form
 */
class NewUserForm extends Model {

    public $picture;
    public $firstname;
    public $lastname;
    public $password;
    private $avatar_path;
    private $avatar_base_url;

    /**
     * @var \babelfish\models\BabelfishUsers
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->_user = BabelfishUsers::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'picture' => [
                'class' => UploadBehavior::className(),
                'attribute' => 'picture',
                'pathAttribute' => 'avatar_path',
                'baseUrlAttribute' => 'avatar_base_url'
	    ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['firstname', 'filter', 'filter' => 'trim'],
            ['firstname', 'required'],
            ['firstname', 'string', 'min' => 2, 'max' => 255],
	    
	    ['lastname', 'filter', 'filter' => 'trim'],
            ['lastname', 'required'],
            ['lastname', 'string', 'min' => 2, 'max' => 255],

            ['password', 'required'],
	    ['password', 'string', 'min' => 6],

	    ['picture', 'safe'],
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function saveUser()
    {
	$user = $this->_user;
	if (isset($this->picture['path'])) {
	    $user->avatar_base_url = $this->picture['base_url'];
	    $user->avatar_path = $this->picture['path'];
	}
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
