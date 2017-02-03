<?php
/* @var yii\web\View $this */
/* @var \app\components\Formatter $formatter */
/* @var array $artillery */
/* @var array $goalsBalance */
/* @var \app\modules\matches\models\Match[] $lastMatches */
use app\models\Setting;
use yii\bootstrap\Html;

$formatter = Yii::$app->formatter;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= Setting::getSettingByAbbreviation('TEAM_NAME')->value ?></h1>
        <p class="lead">Estatísticas gerais até o último jogo. Data <?= $lastMatches[0]->date ?></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-3">
                <h2><i class="fa fa-male"></i> Artilharia</h2>
                <table class="table table-striped table-bordered">
                    <tbody>
                        <?php $position = 1 ?>
                        <?php foreach ($artillery as $row) : ?>
                            <tr>
                                <td  class="text-center" style="width: 30px; font-weight: bold"><?= $position ?>º</td>
                                <td><?= $row['name'] ?></td>
                                <td class="text-center" style="width: 50px"><?= $row['goals'] ?></td>
                            </tr>
                            <?php $position++ ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="col-lg-6">
                <h2><i class="fa fa-calendar"></i> Últimos Resultados</h2>

                <table class="table table-bordered">
                    <tr>
                        <?php foreach ($lastMatches as $match) : ?>
                            <?php
                            if ($match->isVictory()) {
                                $tdBg = '#5cb85c';
                            } else if ($match->isDraw()) {
                                $tdBg = '#fcf8e3';
                            } else {
                                $tdBg = '#d9534f';
                            }
                            ?>
                            <td style="background-color: <?= $tdBg ?>" class="text-center">
                                <?= Html::a($match->getDecisionLabel(true), ['/matches/default/view', 'id' => $match->id], [
                                    'title' => $match->description,
                                ]) ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                </table>

                <table class="table table-striped table-bordered">
                    <tbody>
                        <?php foreach ($lastMatches as $match) : ?>
                            <tr>
                                <td class="text-center" style="width: 110px">
                                    <i class="fa fa-calendar"></i> <?= $match->date ?>
                                </td>
                                <td>
                                    <?= $match->getDecisionLabel(true) ?>
                                    <?= Html::a($match->description, ['/matches/default/view', 'id' => $match->id], [
                                        'title' => 'Ver detalhes do Jogo'
                                    ]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-3">
                <h2><i class="fa fa-futbol-o"></i> Gols</h2>
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td class="text-right">Média de Gols (PRÓ)</td>
                            <td class="text-center" style="width: 50px"><?= $formatter->asDecimal($goalsBalance['avg_owner']) ?></td>
                        </tr>
                        <tr>
                            <td class="text-right">Média de Gols (CONTRA)</td>
                            <td class="text-center" style="width: 50px"><?= $formatter->asDecimal($goalsBalance['avg_guest']) ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                        </tr>
                        <tr class="success">
                            <td class="text-right">Gols Pró</td>
                            <td class="text-center" style="width: 50px"><?= $goalsBalance['sum_owner'] ?></td>
                        </tr>
                        <tr class="danger">
                            <td class="text-right">Gols Contra</td>
                            <td class="text-center" style="width: 50px"><?= $goalsBalance['sum_guest'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Saldo de Gols</strong></td>
                            <td class="text-center" style="width: 50px">
                                <strong><?= $goalsBalance['balance'] ?></strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
