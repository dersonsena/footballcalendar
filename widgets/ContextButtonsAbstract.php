<?php

namespace app\widgets;

use yii\base\ErrorException;
use yii\base\Widget;

abstract class ContextButtonsAbstract extends Widget
{
    public $buttons = [];

    protected function validateButtons()
    {
        foreach ($this->buttons as $i => $button) {

            if (!array_key_exists('url', $button))
                throw new ErrorException('Não foi informado a URL para o botão.');

            if (array_key_exists('visible', $button) && $button['visible'] === false)
                unset($this->buttons[$i]);
        }
    }
}