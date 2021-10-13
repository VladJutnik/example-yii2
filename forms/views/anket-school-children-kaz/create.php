<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AnketSchoolChildrenKaz */

$this->title = 'Анкета «Характеристика питания и пищевые привычки школьников» (на примере обычного учебного дня)';
$this->params['breadcrumbs'][] = ['label' => 'Anket School Children Kazs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="anket-school-children-kaz-create">

    <h1 align="center"><?= Html::encode($this->title) ?></h1>


    <?= $this->render('_form', [
        'model' => $model,
        'post2' => $post,
    ]) ?>

</div>
