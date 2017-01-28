<?php

namespace app\components\behaviors;

use app\components\Formatter;
use Yii;
use app\components\Utils;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\db\ColumnSchema;

class DbAttributesFilterBehavior extends Behavior
{
    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'filterData',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'filterData',
        ];
    }

    public function afterFind(Event $event)
    {
        /** @var Formatter $formatter */
        $formatter = Yii::$app->formatter;
        $tableColumns = $this->owner->getTableSchema()->columns;

        /** @var ColumnSchema $column */
        foreach ($tableColumns as $column) {

            if ($this->isDateColumn($column)) {

                if (!Utils::IsNullOrEmpty($this->owner->{$column->name}))
                    $this->owner->{$column->name} = $formatter->asDate($this->owner->{$column->name});
            }

            if ($this->isDateTimeColumn($column)) {

                if (!Utils::IsNullOrEmpty($this->owner->{$column->name}))
                    $this->owner->{$column->name} = $formatter->asDatetime($this->owner->{$column->name});
            }

            if ($this->isDecimalColumn($column))
                $this->owner->{$column->name} = $formatter->asDecimal($this->owner->{$column->name});
        }
    }

    public function filterData(Event $event)
    {
        /** @var Formatter $formatter */
        $formatter = Yii::$app->formatter;
        $tableColumns = $this->owner->getTableSchema()->columns;

        /** @var ColumnSchema $column */
        foreach($tableColumns as $column) {

            if(empty($this->owner->{$column->name}))
                continue;

            if($this->isDecimalColumn($column) && $this->isDecimalBRFormat($column))
                $this->owner->{$column->name} = $formatter->asDecimalUS($this->owner->{$column->name});

            if($this->isDateColumn($column))
                $this->owner->{$column->name} = $formatter->asDateUS($this->owner->{$column->name}, 'yyyy-MM-dd');

            if($this->isDateTimeColumn($column)) {

                $value = ($this->owner->{$column->name} == 'NOW()' ? date('Y-m-d H:i:s') : $this->owner->{$column->name});

                if($this->isDateOrDatetimeBRFormat($column)) {
                    $explodeDate = explode('/', $this->owner->{$column->name});
                    $explodeYear = explode(' ', $explodeDate[2]);
                    $value = $explodeYear[0] . '-' . $explodeDate[1] . '-' . $explodeDate[0] . ' ' . $explodeYear[1];
                }

                $this->owner->{$column->name} = $formatter->asDatetime($value, 'yyyy-MM-dd HH:mm:ss');
            }

        }
    }

    /**
     * Metodo que verifica se a coluna informada e do tipo Double/Decimal
     * @param ColumnSchema $column
     * @return bool
     */
    private function isDecimalColumn(ColumnSchema $column)
    {
        return in_array($column->type, ['decimal','double','float','real','numeric']);
    }

    /**
     * Metodo que verifica se a coluna informada e do tipo Date
     * @param ColumnSchema $column
     * @return bool
     */
    private function isDateColumn(ColumnSchema $column)
    {
        return in_array($column->type, ['date']);
    }

    /**
     * Metodo que verifica se a coluna informada e do tipo Datetime
     * @param ColumnSchema $column
     * @return bool
     */
    private function isDateTimeColumn(ColumnSchema $column)
    {
        return in_array($column->type, ['datetime','timestamp']);
    }

    /**
     * Metodo que verifica se o valor da coluna e do formato Brasileiro
     * @param ColumnSchema $column
     * @return bool
     */
    private function isDecimalBRFormat(ColumnSchema $column)
    {
        return (strstr($this->owner->{$column->name}, ',') !== FALSE);
    }

    /**
     * Metodo que verifica se uma data ou um datetime da coluna e do formato Brasileiro
     * @param ColumnSchema $column
     * @return bool
     */
    private function isDateOrDatetimeBRFormat(ColumnSchema $column)
    {
        return (strstr($this->owner->{$column->name}, '/') !== FALSE);
    }
}