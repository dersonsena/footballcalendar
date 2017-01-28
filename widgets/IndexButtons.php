<?php

namespace app\widgets;

class IndexButtons extends ContextButtonsAbstract
{
    private $addButton;

    public $renderAddButton = true;
    public $addButtonVisible = true;
    public $addButtonText;
    public $addButtonIcon;

    public function init()
    {
        $this->addButton = [
            'text' => ($this->addButtonText ? $this->addButtonText : 'Novo Registro'),
            'icon' => ($this->addButtonIcon ? $this->addButtonIcon : 'fa fa-plus-circle'),
            'url' => ["{$this->view->context->id}/create"],
            'visible' => $this->addButtonVisible,
            'options' => [
                'class' => 'btn btn-primary',
                'title' => 'Inserir um novo registro'
            ]
        ];
    }

    public function run()
    {
        if ($this->renderAddButton)
            array_unshift($this->buttons, $this->addButton);

        $this->validateButtons();

        return $this->render('index-buttons', [
            'buttons' => $this->buttons
        ]);
    }
}