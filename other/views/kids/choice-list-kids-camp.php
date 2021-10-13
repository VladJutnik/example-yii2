<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список детей по отрядам';
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

    <?php ActiveForm::end();
        //print_r(Yii::$app->session['test']);
    ?>
    <div class="row justify-content-center">
        <div class="col-12">
    <br>
    <?php if (!empty($dataProvider))
    {
    ?>
    <?php if (!Yii::$app->user->can('rospotrebnadzor_camp')) { ?>
    <? } ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'options' => [
                    'class' => 'menus-table table-responsive'],
                'rowOptions' => ['class' => 'grid_table_tr'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['class' => 'grid_table_th'],
                    ],
                    //'id',
                    //'unique_number',
                    [
                        'attribute' => 'lastname',
                        'value' => 'lastname',
                        'headerOptions' => ['class' => 'grid_table_th text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'name',
                        'value' => 'name',
                        'headerOptions' => ['class' => 'grid_table_th text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'sex',
                        'value' => function ($model) {
                            return $model->get_sex($model->sex);
                        },
                        'headerOptions' => ['class' => 'grid_table_th text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'date_of_birth',
                        'value' => function ($model) {
                            return date('d.m.Y',$model->date_of_birth);
                        },

                    ],
                    [
                        'attribute' => 'change_camp',
                        'value' => 'change_camp',
                        'headerOptions' => ['class' => 'grid_table_th text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'group_camp',
                        'value' => 'group_camp',
                        'headerOptions' => ['class' => 'grid_table_th text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'value' => function ($model) {
                            return $model->get_health_group($model->id);
                        },
                        'label' => 'Группы здоровья',
                        'headerOptions' => ['class' => 'grid_table_th text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    //'month_birth',
                    //'federal_district_id',
                    //'region_id',
                    //'class_number',
                    //'class_letter',
                    //'organization_id',
                    //'created_at',

                    [
                        'header' => 'Просмотр, редактирование, добавление мед информации, добавление информации по температуры, удаление данных для ребенка',
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view-camp} {kids-update-camp} <div class="mt-1">{create-medical-camp} {delete2} {delete}</div>',
                        'headerOptions' => ['class' => 'grid_table_th text-center'],
                        'contentOptions' => ['class' => 'action-column text-center'],
                        'buttons' => [
                            'view-camp' => function ($url, $model, $key) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                    'title' => Yii::t('yii', 'Просмотр'),
                                    'data-toggle' => 'tooltip',
                                    'class' => 'btn btn-sm btn-success'
                                ]);
                            },
                            'create-medical-camp' => function ($url, $model, $key) {
                                if(Yii::$app->user->can('camp_director'))
                                {
                                    return Html::a('<span style="color: white" class="glyphicon glyphicon-plus-sign"></span>', $url, [
                                        'title' => Yii::t('yii', 'Добавить медицинскую информацию'),
                                        'data-toggle' => 'tooltip',
                                        'class' => 'btn btn-sm btn-warning'
                                    ]);
                                }
                            },
                            'delete2' => function ($url, $model, $key) {
                                if(Yii::$app->user->can('camp_director'))
                                {
                                    return  Html::button('<span class="glyphicon glyphicon-check"></span> ', [
                                        'title' => Yii::t('yii', 'Внести данные по температуре'),
                                        'data-toggle' => 'tooltip',
                                        'class' => 'btn btn-sm main-button-edit',
                                        "onclick" => "editData('$model->id')"
                                    ]);
                                }
                            },
                            'kids-update-camp' => function ($url, $model, $key) {
                                if(Yii::$app->user->can('camp_director'))
                                {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('yii', 'Редактировать'),
                                        'data-toggle' => 'tooltip',
                                        'class' => 'btn btn-sm btn-primary'
                                    ]);
                                }
                            },
                            'delete' => function ($url, $model, $key) {
                                if(Yii::$app->user->can('camp_director'))
                                {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                        'title' => Yii::t('yii', 'Удалить'),
                                        'data-toggle' => 'tooltip',
                                        'class' => 'btn btn-sm btn-danger',
                                        'data' => ['confirm' => 'Вы уверены что хотите удалить ребенка?'],
                                    ]);
                                }
                            },
                        ],
                    ]
                ],
            ]); ?>
    <? } ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function editData(id) {
        $('#editData').find('input#kids').val(id);
        $('#editData').modal('show');
    }
</script>

<!--МОДАЛЬНОЕ ОКНО ДЛЯ РЕДАКТИРОВАНИЯ БЛЮДА-->
<div id="editData" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header-p3">
                <h4 class="modal-title">Добавление сведений по температуре</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-3">
                <div class="row">
                    <?$today = date('Y-m-d');?>
                    <?= Html::hiddenInput('kids', '', ['id' => 'kids', 'class' => 'form-control']); ?>
                    <div class="col-6">
                        <b>Дата замера</b>
                    </div>
                    <div class="col-6">
                        <?= Html::textInput('date_surveys',$today, ['type' => 'date', 'class' => 'form-control date_surveys']); ?>
                    </div>
                    <div class="col-12 mt-2 text-center">
                        <label><input type="checkbox" id="normal_temperature_morning" onclick = "deleteData()"/> <b>УТРО: нормальная температура ниже 37.1</b></label>
                    </div>
                    <div class="col-6 morning-text">
                        <b>УТРО: Температура выше 37.1</b>
                    </div>
                    <div class="col-6 morning-input">
                        <?= Html::textInput('no_normal_temperature_morning', '', ['type'=>"number", 'step'=>"0.1", 'min'=>"37.2", 'max'=>"41.2", 'placeholder'=>"37.2", 'class' => 'form-control no_normal_temperature_morning']); ?>
                    </div>
                    <div class="col-12 mt-2 text-center">
                        <label><input type="checkbox" id="normal_temperature_evening" onclick = "deleteData2()"/> <b>ВЕЧЕР: нормальная температура ниже 37.1</b></label>
                    </div>
                    <div class="col-6 evening-text">
                        <b>ВЕЧЕР: Температура выше 37.1</b>
                    </div>
                    <div class="col-6 evening-input">
                        <?= Html::textInput('no_normal_evening', '', ['type'=>"number", 'step'=>"0.1", 'min'=>"37.2", 'max'=>"41.2", 'placeholder'=>"37.2", 'class' => 'form-control no_normal_evening']); ?>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn main-button-delete" data-dismiss="modal">Отмена</button>

                    <?= Html::submitButton('Сохранить', ['class' => 'btn main-button-3 pull-right', 'onclick' => 'updateData()']); ?>
                </div>

            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    function deleteData() {
        var additional_examination = $('#normal_temperature_morning');
        if ((additional_examination.prop('checked')) === true)
        {
            $('.morning-text').hide();
            $('.morning-input').hide();
        }
        else
        {
            $('.morning-text').show();
            $('.morning-input').show();
        }
    }
    function deleteData2() {
        var additional_examination = $('#normal_temperature_evening');
        if ((additional_examination.prop('checked')) === true)
        {
            $('.evening-text').hide();
            $('.evening-input').hide();
        }
        else
        {
            $('.evening-text').show();
            $('.evening-input').show();
        }
    }
</script>

<script type="text/javascript">
    function updateData() {
        /*console.log('ok');
        $('#editData').find('input.Data_id').val();
        $('#editData').find('input.yield').val();
        $('#editData').find('input.nutrition').val();*/
        //console.log($('#editData').find('input.nutrition').val());
        var data = {};
        //СОБИРАЕМ ДАННЫЕ ИЗ ФОРМ
        data.kids_id = $('#editData').find('input#kids').val();
        //data.Data_id = $('#editData').find('input.Data_id').val();
        data.date_surveys = $('#editData').find('input.date_surveys').val();
        if ($('#editData').find('input#normal_temperature_morning').prop("checked")){
            data.normal_temperature_morning = 1;
        }else{
            data.normal_temperature_morning = 0;
        }
        data.no_normal_temperature_morning = $('#editData').find('input.no_normal_temperature_morning').val();
        if ($('#editData').find('input#normal_temperature_evening').prop("checked")){
            data.normal_temperature_evening = 1;
        }else{
            data.normal_temperature_evening = 0;
        }
        data.no_normal_evening = $('#editData').find('input.no_normal_evening').val();

        console.log(data);
        $.ajax({
            url: 'updating',
            data: data,
            method: 'POST',
            dataType: 'JSON',
            success: function (data) {
                if (data) {
                    console.log(data)
                    $('#editData').find('input#normal_temperature_morning').prop('checked', false);
                    $('#editData').find('input.no_normal_temperature_morning').val('');
                    $('.evening-text').show();
                    $('.evening-input').show();
                    $('.morning-text').show();
                    $('.morning-input').show();
                    $('#editData').find('input#normal_temperature_evening').prop('checked', false);
                    $('#editData').find('input.no_normal_evening').val('');
                }
            },
            error: function (err) {
                console.log('error')
            }
        });
        $('#editData').modal('toggle');
    }
</script>
