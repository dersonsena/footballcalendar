<?php

namespace app\modules\user\models;

use app\components\ModelBase;
use Yii;
use yii\rbac\Role;

/**
 * This is the model class for table "{{%groups}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $system_group
 * @property integer $can_delete
 * @property integer $status
 * @property integer $deleted
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 *
 * @property User $createdBy
 * @property User[] $users
 */
class Group extends ModelBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%groups}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['system_group', 'status', 'deleted', 'created_by', 'can_delete'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 60],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => $this->idLabel,
            'name' => 'Nome',
            'status' => $this->statusLabel,
            'created_at' => $this->createdAtLabel,
            'updated_at' => $this->updateAtLabel,
            'created_by' => $this->createdByLabel,
        ];
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
        return $this->hasMany(User::className(), ['group_id' => 'id']);
    }

    public function isSystemGroup()
    {
        return $this->system_group == Yii::$app->params['active'];
    }

    public function canDelete()
    {
        return $this->can_delete == Yii::$app->params['active'];
    }

    /**
     * Metodo que retorna o rolename para controle de acesso (authManager)
     * @return string
     */
    public function getRoleName():string
    {
        return $this->id;
    }

    /**
     * Metodo que retorna o objeto Role para controle de acesso (authManager)
     * @return null|Role
     */
    public function getRole()
    {
        return Yii::$app->authManager->getRole($this->getRoleName());
    }

    /**
     * Metodo que retorna todas as permissoes do RBAC agrupados
     * @param string $name
     * @return array
     */
    public static function getAllPermissions(string $name=null):array
    {
        $list = [];
        $authManager = Yii::$app->authManager;

        $permissions = (!is_null($name) ? $authManager->getChildren($name) : $authManager->getPermissions());

        foreach ($permissions as $name => $permission) {

            if (empty($authManager->getChildren($name)))
                continue;

            $list[$name] = [
                'description' => $permission->description,
                'childs' => $authManager->getChildren($name)
            ];
        }

        return $list;
    }

    /**
     * Metodo que retorna as permissoes do grupo
     * @return \yii\rbac\Permission[]
     */
    public function getPermissions()
    {
        return self::getAllPermissions($this->id);
    }
}
