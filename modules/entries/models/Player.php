<?php

namespace app\modules\entries\models;

use app\components\ModelBase;
use app\modules\user\models\User;
use Yii;

/**
 * This is the model class for table "{{%players}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property integer $deleted
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 *
 * @property User $createdBy
 */
class Player extends ModelBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%players}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'deleted', 'created_by'], 'integer'],
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
            'status' => 'Atleta Ativo ?',
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
}
