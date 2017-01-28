<?php

namespace app\models;

use app\components\ModelBase;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%flags}}".
 *
 * @property integer $id
 * @property string $description
 * @property string $namespace
 * @property integer $status
 */
class Flag extends ModelBase
{
    const MALE = 1;
    const FEMALE = 2;
    const SETTING_TYPE_TEXT = 3;
    const SETTING_TYPE_INT = 4;
    const SETTING_TYPE_DECIMAL = 5;
    const SETTING_TYPE_BOOL = 6;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%flags}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'namespace'], 'required'],
            [['status'], 'integer'],
            [['description'], 'string', 'max' => 60],
            [['namespace'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'namespace' => 'Namespace',
            'status' => 'Status',
        ];
    }

    /**
     * Metodo que retorna os possiveis valores de um determinado namespace
     * @param string $namespace
     * @return array
     */
    public static function getValuesFromNamespace(string $namespace): array
    {
        return Flag::find()
            ->where(['namespace' => $namespace])
            ->orderBy('description ASC')
            ->all();
    }

    /**
     * Metodo que retorna uma lista no formato 'id' => 'description' de um
     * determinado namespace
     * @param string $namespace
     * @return array
     */
    public static function getFlagsDownDownOptions(string $namespace): array
    {
        $collection = self::getValuesFromNamespace($namespace);
        return ArrayHelper::map($collection, 'id', 'description');
    }
}
