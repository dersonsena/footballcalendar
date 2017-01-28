<?php
/** @var array $buttons */
use yii\bootstrap\Html;
?>

<div class="btn-group">
    <?php foreach ($buttons as $button) : ?>
        <?php $icon = (isset($button['icon']) && !empty($button['icon']) ? "<i class='{$button['icon']}'></i>" : '') ?>
        <?= Html::a($icon . ' ' . $button['text'], $button['url'], $button['options']) ?>
    <?php endforeach; ?>
</div>