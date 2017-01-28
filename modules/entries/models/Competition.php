<?php

namespace app\modules\entries\models;

use app\components\ModelBase;
use app\components\Utils;
use app\modules\user\models\User;
use Yii;

/**
 * This is the model class for table "{{%competitions}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $responsible
 * @property string $responsible_phone
 * @property string $responsible_whatsapp
 * @property integer $status
 * @property integer $deleted
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 *
 * @property User $createdBy
 */
class Competition extends ModelBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%competitions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'responsible', 'responsible_phone'], 'required'],
            [['status', 'deleted', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'responsible'], 'string', 'max' => 60],
            [['responsible_phone', 'responsible_whatsapp'], 'string', 'max' => 15],
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
            'responsible' => 'Responsável',
            'responsible_phone' => 'Telefone',
            'responsible_whatsapp' => 'Whatsapp',
            'status' => $this->statusLabel,
            'created_at' => $this->createdAtLabel,
            'updated_at' => $this->updateAtLabel,
            'created_by' => $this->createdByLabel,
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $this->responsible_phone = Utils::transliterate($this->responsible_phone);
        $this->responsible_whatsapp = Utils::transliterate($this->responsible_whatsapp);

        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
