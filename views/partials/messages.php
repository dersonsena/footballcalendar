<?php
/* @var \yii\web\View $this  */
/** @var \yii\web\Session $session */
$session = $this->context->getSession();
?>

<?php if($session->hasFlash("success") || $session->hasFlash("error") || $session->hasFlash("warning")) : ?>

    <?php if($session->hasFlash("success")) : ?>

        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4>Sucesso!</h4><?= $session->getFlash("success") ?>
        </div>

    <?php elseif ($session->hasFlash("error")) : ?>

        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4>Erro!</h4><?= $session->getFlash("error") ?>
        </div>

    <?php elseif ($session->hasFlash("warning")) : ?>

        <div class="alert alert-warning" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4>Importante!</h4><?= $session->getFlash("warning") ?>
        </div>

    <?php endif; ?>

<?php endif; ?>