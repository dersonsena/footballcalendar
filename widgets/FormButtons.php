<?php

namespace app\widgets;

class FormButtons extends ContextButtonsAbstract
{
    public $rightButtons = [];
    public $leftButtons = [];

    public $saveButton;
    public $saveAndContinueButton;
    public $renderSaveButton = true;
    public $renderAndContinueSaveButton = true;

    public function init()
    {
        $this->saveButton = [
            'text' => 'Salvar',
            'icon' => 'glyphicon glyphicon-floppy-saved white',
            'url' => null,
            'options' => [
                'id' => 'btn-save',
                'class' => 'btn btn-primary',
                'title' => 'Clique aqui para salvar o registro'
            ]
        ];

        $this->saveAndContinueButton = [
            'text' => 'Salvar e Permanecer Aqui',
            'icon' => 'glyphicon glyphicon-floppy-saved white',
            'url' => null,
            'options' => [
                'id' => 'btn-save-and-continue',
                'name' => 'save-and-continue',
                'class' => 'btn btn-default',
                'title' => 'Clique aqui para salvar o registro e permanecer nesta tela'
            ]
        ];
    }

    public function run()
    {
        if ($this->renderAndContinueSaveButton)
            array_unshift($this->leftButtons, $this->saveAndContinueButton);

        if ($this->renderSaveButton)
            array_unshift($this->leftButtons, $this->saveButton);

        $this->validateButtons();

        return $this->render('form-buttons', [
            'leftButtons' => $this->leftButtons,
            'rightButtons' => $this->rightButtons,
            'controllerId' => $this->view->context->id
        ]);
    }
}