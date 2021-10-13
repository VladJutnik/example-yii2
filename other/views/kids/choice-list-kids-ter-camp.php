<?php

use common\models\ThermometryCamp;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Термометрия детей по отрядам';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin();
    $params = [
        'class' => 'form-control col-9', 'prompt' => '',
    ];
    $year_items = [
        '2020' => '2020',
        '2021' => '2021'
    ];
    $season_items = [
        '0' => 'Зима',
        '1' => 'Весна',
        '2' => 'Лето',
        '3' => 'Осень',
    ];
    $change_camp_items = [
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
        '11' => '11',
        '12' => '12',
        '13' => '13',
        '14' => '14',
        '15' => '15',
        '16' => '16',
        '17' => '17',
        '18' => '18',
        '19' => '19',
        '20' => '20',
    ];
    $group_camp_items = [
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
        '11' => '11',
        '12' => '12',
        '13' => '13',
        '14' => '14',
        '15' => '15',
        '16' => '16',
        '17' => '17',
        '18' => '18',
        '19' => '19',
        '20' => '20',
        '21' => '21',
        '22' => '22',
        '23' => '23',
        '24' => '24',
        '25' => '25',
        '26' => '26',
        '27' => '27',
        '28' => '28',
        '29' => '29',
        '30' => '30',
        '31' => '31',
        '32' => '32',
        '33' => '33',
        '34' => '34',
        '35' => '35',
        '36' => '36',
        '37' => '37',
        '38' => '38',
        '39' => '39',
        '40' => '40',
    ];
    ?>

    <?php
    $two_column = ['options' => ['class' => 'row mt-3'], 'labelOptions' => ['class' => 'col-3 col-form-label font-weight-bold']];

    $two_column2 = ['options' => ['class' => 'row mt-3'], 'labelOptions' => ['class' => 'col-3 col-form-label font-weight-bold']];

    if (empty($year) && empty($season) && empty($change_camp) && empty($group_camp))
    {
        if(empty($_SESSION['year']) && empty($_SESSION['season']) && empty($_SESSION['change_camp']) && empty($_SESSION['group_camp'])){
            $year = 2021;
            $season = 2;
            $change_camp = 1;
            $group_camp = 1;
        }else{
            $year = $_SESSION['year'];
            $season = $_SESSION['season'];
            $change_camp = $_SESSION['change_camp'];
            $group_camp = $_SESSION['group_camp'];
        }
    }
    ?>

    <?= $form->field($model2, 'year', $two_column)->dropDownList($year_items,
        [
            'options' => [$year => ['Selected' => true]],
            'class' => 'form-control col-9'
        ])->label('Год') ?>

    <?= $form->field($model2, 'season', $two_column)->dropDownList($season_items,
        [
            'options' => [$season => ['Selected' => true]],
            'class' => 'form-control col-9'
        ])->label('Сезон') ?>

    <?= $form->field($model2, 'change_camp', $two_column)->dropDownList($change_camp_items,
        [
            'options' => [$change_camp => ['Selected' => true]],
            'class' => 'form-control col-9'
        ])->label('Смена') ?>

    <?= $form->field($model2, 'group_camp', $two_column)->dropDownList($group_camp_items,
        [
            'options' => [$group_camp => ['Selected' => true]],
            'class' => 'form-control col-9'
        ])->label('Отряд') ?>

    <div class="form-group row">
        <?= Html::submitButton('Показать', ['name' => 'identificator', 'value' => 'show', 'class' => 'btn main-button-3 form-control mt-3 col-12']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

    <div class="container-fluid">
            <br>
           <?if($status == 1){?>
                <?if(!empty($fact_camp)){
                    if(!empty($kidss)){
                        $post_ter = implode("|",$post);
                        if(Yii::$app->user->can('camp_director')){?>
                            <?= Html::a('Выставить всем детям нормальную температуру', ['automatic-temperature-all?post='.$post_ter], ['class' => 'btn ml-5 btn-outline-danger']) ?>
                        <?}
                        $begin = $fact_camp['start_date']; //Начальная дата из БД
                        $end = $fact_camp['expiry_date']; //Конечная дата из БД
                        $datetime1 = date_create($begin);
                        $datetime2 = date_create($end);
                        $interval = date_diff($datetime1, $datetime2);
                        $diff = $interval->format('%d');
                        $date_fact_camp = array();
                        for($i = 0; $i <= $diff; $i++){
                            $date_fact_camp[] = date("d.m.Y", strtotime("$begin +$i day"));
                        }
                        $num = 1;?>
                        <h5 class="text-center">График температуры для отряда - <b><?=$group_camp?></b></h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                <tr>
                                    <th class="text-center" rowspan="2" colspan="1">N п/п</th>
                                    <th class="text-center" rowspan="2" colspan="1">ФИО</th>
                                    <? foreach ($date_fact_camp as $date):?>
                                        <th class="text-center" rowspan="1" colspan="2"><?=$date?></th>
                                    <?endforeach;?>
                                </tr>
                                <tr>
                                    <? foreach ($date_fact_camp as $date):?>
                                        <th class="text-center" rowspan="1" colspan="1">Утро</th>
                                        <th class="text-center" rowspan="1" colspan="1">Вечер</th>
                                    <?endforeach;?>
                                </tr>
                                </thead>
                                <tbody>
                                    <?foreach ($kidss as $kids):?>
                                        <tr>
                                            <td class="text-center" rowspan="1" colspan="1"><?= $num ?></td>
                                            <td class="text-center" rowspan="1" colspan="1"><?= $kids->lastname.' '. $kids->name?></td>
                                        <?
                                        foreach ($date_fact_camp as $date):
                                            $date_sql = date("Y-m-d", strtotime($date));
                                            $model_save = ThermometryCamp::find()->where(['kids_id' => $kids->id])->andwhere(['=', 'STR_TO_DATE(`date_surveys`, \'%d.%m.%Y\')', $date_sql])->one();
                                            if (!empty($model_save)){?>
                                                <? if ($model_save->normal_temperature_morning == '1') {
                                                    ?>
                                                    <td class="text-center" style="background: #9fe77d">норма</td>
                                                <? } else {
                                                    ?>
                                                    <td class="text-center"
                                                        style="background: #efe3b3"><?= $model_save['no_normal_temperature_morning'] ?></td>
                                                <? } ?>
                                                <? if ($model_save->normal_temperature_evening == '1') {
                                                    ?>
                                                    <td class="text-center" style="background: #9fe77d">норма</td>
                                                <? } else {
                                                    ?>
                                                    <td class="text-center"
                                                        style="background: #efe3b3"><?= $model_save->no_normal_evening ?></td>
                                                <? } ?>
                                            <?}else{?>
                                                <td class="text-center" rowspan="1" colspan="1">-</td>
                                                <td class="text-center" rowspan="1" colspan="1">-</td>
                                            <?}?>
                                        <?endforeach;$num++;?>
                                        </tr>
                                    <?endforeach;?>
                                </tbody>
                                </table>

                        </div>
                    <?}
                    else{?>
                        <div class="alert alert-danger" role="alert">
                            У организации не внесены дети, по выбранным параметрам!
                        </div>
                    <?}
               }else{?>
                   <div class="alert alert-warning" role="alert">
                       У организации не заполнены фактические данные, по выбранным параметрам!
                   </div>
               <?}?>
           <?}?>

    </div>
