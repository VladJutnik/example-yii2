<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AnketParentsSchoolChildren */

$this->title = 'Заполнение анкеты родителей школьников';
$this->params['breadcrumbs'][] = ['label' => 'Anket Parents School Childrens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anket-parents-school-children-create">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
