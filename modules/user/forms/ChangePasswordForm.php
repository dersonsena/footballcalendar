<?php

namespace app\modules\user\forms;

use app\modules\user\models\User;
use Exception;
use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{
    public $currentPassword;
    public $newPassword;
    public $repeatPassword;

    public function rules()
    {
        return [
            [['currentPassword', 'newPassword', 'repeatPassword'], 'required'],
            ['repeatPassword', 'compare', 'compareAttribute' => 'newPassword', 'skipOnEmpty' => false],
        ];
    }

    public function attributeLabels()
    {
        return [
            'currentPassword' => 'Sua Senha atual',
            'newPassword' => 'Nova Senha',
            'repeatPassword' => 'Repita sua nova senha'
        ];
    }

    public function changePassword(User $user)
    {
        if ($this->currentPassword === $this->newPassword)
            throw new Exception('Insira uma senha diferente da sua SENHA ATUAL.');

        if (!Yii::$app->security->validatePassword($this->currentPassword, $user->currentPassword))
            throw new Exception('A atual senha de acesso é inválida, por favor, verifique sua senha e tente novamente.');

        $user->password = $this->newPassword;
        $user->repeatPassword = $this->repeatPassword;

        if (!$user->save())
            throw new Exception('Erro ao modificar sua senha. ' . $user->getErrorsToString());

        return true;
    }
}