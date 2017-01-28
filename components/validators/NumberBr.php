<?php

namespace app\components\validators;

use yii\validators\NumberValidator;

class NumberBr extends NumberValidator
{
    public $numberPattern = '/^-?(?:[0-9]{1,3})(?:.[0-9]{3})*(?:|\,[0-9]+)$/';
}