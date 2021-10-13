<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AnketEmploymentChildrenJune */

$this->title = 'Анкета по изучению занятости детей в августе';
$this->params['breadcrumbs'][] = ['label' => 'Anket Employment Children Junes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anket-employment-children-june-create container">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
