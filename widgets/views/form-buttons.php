<?php
/** @var array $leftButtons */
/** @var array $leftButtons */
/** @var string $controllerId */

use yii\helpers\Html;

$renderSaveButtons = ($renderSaveButtons ?? true);
?>

<div class="btn-group pull-left">
    <?php foreach ($leftButtons as $button) : ?>
        <?php $icon = (isset($button['icon']) && !empty($button['icon']) ? "<i class='{$button['icon']}'></i>" : '') ?>
        <?= Html::submitButton($icon . ' '. $button['text'], $button['options']) ?>
    <?php endforeach; ?>
</div>

<div class="btn-group pull-right">

    <?= Html::a('<i class="glyphicon glyphicon-list-alt"></i> Listagem de Dados', [$controllerId . '/index'], [
        'class' => 'btn btn-link',
        'title' => 'Voltar para a Listagem de dados desse módulo'
    ]) ?>

    <?= Html::a('<i class="glyphicon glyphicon-chevron-left"></i> Página Anterior', 'javascript:;', [
        'class' => 'btn btn-link',
        'title' => 'Voltar uma página do seu histórico de navegação',
        'onclick' => 'history.back(-1)'
    ]) ?>

</div>