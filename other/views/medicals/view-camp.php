<?php

use common\models\Medicals;
use common\models\ThermometryCamp;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Kids */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Kids', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="kids-view-camp">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?php
        if (Yii::$app->user->can('school_director'))
        { ?>
            <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php } ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'unique_number',
            'lastname',
            'name',
            [
                'attribute' => 'sex',
                'value' => function ($model) {
                    if ($model->sex == 1)
                    {
                        return 'Мужской';
                    }
                    else
                    {
                        return 'Женский';
                    }
                },
            ],
            [
                'attribute' => 'date_of_birth',
                'value' => function ($model) {
                    return date('d.m.Y', $model->date_of_birth);
                },
            ],
            [
                'attribute' => 'federal_district_id',
                'value' => function ($model) {
                    return $model->get_district_id($model->federal_district_id);
                },
            ],
            [
                'attribute' => 'region_id',
                'value' => function ($model) {
                    return $model->get_region_id($model->region_id);
                },
            ],
            'change_camp',
            'group_camp',
            //'organization_id',
            //'created_at',
        ],
    ]) ?>
    <br>
    <? if (Yii::$app->user->can('camp_director')) { ?>
        <div class="row">
            <div class="col-9"><h2>Медицинская информация</h2></div>
            <div class="col-3"><?= Html::a('Добавить медицинскую информацию', ['create-medical-camp', 'id' => $model->id], ['class' => 'form-control btn btn-success']) ?></div>
        </div>
    <? } ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'class' => 'menus-table table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['class' => 'grid_table_th'],
            ],
            //'id',
            //'kids_id',
            [
                'attribute' => 'body_length',
                'value' => 'body_length',
                'headerOptions' => ['class' => 'grid_table_th text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'body_weight',
                'value' => 'body_weight',
                'headerOptions' => ['class' => 'grid_table_th text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'capacity_lungs',
                'value' => 'capacity_lungs',
                'headerOptions' => ['class' => 'grid_table_th text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'left_hand',
                'value' => 'left_hand',
                'headerOptions' => ['class' => 'grid_table_th text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'right_hand',
                'value' => 'right_hand',
                'headerOptions' => ['class' => 'grid_table_th text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            //'bmi',
            //'physical_evolution',
            //'health_group',
            //'physical_group_id',
            //'flat_feet:ntext',
            [
                'attribute' => 'date',
                'value' => function ($model) {
                    return date('d.m.Y', $model->date);
                },

            ],
            /*[
                'attribute' => 'date',
                'value' => 'date',
                'headerOptions' => ['class' => 'grid_table_th text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],*/
            //'created_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view-medical} {medical-update} {delete-medical}',
                'contentOptions' => ['class' => 'action-column '],
                'buttons' => [
                    'view-medical' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('yii', 'Просмотр'),
                            'data-toggle' => 'tooltip',
                            'class' => 'btn btn-sm btn-success'
                        ]);
                    },
                    'medical-update' => function ($url, $model, $key) {
                        if (Yii::$app->user->can('camp_director'))
                        {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('yii', 'Редактировать'),
                                'data-toggle' => 'tooltip',
                                'class' => 'btn btn-sm btn-primary'
                            ]);
                        }
                    },
                    'delete-medical' => function ($url, $model, $key) {
                        if (Yii::$app->user->can('camp_director'))
                        {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('yii', 'Удалить'),
                                'data-toggle' => 'tooltip',
                                'class' => 'btn btn-sm btn-danger',
                                'data' => ['confirm' => 'Вы уверены что хотите удалить медицинский осмотр?'],
                            ]);
                        }
                    },
                ],
            ]
        ],
    ]); ?>
    <br><br>
    <? if (!empty($fact_camp)) { ?>
        <?= Html::a('Выставить нормальную температуру', ['automatic-temperature-one?id=' . $model->id], ['class' => 'btn main-color-5 btn-block mb-3']) ?>
        <h5 class="text-center">График температуры</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
            <thead>
            <tr>
                <th class="text-center" rowspan="1" colspan="1">N п/п</th>
                <th class="text-center" rowspan="1" colspan="1">Дата измерения</th>
                <th class="text-center" rowspan="1" colspan="1">Утро</th>
                <th class="text-center" rowspan="1" colspan="1">Вечер</th>
                <th class="text-center" rowspan="1" colspan="1">Редактировать</th>
            </tr>
            </thead>
            <tbody>
            <? $num = 1;

           /* $reg_date = $fact_camp['start_date'];
            $date_fact_camp = array();

            while (date("d.m.Y",$reg_date) >= date("d.m.Y",$fact_camp['start_date']) && date("d.m.Y",$reg_date) <= date("d.m.Y",$fact_camp['start_date']))
            {
                array_push($date_fact_camp, $reg_date);
                $reg_date = date("d.m.Y", strtotime("+1 days", strtotime($reg_date)));
            }*/
            $begin = $fact_camp['start_date']; //Начальная дата из БД
            $end = $fact_camp['expiry_date']; //Конечная дата из БД

            $datetime1 = date_create($begin);
            $datetime2 = date_create($end);
            $interval = date_diff($datetime1, $datetime2);
            $diff = $interval->format('%d');

            $date_fact_camp = array();
            for($i = 0; $i < $diff; $i++){
                $date_fact_camp[] = date("d.m.Y", strtotime("$begin +$i day"));
            }
            foreach ($date_fact_camp as $date):
                $date_sql = date("Y-m-d", strtotime($date));
                $model_save = ThermometryCamp::find()->where(['kids_id' => $model->id])->andwhere(['=', 'STR_TO_DATE(`date_surveys`, \'%d.%m.%Y\')', $date_sql])->one();
                if (!empty($model_save))
                {
                    ?>
                    <tr>
                        <td class="text-center"><?= $num ?></td>
                        <td class="text-center"><?= $date ?></td>
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
                        <td class="text-center"><?=
                            Html::button('<span class="glyphicon glyphicon-check"></span>', [
                                'data_id' => $model->id,
                                'data_day' => $date,
                                'title' => Yii::t('yii', 'Внести данные по температуре'),
                                'class' => 'btn btn-sm btn-info',
                                'onclick' => '
                                //$.get("/medicals/thermometry-camp?id=" + $(this).attr("data_id")+"&data=" + $(this).attr("data_day")+"&list=" + $(this).attr("data_way"), function(data){
                                $.get("/medicals/thermometry-camp?id=" + $(this).attr("data_id")+"&data=" + $(this).attr("data_day"), function(data){
                                //$.get("/medicals/thermometry-camp?id=" + $(this).attr("data_id"), function(data){
                                $("#showModal .modal-body").empty();
                                $("#showModal .modal-body").append(data);
                                //console.log(data);
                                $("#showModal").modal("show");
                        });']); ?></td>
                    </tr>
                <? } else {
                    ?>
                    <tr>
                        <td class="text-center"><?= $num ?></td>
                        <td class="text-center"><?= $date ?></td>
                        <td></td>
                        <td></td>
                        <td class="text-center"><?=
                            Html::button('<span class="glyphicon glyphicon-check"></span>', [
                                'data_id' => $model->id,
                                'data_day' => $date,
                                'title' => Yii::t('yii', 'Внести данные по температуре'),
                                'class' => 'btn btn-sm btn-info',
                                'onclick' => '
                                //$.get("/medicals/thermometry-camp?id=" + $(this).attr("data_id")+"&data=" + $(this).attr("data_day")+"&list=" + $(this).attr("data_way"), function(data){
                                $.get("/medicals/thermometry-camp?id=" + $(this).attr("data_id")+"&data=" + $(this).attr("data_day"), function(data){
                                //$.get("/medicals/thermometry-camp?id=" + $(this).attr("data_id"), function(data){
                                $("#showModal .modal-body").empty();
                                $("#showModal .modal-body").append(data);
                                //console.log(data);
                                $("#showModal").modal("show");
                        });']); ?></td>
                    </tr>
                <? } ?>

                <? $num++;endforeach; ?>
            </tbody>
        </table>
        </div>
    <? } ?>
    <!--МОДАЛЬНОЕ ОКНО-->
    <div id="showModal" class="modal fade">
        <div class="modal-dialog modal-lg" style="">
            <div class="modal-content">
                <div class="modal-header-p3">
                    <h4 class="modal-title">Добавление сведений по температуре</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">

                </div>
            </div>
        </div>
    </div>
