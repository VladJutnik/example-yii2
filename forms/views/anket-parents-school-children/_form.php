<?php

use common\models\FederalDistrict;
use common\models\Region;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\AnketParentsSchoolChildren */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="anket-parents-school-children-form">

        <?php $form = ActiveForm::begin();

        $district_null = array('' => 'Выберите федеральный округ ...');
        $districs = FederalDistrict::find()->all();
        $district_items = ArrayHelper::map($districs, 'id', 'name');
        $district_items = ArrayHelper::merge($district_null,$district_items);

        $region_null = array('' => 'Выберите регион ...');
        $regions = Region::find()->where(['district_id' => 1])->all();
        $region_items = ArrayHelper::map($regions, 'id', 'name');
        $region_items = ArrayHelper::merge($region_null,$region_items);

        $municipality_null = array('' => 'Выберите муниципальное образование...');
        $municipalities = \common\models\Municipality::find()->where(['region_id' => Region::find()->one()->id])->all();
        $municipality_items = ArrayHelper::map($municipalities, 'id', 'name');

        $params = [
            'prompt' => '',
            'class' => 'form-control col-4'
        ];
        $items_selection = [
            '1' => 'Да',
            '0' => 'Нет'
        ];
        $items_satisfied = [
            '0' => '1',
            '1' => '2',
            '2' => '3',
            '3' => '4',
            '4' => '5',
            '5' => '6',
            '6' => '7',
            '7' => '8',
            '8' => '9',
            '9' => '10',
            '10' => '10',
        ];
        $items_class = [
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
            '12' => '12'
        ];
        $items_obtain_information = [
            '0' => 'от классного руководителя',
            '1' => 'по рассказам ребенка',
            '2' => 'информационная система (сайт школы)',
            '3' => 'другое',
        ];
        $items_age = [
            '0' => '1',
            '1' => '2',
            '2' => '3',
            '3' => '4',
            '4' => '5',
            '5' => '6',
            '6' => '7',
            '7' => '8',
            '8' => '9',
            '9' => '10',
            '10' => '11',
            '11' => '12',
            '12' => '13',
            '13' => '14',
            '14' => '15',
            '15' => '16',
            '16' => '17',
            '17' => '18'
        ];
        $items_sex = [
            '0' => 'м',
            '1' => 'ж'
        ];
        $items_chronic = [
            '' => 'Выберите вариант',
            0 => 'Отсутствует',
            1 => 'Присутствует с рождения',
            2 => 'Присутствует с 1 года',
            3 => 'Присутствует с 2 лет',
            4 => 'Присутствует с 3 лет',
            5 => 'Присутствует с 4 лет',
            6 => 'Присутствует с 5 лет',
            7 => 'Присутствует с 6 лет',
            8 => 'Присутствует с 7 лет',
            9 => 'Присутствует с 8 лет',
            10 => 'Присутствует с 9 лет',
            11 => 'Присутствует с 10 лет',
            12 => 'Присутствует с 11 лет',
            13 => 'Присутствует с 12 лет',
            14 => 'Присутствует с 13 лет',
            15 => 'Присутствует с 14 лет',
            16 => 'Присутствует с 15 лет',
            17 => 'Присутствует с 16 лет',
            18 => 'Присутствует с 17 лет',
            19 => 'Присутствует с 18 лет'
        ];
        $items_chronic_other = [
            0 => 'Присутствует с рождения',
            1 => 'Присутствует с 1 года',
            2 => 'Присутствует с 2 лет',
            3 => 'Присутствует с 3 лет',
            4 => 'Присутствует с 4 лет',
            5 => 'Присутствует с 5 лет',
            6 => 'Присутствует с 6 лет',
            7 => 'Присутствует с 7 лет',
            8 => 'Присутствует с 8 лет',
            9 => 'Присутствует с 9 лет',
            10 => 'Присутствует с 10 лет',
            11 => 'Присутствует с 11 лет',
            12 => 'Присутствует с 12 лет',
            13 => 'Присутствует с 13 лет',
            14 => 'Присутствует с 14 лет',
            15 => 'Присутствует с 15 лет',
            16 => 'Присутствует с 16 лет',
            17 => 'Присутствует с 17 лет',
            18 => 'Присутствует с 18 лет'
        ];
        $items_food_allergy = [
            '' => 'Выберите вариант',
            0 => 'Отсутствует',
            1 => 'Присутствует',
        ];
        $params_chronic = [
            'class'=> 'form-control col-4',
        ];
        ?>

        <?php
        $two_column = ['options' => ['class' => 'row justify-content-center mt-3'], 'labelOptions' => ['class' => 'col-3 col-form-label font-weight-bold']];
        ?>
        <?= $form->field($model, 'federal_district_id',$two_column)->dropDownList($district_items, [
            //'prompt' => 'Выберите федеральный округ ...',
            'class'=>'form-control col-4',
            //'options' => [$post['federal_district_id'] => ['Selected' => true]],
            'onchange' => '
                  $.get("../anket-children/subjectslist?id="+$(this).val(), function(data){
                
                  $("select#anketparentsschoolchildren-region_id").html(data);
                    
                  document.getElementById("anketparentsschoolchildren-region_id").disabled = false;
                  });
                  
                  $.get("../anket-children/municipalitylist?id=0", function(data){
                    $("select#aanketparentsschoolchildren-municipality_id").html(data);
                    //document.getElementById("anketparentsschoolchildren-municipality_id").disabled = false;
                    });'
        ]); ?>

        <?= $form->field($model, 'region_id', $two_column)->dropDownList($region_items, [
            //'prompt' => 'Выберите регион ...',
            'class'=>'form-control col-4',
            'onchange' => '
                  $.get("../anket-children/municipalitylist?id="+$(this).val(), function(data){
                    $("select#anketparentsschoolchildren-municipality_id").html(data);
                    document.getElementById("anketparentsschoolchildren-municipality_id").disabled = false;
                  });'
        ]); ?>

        <?= $form->field($model, 'municipality_id', $two_column)->dropDownList($municipality_items, ['prompt' => 'Выберите муниципальное образование...','class'=>'form-control col-4']); ?>



        <?= $form->field($model, 'place_residence', $two_column)->dropDownList($model->terrain(),$params) ?>

        <?= $form->field($model, 'school', $two_column)->textInput(['maxlength' => true, 'class' => 'form-control col-4']) ?>

        <?= $form->field($model, 'class', $two_column)->dropDownList($items_class, $params) ?>

        <?= $form->field($model, 'age', $two_column)->dropDownList($items_age, $params) ?>

        <?= $form->field($model, 'sex', $two_column)->dropDownList($items_sex, $params) ?>

        <?= $form->field($model, 'body_weight', $two_column)->textInput(['class' => 'form-control col-4']) ?>

        <?= $form->field($model, 'body_length', $two_column)->textInput(['class' => 'form-control col-4']) ?>

        <?= $form->field($model, 'obtain_information', $two_column)->dropDownList($items_obtain_information, $params) ?>

        <?= $form->field($model, 'obtain_information_otther', $two_column)->textInput(['class' => 'form-control col-4']) ?>

        <?= $form->field($model, 'delicious_food', $two_column)->dropDownList($items_selection, $params) ?>

        <?= $form->field($model, 'enough_time_eat', $two_column)->dropDownList($items_selection, $params) ?>

        <?= $form->field($model, 'menu_quite_diverse', $two_column)->dropDownList($items_selection, $params) ?>

        <?= $form->field($model, 'choice_dishes', $two_column)->dropDownList($items_selection, $params) ?>

        <?= $form->field($model, 'clean_dishes', $two_column)->dropDownList($items_selection, $params) ?>

        <?= $form->field($model, 'comfort_food_children', $two_column)->dropDownList($items_selection, $params) ?>

        <?= $form->field($model, 'not_delicious_food', $two_column)->dropDownList($items_selection, $params) ?>

        <?= $form->field($model, 'not_enough_time_eat', $two_column)->dropDownList($items_selection, $params) ?>

        <?= $form->field($model, 'not_menu_quite_diverse', $two_column)->dropDownList($items_selection, $params) ?>

        <?= $form->field($model, 'not_choice_dishes', $two_column)->dropDownList($items_selection, $params) ?>

        <?= $form->field($model, 'not_clean_dishes', $two_column)->dropDownList($items_selection, $params) ?>

        <?= $form->field($model, 'not_comfort_food_children', $two_column)->dropDownList($items_selection, $params) ?>


        <?= '<h4 class="text-center col-8">4. Есть ли у Вас хронические заболевания?</h4>' ?>

        <?= $form->field($model, 'respiratory', $two_column)->dropDownList($items_food_allergy, $params_chronic) ?>
        <?= $form->field($model, 'digestive_system', $two_column)->dropDownList($items_food_allergy, $params_chronic) ?>
        <?= $form->field($model, 'circulations', $two_column)->dropDownList($items_food_allergy, $params_chronic) ?>
        <?= $form->field($model, 'diabetes', $two_column)->dropDownList($items_food_allergy, $params_chronic) ?>
        <?= $form->field($model, 'celiac', $two_column)->dropDownList($items_food_allergy, $params_chronic) ?>
        <?= $form->field($model, 'food_allergy', $two_column)->dropDownList($items_food_allergy, $params_chronic) ?>
        <?= '<h5 class="text-center col-8 allergy">Виды пищевой аллергии</h5>'?>
        <?$two_column2 = ['options' => ['class' => 'row'], 'labelOptions' => ['class' => 'col-4 col-form-label font-weight-bold', 'style'=>"display: none"]];

        $params_chronic2 = [
            'class'=> 'form-control col-4', 'style'=>"display: none"
        ];
        ?>

        <?= $form->field($model, 'citrus', $two_column)->dropDownList($items_chronic, $params_chronic) ?>
        <?= $form->field($model, 'nuts', $two_column)->dropDownList($items_chronic, $params_chronic) ?>
        <?= $form->field($model, 'egg', $two_column)->dropDownList($items_chronic, $params_chronic) ?>
        <?= $form->field($model, 'milk', $two_column)->dropDownList($items_chronic, $params_chronic) ?>
        <?= $form->field($model, 'chocolate', $two_column)->dropDownList($items_chronic, $params_chronic) ?>
        <?= $form->field($model, 'fish', $two_column)->dropDownList($items_chronic, $params_chronic) ?>
        <?= $form->field($model, 'other_allergy', $two_column)->textInput(['type' => 'text','class'=> 'form-control col-4']) ?>
        <?= $form->field($model, 'other_allergy_year', $two_column)->dropDownList($items_chronic_other, $params_chronic) ?>

        <?= $form->field($model, 'rate_overall_satisfaction', $two_column)->dropDownList($items_satisfied, $params) ?>

        <?= $form->field($model, 'offers', $two_column)->textarea(['rows' => 2, 'class' => 'form-control col-4']) ?>

        <div class="justify-content-center">
            <div class="col-auto">
                <div class="form-group text-center">
                    <?= Html::submitButton('Сохранить анкету', ['class' => 'mt-3 btn btn-success col-7']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
<?
$script = <<< JS
    $(".field-anketparentsschoolchildren-delicious_food").before("<h4 class='col-12 text-center'>2. Что, по Вашему мнению, больше всего нравится детям в школьной столовой?</h4>");
    $(".field-anketparentsschoolchildren-not_delicious_food").before("<h4 class='col-12 text-center'>3. Что по Вашему мнению больше всего не нравится детям в школьной столовой?</h4>");
    var field = $('#anketparentsschoolchildren-obtain_information');
    field.on('change', function () {
           if (field.val() !== "3" ) {
               $('.field-anketparentsschoolchildren-obtain_information_otther').hide();              
           }
           else{
              $('.field-anketparentsschoolchildren-obtain_information_otther').show();
           }
    });
    field.trigger('change');
    
    var field = $('#anketparentsschoolchildren-food_allergy');
    field.on('change', function () {
           if (field.val() !== "1" ) {
              
               /*$('#txt').show();
               $('#txt').hide();*/
               $('.allergy').hide();
               $('.field-anketparentsschoolchildren-citrus').hide();
               $('.field-anketparentsschoolchildren-nuts').hide();
               $('.field-anketparentsschoolchildren-egg').hide();
               $('.field-anketparentsschoolchildren-milk').hide();
               $('.field-anketparentsschoolchildren-chocolate').hide();
               $('.field-anketparentsschoolchildren-fish').hide();
               $('.field-anketparentsschoolchildren-other_allergy').hide();
               $('.field-anketparentsschoolchildren-other_allergy_year').hide();
              
           }
           else{
              $('.allergy').show();
              $('.allergy').addClass('mt-3');
              $('.field-anketparentsschoolchildren-citrus').show();
              $('.field-anketparentsschoolchildren-nuts').show();
              $('.field-anketparentsschoolchildren-egg').show();
              $('.field-anketparentsschoolchildren-milk').show();
              $('.field-anketparentsschoolchildren-chocolate').show();
              $('.field-anketparentsschoolchildren-fish').show();
              $('.field-anketparentsschoolchildren-other_allergy').show();
              $('.field-anketparentsschoolchildren-other_allergy_year').show();
           }
    });
    field.trigger('change');
    
    $('#anketparentsschoolchildren-region_id').attr('disabled', 'true');
    $('#anketparentsschoolchildren-municipality_id').attr('disabled', 'true');

    /*console.log($('#txt').val());*/
JS;

$this->registerJs($script, yii\web\View::POS_READY);