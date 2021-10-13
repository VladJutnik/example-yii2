<?php

use common\models\FederalDistrict;
use common\models\Region;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model common\models\AnketEmploymentChildrenJune */
    /* @var $form yii\widgets\ActiveForm */

    $district_null = array('' => 'Выберите федеральный округ ...');
    $districs = FederalDistrict::find()->all();
    $district_items = ArrayHelper::map($districs, 'id', 'name');
    $district_items = ArrayHelper::merge($district_null, $district_items);

    $region_null = array('' => 'Выберите регион ...');
    $regions = Region::find()->where(['district_id' => 5])->all();
    $region_items = ArrayHelper::map($regions, 'id', 'name');
    $region_items = ArrayHelper::merge($region_null, $region_items);


    $municipality_null = array('' => 'Выберите муниципальное образование...');
    $municipalities = \common\models\Municipality::find()->where(['region_id' => 48])->all();
    $municipality_items = ArrayHelper::map($municipalities, 'id', 'name');

    $two_column_name = ['options' => ['class' => 'row mt-2 mb-0 ml-0 mr-0'], 'labelOptions' => ['class' => 'col-sm-12 col-md-12 col-lg-6 col-xl-6 col-form-label font-weight-bold']];
    $two_column_input = ['class' => 'form-control col-sm-12 col-md-12 col-lg-6 col-xl-6'];

?>

    <style>
        .help-block{
            color: #dc0a27;
            margin: 11px auto;
            text-align: center;
        }
    </style>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'federal_district_id', $two_column_name)
        ->dropDownList($district_items, [
            'class' => 'form-control col-sm-12 col-md-12 col-lg-6 col-xl-6',
            'options' => [5 => ['Selected' => true]],
            'onchange' => '
                  $.get("../anket-school-children-kaz/subjectslist?id="+$(this).val(), function(data){
                  //$("#anketemploymentchildrenjune-region_id").prop("disabled", true);
                  
                    $("select#anketemploymentchildrenjune-region_id").html(data);
                    //$("select#anketemploymentchildrenjune-region_id").html("");
                    
                    //document.getElementById("anketemploymentchildrenjune-region_id").disabled = false;
                  });
                  
                  $.get("../anket-school-children-kaz/municipalitylist?id=0", function(data){
                    $("select#anketemploymentchildrenjune-municipality_id").html(data);
                    //document.getElementById("anketemploymentchildrenjune-municipality_id").disabled = false;
                    });'
        ]); ?>
    <?= $form->field($model, 'region_id', $two_column_name)
        ->dropDownList($region_items, [
            'class' => 'form-control col-sm-12 col-md-12 col-lg-6 col-xl-6',
            'options' => [48 => ['Selected' => true]],
            'onchange' => '
                  $.get("../anket-school-children-kaz/municipalitylist?id="+$(this).val(), function(data){
                    $("select#anketemploymentchildrenjune-municipality_id").html(data);
                    document.getElementById("anketemploymentchildrenjune-municipality_id").disabled = false;
                  });'
        ]); ?>
    <?= $form->field($model, 'municipality_id', $two_column_name)->dropDownList($municipality_items, [
        'prompt' => 'Выберите муниципальное образование...',
        'class' => 'form-control col-sm-12 col-md-12 col-lg-6 col-xl-6',
        'options' => [253 => ['Selected' => true]],
    ]); ?>
    <?
        $items=['' => '',
          '7-10 лет' => '7-10 лет',
          '11-15 лет' => '11-15 лет',
          '16 -17 лет' => '16 -17 лет',
        ];
    ?>
    <?= $form->field($model, 'age', $two_column_name)->dropDownList($items, $two_column_input) ?>
    <?
        $items=[
            '' => '',
            'да' => 'да',
            'нет' => 'нет',
        ];
    ?>
    <h5 class="ml-3 mt-2 mb-2">Укажите чем Вы занимались в августе:</h5>
    <?= $form->field($model, 'field1', $two_column_name)->dropDownList($items, $two_column_input) ?>
    <div class="show">

        <?
            $items=[
                '' => '',
                'с родителями ' => 'с родителями ',
                'с родственниками' => 'с родственниками',
                'с законными представителями' => 'с законными представителями',
                'с друзьями' => 'с друзьями',
                'не уезжал' => 'не уезжал',
            ];
        ?>
        <?= $form->field($model, 'field2', $two_column_name)->dropDownList($items, $two_column_input) ?>
        <?
            $items=[
                '' => '',
                'да' => 'да',
                'нет' => 'нет',
            ];
        ?>
        <?= $form->field($model, 'field3', $two_column_name)->dropDownList($items, $two_column_input) ?>

        <?= $form->field($model, 'field4', $two_column_name)->dropDownList($items, $two_column_input) ?>

        <?= $form->field($model, 'field5', $two_column_name)->dropDownList($items, $two_column_input) ?>

        <?= $form->field($model, 'field6', $two_column_name)->dropDownList($items, $two_column_input) ?>

        <?= $form->field($model, 'field7', $two_column_name)->dropDownList($items, $two_column_input) ?>
        <?
            $items=[
                '' => '',
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5 и более' => '5 и более',
            ];
        ?>
        <?= $form->field($model, 'field17', $two_column_name)->dropDownList($items, $two_column_input) ?>
    </div>
    <h5 class="ml-3 mt-2 mb-2">6. Сколько в среднем в день часов в августе вы тратили на:</h5>
    <?
        $items=[
            '' => '',
            '0' => '0',
            'менее 1 ч.' => 'менее 1 ч.',
            '1-2 ч.' => '1-2 ч.',
            '2-3 ч.' => '2-3 ч.',
            '3 часа и более' => '3 часа и более',
        ];
    ?>
    <?= $form->field($model, 'field8', $two_column_name)->dropDownList($items, $two_column_input) ?>

    <?= $form->field($model, 'field9', $two_column_name)->dropDownList($items, $two_column_input) ?>

    <?= $form->field($model, 'field10', $two_column_name)->dropDownList($items, $two_column_input) ?>

    <?= $form->field($model, 'field11', $two_column_name)->dropDownList($items, $two_column_input) ?>

    <?= $form->field($model, 'field12', $two_column_name)->dropDownList($items, $two_column_input) ?>

    <?= $form->field($model, 'field13', $two_column_name)->dropDownList($items, $two_column_input) ?>
    <?
        $items=[
            '' => '',
            '0' => '0',
            'менее 10 мин.' => 'менее 10 мин.',
            '15 мин и более' => '15 мин и более',
        ];
    ?>
    <?= $form->field($model, 'field14', $two_column_name)->dropDownList($items, $two_column_input) ?>

    <?= $form->field($model, 'field15', $two_column_name)->dropDownList($items, $two_column_input) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-block mt-3 mb-5']) ?>
    </div>

    <?php ActiveForm::end(); ?>


<?php
$js = <<< JS

     var field_field106 = $('#anketemploymentchildrenjune-field1');
     field_field106.on('change', function () {
        if (field_field106.val() !== "нет" ) {
            $('.show').hide();
        }
        else{
            $('.show').show();
        }
     });
     field_field106.trigger('change');

JS;
$this->registerJs($js, \yii\web\View::POS_READY);