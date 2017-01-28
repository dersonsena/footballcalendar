<?php
/* @var $this \yii\web\View */
/* @var $content string */
/** @var \yii\web\User $user */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\StringHelper;
use yii\web\ErrorAction;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$user = Yii::$app->user;

$navItems = [
    ['label' => '<i class="fa fa-tachometer"></i> Estatísticas', 'url' => ['/site/index'], 'encode' => false],
    ['label' => '<i class="fa fa-sign-in"></i> Login', 'url' => ['/site/login'], 'encode' => false]
];

if (!$user->isGuest) {
    array_pop($navItems);

    $navItems = ArrayHelper::merge($navItems, [
        ['label' => 'Cadastros', 'items' => [
            ['label' => "<i class='fa fa-male'></i> Atletas", 'url' => ['/entries/players'], 'encode' => false],
            ['label' => "<i class='fa fa-flag-checkered'></i> Competições", 'url' => ['/entries/competitions'], 'encode' => false],
            ['label' => "<i class='fa fa-home'></i> Ginásios", 'url' => ['/entries/places'], 'encode' => false],
            ['label' => "<i class='fa fa-futbol-o'></i> Times", 'url' => ['/entries/teams'], 'encode' => false],
        ]],
        ['label' => 'Sistema', 'items' => [
            ['label' => "<i class='fa fa-user'></i> Usuários", 'url' => ['/user/default'], 'encode' => false],
            ['label' => "<i class='fa fa-cog'></i> Configurações", 'url' => ['/app/settings'], 'encode' => false],
        ]],
        ['label' => "<i class='fa fa-sign-out'></i> Sair (". StringHelper::truncateWords(Yii::$app->user->identity->name, 1, '...') .")", 'url' => ['/site/logout'], 'encode' => false]
    ]);
}

$this->title = $this->context->controllerDescription . ' | ' . Yii::$app->name;

if ($this->context->action instanceof ErrorAction)
    $this->title = 'Erro da Aplicação | ' . Yii::$app->name;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?= $this->render('//partials/growl-messages.php') ?>

<div class="wrap">
    <?php NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]) ?>
        <?= Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $navItems,
        ]) ?>
    <?php NavBar::end() ?>

    <div class="container">
        <?= $this->render('//partials/messages.php') ?>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Kilderson Sena <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
