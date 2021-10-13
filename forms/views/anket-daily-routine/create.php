<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AnketDailyRoutine */

$this->title = 'Анкета «Режим дня, организация досуга»';
$this->params['breadcrumbs'][] = ['label' => 'Anket Daily Routines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anket-daily-routine-create">

    <h1 align="center"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
