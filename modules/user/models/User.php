<?php

namespace app\modules\user\models;

use app\components\ModelBase;
use app\models\Setting;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property integer $id
 * @property integer $group_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $token
 * @property string $auth_key
 * @property integer $status
 * @property integer $deleted
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 *
 * @property Group[] $Group
 * @property Setting[] $Setting
 * @property User $createdBy
 * @property User[] $users
 * @property Group $group
 */
class User extends ModelBase implements IdentityInterface
{
    /**
     * @var string
     */
    public $repeatPassword;

    /**
     * @var string atributo para ser utilizado ao atualizar
     * a senha de acesso do usuario
     */
    public $currentPassword;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'name', 'email', 'password'], 'required'],
            [['group_id', 'status', 'deleted', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'email', 'password'], 'string', 'max' => 60],
            [['token', 'auth_key'], 'string', 'max' => 100],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Group::className(), 'targetAttribute' => ['group_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Group ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'token' => 'Token',
            'auth_key' => 'Auth Key',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }

    public function afterFind()
    {
        $this->currentPassword = $this->password;

        if (!$this->isNewRecord)
            $this->password = '';

        parent::afterFind();
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            $this->repeatPassword = $this->password;
            $this->auth_key = Yii::$app->getSecurity()->generateRandomString(70);
        } else {
            if (empty($this->password)) {
                $this->password = $this->currentPassword;
                $this->repeatPassword = $this->currentPassword;
            } else {
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
                $this->repeatPassword = $this->password;
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Group::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSetting()
    {
        return $this->hasMany(Setting::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
    }

    /**
     * Finds an identity by the given ID.
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $authKey === $this->auth_key;
    }

    public function validatePassword(string $password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->currentPassword);
    }
}
