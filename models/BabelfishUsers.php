<?php
namespace babelfish\models;

use common\commands\AddToTimelineCommand;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use trntv\filekit\behaviors\UploadBehavior;
use babelfish\models\TranslatorLanguage;
use yii\db\Query;

/**
 * BabelfishUsers model
 *
 * @property integer $id
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $firstname
 * @property string $lastname
 * @property string $language
 * @property string $translang
 * @property string $role
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $logged_at
 * @property string $password write-only password
 */
class BabelfishUsers extends ActiveRecord implements IdentityInterface {

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public static function getDb() {
	return Yii::$app->get('babelfishDb');
    }

    /**
     * @var
     */
    public $picture;
	public $languages;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%babelfish_users}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'auth_key' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'auth_key'
                ],
                'value' => Yii::$app->getSecurity()->generateRandomString()
            ],
            'picture' => [
                'class' => UploadBehavior::className(),
                'attribute' => 'picture',
                'pathAttribute' => 'avatar_path',
                'baseUrlAttribute' => 'avatar_base_url'
	    ],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(
            parent::scenarios(),
            [
                'oauth_create' => [
                    'oauth_client', 'oauth_client_user_id', 'email', 'username', '!status'
                ]
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'unique'],
            [['firstname', 'lastname', 'avatar_path'], 'string', 'max' => 255],
            [['language', 'translang'], 'string', 'max' => 10],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
	    ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            [['picture', 'role'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'firstname' => Yii::t('global', 'First Name'),
            'lastname' => Yii::t('global', 'Last Name'),
            'language' => Yii::t('global', 'Language'),
            'translang' => Yii::t('global', 'Translation Language'),
            'email' => Yii::t('global', 'Email'),
            'status' => Yii::t('global', 'Active'),
            'picture' => Yii::t('global', 'Picture'),
            'newRole' => Yii::t('global', 'Role'),
            'access_token' => Yii::t('global', 'API access token'),
            'created_at' => Yii::t('global', 'Created at'),
            'updated_at' => Yii::t('global', 'Updated at'),
            'logged_at' => Yii::t('global', 'Last login'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
//        if (!static::isPasswordResetTokenValid($token)) {
  //          return null;
    //    }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getNewrole()
    {
        return $this->newrole;
    }

    /**
     * @inheritdoc
     */
    public function getRole() {

	$roles = Yii::$app->authManager->getRolesByUser($this->id);
	foreach($roles as $key => $value) {
	    $role = $key;
	}

	return $role;
    }

    /**
     * @inheritdoc
     */
    public function setRole() {

	if (Yii::$app->request->post('BabelfishUsers')['role']) {

	    $updatedRole = Yii::$app->request->post('BabelfishUsers')['role'];

	    $query[] = Yii::$app
		->babelfishDb
		->createCommand("
		    SELECT name `role`
		    FROM auth_item
		    WHERE type = 1
		")
		->queryAll();

	    foreach ($query[0] as $key => $value) {
		$allowed[] = $value['role'];
	    }

	    if (in_array($updatedRole, $allowed)) {

		$auth = Yii::$app->authManager;

		$oldRole = $auth->getRole($this->getRole());
		$auth->revoke($oldRole, $this->id);

		$newRole = $auth->getRole($updatedRole);
		$auth->assign($newRole, $this->id);
	    }
	}
    }

	/**
	 * @inheritdoc
	 */
	public function getLanguages()
	{
		return $this->hasMany(Language::className(), ['language' => 'lang_id'])
			->via('translatorLanguage');
	}

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Creates user profile and application event
     * @param array $profileData
     */
    public function afterSignup(array $profileData = [])
    {
        $this->refresh();
        Yii::$app->commandBus->handle(new AddToTimelineCommand([
            'category' => 'user',
            'event' => 'signup',
            'data' => [
                'public_identity' => $this->getPublicIdentity(),
                'user_id' => $this->getId(),
                'created_at' => $this->created_at
            ]
        ]));
        $profile = new UserProfile();
        $profile->load($profileData, '');
        $this->link('userProfile', $profile);
        $this->trigger(self::EVENT_AFTER_SIGNUP);
        // Default role
        $auth = Yii::$app->authManager;
        $auth->assign($auth->getRole(BabelfishUsers::ROLE_USER), $this->getId());
    }

    /**
     * @return string
     */
    public function getPublicIdentity()
    {
        if ($this->userProfile && $this->userProfile->getFullname()) {
            return $this->userProfile->getFullname();
        }
        return $this->email;
    }
}
