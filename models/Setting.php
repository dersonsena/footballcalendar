<?php

namespace app\models;

use app\components\Formatter;
use app\components\ModelBase;
use app\modules\user\models\User;
use Yii;

/**
 * This is the model class for table "{{%settings}}".
 *
 * @property integer $id
 * @property integer $type_id
 * @property string $abbreviation
 * @property string $title
 * @property string $description
 * @property string $value
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property Flag $type
 * @property User $updatedBy
 */
class Setting extends ModelBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'abbreviation', 'title', 'description', 'value'], 'required'],
            [['type_id', 'updated_by'], 'integer'],
            [['updated_at'], 'safe'],
            [['abbreviation'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 60],
            [['description', 'value'], 'string', 'max' => 150],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Flag::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Type ID',
            'abbreviation' => 'Abbreviation',
            'title' => 'Title',
            'description' => 'Description',
            'value' => 'Value',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Flag::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function isText()
    {
        return $this->type_id === Flag::SETTING_TYPE_TEXT;
    }

    public function isInteger()
    {
        return $this->type_id === Flag::SETTING_TYPE_INT;
    }

    public function isDecimal()
    {
        return $this->type_id === Flag::SETTING_TYPE_DECIMAL;
    }

    public function isBoolean()
    {
        return $this->type_id === Flag::SETTING_TYPE_BOOL;
    }

    public static function getSettingsRows()
    {
        $settings = [];

        /** @var Setting[] $rows */
        $rows = static::find()
            ->orderBy('abbreviation ASC')
            ->all();

        foreach ($rows as $row)
            $settings[$row->abbreviation] = $row;

        return $settings;
    }

    public function changeSetting($newValue)
    {
        /** @var Formatter $formatter */
        $formatter = Yii::$app->formatter;

        if ($this->isInteger())
            $newValue = intval($newValue);

        else if ($this->isDecimal())
            $newValue = $formatter->asDecimalUS($newValue);

        $this->value = $newValue;

        return $this->save();
    }
}
