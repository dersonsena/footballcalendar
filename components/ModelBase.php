<?php

namespace app\components;

use Yii;
use app\components\behaviors\DbAttributesFilterBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * @property bool status
 */
abstract class ModelBase extends ActiveRecord
{
    /**
     * @var string Label para as colunas ID
     */
    protected $idLabel = 'ID';

    /**
     * @var string Label para as colunas created_at
     */
    protected $createdAtLabel = 'Data de Criação';

    /**
     * @var string Label para as colunas updated_at
     */
    protected $updateAtLabel = 'Última Atualização';

    /**
     * @var string Label para as colunas user_ins_id
     */
    protected $createdByLabel = 'Criado por';

    /**
     * @var string Label para as colunas user_ins_id
     */
    protected $updatedByLabel = 'Última Atualização por';

    /**
     * @var string Label oara os status
     */
    protected $statusLabel = 'Registro Ativo';

    /**
     * @var string Nome da coluna que representa o created_at
     */
    private $createdAtAttribute = 'created_at';

    /**
     * @var string Nome da coluna que representa o updated_at
     */
    private $updatedAtAttribute = 'updated_at';

    /**
     * @var string Nome da coluna que representa o created_by
     */
    private $createdByAttribute = 'created_by';

    /**
     * @var string Nome da coluna que representa o updated_by
     */
    private $updatedByAttribute = 'updated_by';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->loadDefaultValues();
        return parent::init();
    }

    public static function find()
    {
        if(array_key_exists('deleted', static::getTableSchema()->columns))
            return parent::find()->onCondition(static::tableName() . '.deleted = ' . Yii::$app->params['inactive']);
        else
            return parent::find();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => DbAttributesFilterBehavior::className(),
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => $this->getCreatedAtAttribute(),
                'updatedAtAttribute' => $this->getUpdatedAtAttribute(),
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => $this->getCreatedByAttribute(),
                'updatedByAttribute' => $this->getUpdatedByAttribute()
            ]
        ];
    }

    /**
     * Metodo generico para auxiliar na montagem dos dropdown dos formularios
     * @param string $labelColumn Coluna/propriedade que representa o label do dropdown
     * @param string $keyColumn Coluna/propriedade que representa o valor do dropdown
     * @param string $order Ordenacao da consulta, caso seja necessaria
     * @return array
     */
    public function getDropdownOptions($labelColumn, $keyColumn='id', $order=null)
    {
        $query = $this::find()
                    ->select([$labelColumn, $keyColumn])
                    ->orderBy(!is_null($order) ? $order : $labelColumn . ' ASC');

        if(array_key_exists('status', $this->attributes))
            $query->where(['status' => Yii::$app->params['active']]);

        return ArrayHelper::map($query->all(), $keyColumn, $labelColumn);
    }

    /**
     * Metodo que monta uma string de erros de um determinado model
     * @return string
     */
    public function getErrorsToString():string
    {
        $errors = $this->getErrors();
        $output = '<ul style="padding: 9px 0 0 16px;">';

        foreach($errors as $listErrors) {

            foreach($listErrors as $error)
                $output .= '<li>'. $error .'</li>';

        }

        $output .= '</ul>';

        return $output;
    }

    /**
     * Metodo que retorna o nome do atributo created_at do model
     * @return bool|string
     */
    private function getCreatedAtAttribute()
    {
        return (array_key_exists($this->createdAtAttribute, $this->attributes) ? $this->createdAtAttribute : false);
    }

    /**
     * Metodo que retorna o nome do atributo updated_at do model
     * @return bool|string
     */
    private function getUpdatedAtAttribute()
    {
        return (array_key_exists($this->updatedAtAttribute, $this->attributes) ? $this->updatedAtAttribute : false);
    }

    /**
     * Metodo que retorna o nome do atributo created_by do model
     * @return bool|string
     */
    private function getCreatedByAttribute()
    {
        return (array_key_exists($this->createdByAttribute, $this->attributes) ? $this->createdByAttribute : false);
    }

    /**
     * Metodo que retorna o nome do atributo updated_by do model
     * @return bool|string
     */
    private function getUpdatedByAttribute()
    {
        return (array_key_exists($this->updatedByAttribute, $this->attributes) ? $this->updatedByAttribute : false);
    }
}
