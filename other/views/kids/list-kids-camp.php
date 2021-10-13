<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Добавление медицинской информации по детям';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kids-index">
    <div class="row justify-content-center">
        <div class="col-8">
            <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
            <p>
                <?= Html::a('Перейти в раздел "Добавить ребёнка в отряд"', ['kids-med-create'], ['class' => 'btn main-button-3']) ?>

            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'options' => [
                    'class' => 'menus-table table-responsive'],
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
                        'attribute' => 'date_of_birth',
                        'value' => function ($model) {
                            return date('d.m.Y', $model->date_of_birth);
                        },
                        'headerOptions' => ['class' => 'grid_table_th text-center'],
                        'contentOptions' => ['class' => 'text-center'],
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
                        'headerOptions' => ['class' => 'grid_table_th text-center'],
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view-camp} {kids-update-camp} <div class="mt-1">{create-medical-camp} {delete2} {delete}</div>',
                        'contentOptions' => ['class' => 'action-column text-center'],
                        'buttons' => [
                            'view-camp' => function ($url, $model, $key) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                    'title' => Yii::t('yii', 'Просмотр информации по ребенку'),
                                    'data-toggle' => 'tooltip',
                                    'class' => 'btn btn-sm btn-success'
                                ]);
                            },
                            'kids-update-camp' => function ($url, $model, $key) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => Yii::t('yii', 'Редактировать информацию о ребенке'),
                                    'data-toggle' => 'tooltip',
                                    'class' => 'btn btn-sm btn-primary'
                                ]);
                            },
                            'create-medical-camp' => function ($url, $model, $key) {
                                return Html::a('<span style="color: white" class="glyphicon glyphicon-plus-sign"></span>', $url, [
                                    'title' => Yii::t('yii', 'Добавить медицинскую информацию'),
                                    'data-toggle' => 'tooltip',
                                    'class' => 'btn btn-sm btn-warning'
                                ]);
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
                            'delete' => function ($url, $model, $key) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'title' => Yii::t('yii', 'Удалить ребенка из отряда и все данные по нему'),
                                    'data-toggle' => 'tooltip',
                                    'class' => 'btn btn-sm btn-danger',
                                    'data' => ['confirm' => 'Вы уверены что хотите удалить ребенка?'],
                                ]);
                            },
                        ],
                    ]
                ],
            ]); ?>
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

