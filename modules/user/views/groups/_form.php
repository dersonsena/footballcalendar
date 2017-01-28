<?php
/* @var yii\web\View $this */
/* @var \backend\modules\user\models\Group $model */
/* @var array $permissions */
/* @var ActiveForm $form */
use backend\modules\user\assets\GroupsFormAsset;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

GroupsFormAsset::register($this);

$authManager = Yii::$app->authManager;
?>

<?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->hiddenInput() ?>

    <div class="box form-actions">
        <div class="box-body">
            <?= $this->render('@backend/views/partials/crud/form-default-buttons') ?>
        </div>
    </div>

    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title">Dados do Grupo de Usuário</h3>
        </div>

        <div class="box-body">

            <div class="row">

                <div class="col-md-4">
                    <?= $form->field($model, 'name') ?>
                </div>

            </div>

            <?= $form->field($model, 'status')->checkbox() ?>

        </div>

    </div>

    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title">Permissões de Acesso</h3>
        </div>

        <div class="box-body">

            <div class="row">
                <div class="btn-group col-md-12">
                    <?= Html::button(Html::icon('check') . ' Marcar todos', [
                        'class' => 'btn btn-default',
                        'data-toggle' => "tooltip",
                        'title' => 'Marcar todas as Permissões',
                        'onclick' => 'checkAll(true)'
                    ]) ?>
                    <?= Html::button(Html::icon('unchecked') . ' Desmarcar todos', [
                        'class' => 'btn btn-default',
                        'data-toggle' => "tooltip",
                        'title' => 'Desmarcar todas as Permissões',
                        'onclick' => 'checkAll(false)'
                    ]) ?>
                </div>
            </div>

            <?php if (!empty($permissions)) : ?>

                <?php foreach ($permissions as $name => $parentData) : ?>

                    <?php $childElementId = str_replace('.', '-', $name) ?>

                    <div class="checkbox">
                        <label>
                            <?php
                            $checked = (!$model->isNewRecord && $authManager->hasChild($authManager->getRole($model->id), $authManager->getPermission($name)));
                            ?>
                            <?= Html::checkbox('permissions[]', $checked, [
                                'id' => $name,
                                'value' => $name,
                                'class' => 'permissions',
                                'onclick' => 'checkAllChilds(this)'
                            ]) ?>
                            <span class="text-bold" style="font-size: 18px">
                            <?= Html::icon('chevron-right') ?>
                            <?= $parentData['description'] ?>
                        </span>
                        </label>
                    </div>

                    <div id="childs-<?= $childElementId ?>" class="childs" style="margin-bottom: 20px">
                        <?php foreach ($parentData['childs'] as $childName => $permission) : ?>
                            <div class="checkbox">
                                <label>
                                    <?php
                                    $checked = (!$model->isNewRecord && $authManager->hasChild($authManager->getRole($model->id), $authManager->getPermission($childName)));

                                    echo Html::checkbox('permissions[]', $checked, [
                                        'id' => $childName,
                                        'value' => $childName,
                                        'class' => 'permissions',
                                        'onclick' => 'checkChild(this, "'. $name .'")'
                                    ]) ?>
                                    <?= $permission->description ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                <?php endforeach; ?>

            <?php else : ?>
                <p class="text-center">Nenhuma permissão cadastrada.</p>
            <?php endif; ?>

        </div>

    </div>

<?php ActiveForm::end() ?>