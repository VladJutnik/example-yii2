<?php

use common\models\FederalDistrict;
use common\models\Region;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model common\models\AnketDailyRoutine */
/* @var $form yii\widgets\ActiveForm */


$district_null = array('' => 'Выберите федеральный округ ...');
$districs = FederalDistrict::find()->all();
$district_items = ArrayHelper::map($districs, 'id', 'name');
$district_items = ArrayHelper::merge($district_null, $district_items);

$region_null = array('' => 'Выберите регион ...');
$regions = Region::find()->where(['district_id' => 1])->all();
$region_items = ArrayHelper::map($regions, 'id', 'name');
$region_items = ArrayHelper::merge($region_null, $region_items);


$municipality_null = array('' => 'Выберите муниципальное образование...');
$municipalities = \common\models\Municipality::find()->where(['region_id' => Region::find()->one()->id])->all();
$municipality_items = ArrayHelper::map($municipalities, 'id', 'name');

?>

    <div class="anket-daily-routine-form container">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'federal_district_id', ['options' => ['class' => 'row'], 'labelOptions' => ['class' => 'col-6 col-form-label font-weight-bold']])->dropDownList($district_items, [
            //'prompt' => 'Выберите федеральный округ ...',
            'class' => 'form-control col-6',
            //'options' => [$post['federal_district_id'] => ['Selected' => true]],
            'onchange' => '
                  $.get("../anket-daily-routine/subjectslist?id="+$(this).val(), function(data){
                  //$("#anketdailyroutine-region_id").prop("disabled", true);
                  
                    $("select#anketdailyroutine-region_id").html(data);
                    
                    document.getElementById("anketdailyroutine-region_id").disabled = false;
                  });
                  
                  $.get("../site/municipalitylist?id=0", function(data){
                    $("select#anketdailyroutine-municipality").html(data);
                    //document.getElementById("anketdailyroutine-municipality").disabled = false;
                    });'
        ]); ?>
        <?php
        $two_column = ['options' => ['class' => 'row mt-3'], 'labelOptions' => ['class' => 'col-6 col-form-label font-weight-bold']];
        ?>
        <?= $form->field($model, 'region_id', $two_column)->dropDownList($region_items, [
            //'prompt' => 'Выберите регион ...',
            'class' => 'form-control col-6',
            'onchange' => '
                  $.get("../site/municipalitylist?id="+$(this).val(), function(data){
                    $("select#anketdailyroutine-municipality_id").html(data);
                    document.getElementById("anketdailyroutine-municipality_id").disabled = false;
                  });'
        ]); ?>

        <?= $form->field($model, 'municipality_id', $two_column)->dropDownList($municipality_items, ['prompt' => 'Выберите муниципальное образование...', 'class' => 'form-control col-6']); ?>

        <?= $form->field($model, 'school', $two_column)->textInput(['class' => 'form-control col-6']) ?>

        <? $items = [
            'м' => 'м',
            'ж' => 'ж'
        ]; ?>

        <?= $form->field($model, 'sex', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>
        <? $items = [
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
        ]; ?>
        <?= $form->field($model, 'class', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            '1' => 'первая',
            '2' => 'вторая'
        ]; ?>

        <?= $form->field($model, 'change_training', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <?= $form->field($model, 'field1', $two_column)->widget(MaskedInput::className(), ['mask' => '99:99', 'options' => ['class' => 'form-control col-6 startTime']]) ?>

        <?= $form->field($model, 'field2', $two_column)->widget(MaskedInput::className(), ['mask' => '99:99', 'options' => ['class' => 'form-control col-6 startTime']]) ?>

        <? $items = [
            'да' => 'да',
            'нет' => 'нет'
        ]; ?>

        <?= $form->field($model, 'field3', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            'более трех' => 'более трех',
        ]; ?>

        <?= $form->field($model, 'field4', $two_column)->dropDownList($items, ['class' => 'form-control col-6']) ?>

        <?= $form->field($model, 'field5', $two_column)->widget(MaskedInput::className(), ['mask' => '99:99', 'options' => ['class' => 'form-control col-6 startTime']]) ?>

        <?= $form->field($model, 'field6', $two_column)->widget(MaskedInput::className(), ['mask' => '99:99', 'options' => ['class' => 'form-control col-6 startTime']]) ?>

        <?= $form->field($model, 'field7', $two_column)->textInput(['class' => 'form-control col-6']) ?>

        <? $items = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',

        ]; ?>

        <?= $form->field($model, 'field8', $two_column)->dropDownList($items, ['class' => 'form-control col-6']) ?>

        <? $items = [
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

        ]; ?>

        <?= $form->field($model, 'field9', $two_column)->dropDownList($items, ['class' => 'form-control col-6']) ?>

        <? $items = [
            'да' => 'да',
            'нет' => 'нет'
        ]; ?>

        <?= $form->field($model, 'field24', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4 раза и более' => '4 раза и более',
        ]; ?>

        <?= $form->field($model, 'field25', $two_column)->dropDownList($items, ['class' => 'form-control col-6']) ?>

        <?= $form->field($model, 'field26', $two_column)->textInput(['class' => 'form-control col-6']) ?>
        <? $items = [
            'да' => 'да',
            'нет' => 'нет'
        ]; ?>

        <?= $form->field($model, 'field10', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            'более трех' => 'более трех',
        ]; ?>

        <?= $form->field($model, 'field11', $two_column)->dropDownList($items, ['class' => 'form-control col-6']) ?>

        <?= $form->field($model, 'field12', $two_column)->widget(MaskedInput::className(), ['mask' => '99:99', 'options' => ['class' => 'form-control col-6 startTime']]) ?>

        <?= $form->field($model, 'field13', $two_column)->widget(MaskedInput::className(), ['mask' => '99:99', 'options' => ['class' => 'form-control col-6 startTime']]) ?>

        <?= $form->field($model, 'field14', $two_column)->textInput(['class' => 'form-control col-6']) ?>

        <? $items = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',

        ]; ?>

        <?= $form->field($model, 'field15', $two_column)->dropDownList($items, ['class' => 'form-control col-6']) ?>

        <? $items = [
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

        ]; ?>

        <?= $form->field($model, 'field16', $two_column)->dropDownList($items, ['class' => 'form-control col-6']) ?>

        <? $items = [
            'домашних заданий нет' => 'домашних заданий нет',
            'до 1 часа' => 'до 1 часа',
            '1-2 ч.' => '1-2 ч.',
            '2-3 ч.' => '2-3 ч.',
            '3-4 ч.' => '3-4 ч.',
            '4-5 ч.' => '4-5 ч.',
            '5 ч и более' => '5 ч и более',
        ]; ?>

        <?= $form->field($model, 'field17', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

		<? $items = [
            'не гуляю вообще' => 'не гуляю вообще',
            'до 1 часа' => 'до 1 часа',
            '1-2 ч.' => '1-2 ч.',
            '2-3 ч.' => '2-3 ч.',
            '3-4 ч.' => '3-4 ч.',
            '4-5 ч.' => '4-5 ч.',
            '5 ч и более' => '5 ч и более',
        ]; ?>

	    <?= $form->field($model, 'field18', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

		<? $items = [
            'не занимаюсь вообще' => 'не занимаюсь вообще',
            'до 1 часа' => 'до 1 часа',
            '1-2 ч.' => '1-2 ч.',
            '2-3 ч.' => '2-3 ч.',
            '3-4 ч.' => '3-4 ч.',
            '4-5 ч.' => '4-5 ч.',
            '5 ч и более' => '5 ч и более',
        ]; ?>

        <?= $form->field($model, 'field19', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'не занимаюсь вообще' => 'не занимаюсь вообще',
            'до 1 часа' => 'до 1 часа',
            '1-2 ч.' => '1-2 ч.',
            '2-3 ч.' => '2-3 ч.',
            '3-4 ч.' => '3-4 ч.',
            '4-5 ч.' => '4-5 ч.',
            '5 ч и более' => '5 ч и более',
        ]; ?>

        <?= $form->field($model, 'field20', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'прямо перед сном' => 'прямо перед сном',
            'за 30 минут до сна' => 'за 30 минут до сна',
            'за 1 час' => 'за 1 час',
            'за 2 часа и более' => 'за 2 часа и более',
        ]; ?>

        <?= $form->field($model, 'field21', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'до 7.00' => 'до 7.00',
            'с 7.00 до 7.59' => 'с 7.00 до 7.59',
            'с 8.00 до 8.59' => 'с 8.00 до 8.59',
            'после 9.00' => 'после 9.00',
        ]; ?>

        <?= $form->field($model, 'field22', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'до 21.00' => 'до 21.00',
            'с 21.00 до 21.59' => 'с 21.00 до 21.59',
            'с 22.00 до 22.59' => 'с 22.00 до 22.59',
            'после 23.00' => 'после 23.00',
        ]; ?>

        <?= $form->field($model, 'field23', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success form-control mt-3']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        <br>
        <br>
    </div>
<?php
$js = <<< JS
	//document.getElementById("btn").disabled = false;
    $('#anketdailyroutine-region_id').attr('disabled', 'true');
    $('#anketdailyroutine-municipality_id').attr('disabled', 'true');
     
    var field = $('#anketdailyroutine-field3');
    field.on('change', function () {
           if (field.val() !== "да" ) {
               $('.field-anketdailyroutine-field4').hide();
               $('.field-anketdailyroutine-field5').hide();
               $('.field-anketdailyroutine-field6').hide();
               $('.field-anketdailyroutine-field7').hide();
               $('.field-anketdailyroutine-field8').hide();
               $('.field-anketdailyroutine-field9').hide();
           }
           else{
              $('.field-anketdailyroutine-field4').show();
              $('.field-anketdailyroutine-field5').show();
              $('.field-anketdailyroutine-field6').show();
              $('.field-anketdailyroutine-field7').show();
              $('.field-anketdailyroutine-field8').show();
              $('.field-anketdailyroutine-field9').show();
           }
    });
    field.trigger('change');
    
    var field2 = $('#anketdailyroutine-field10');
    field2.on('change', function () {
           if (field2.val() !== "да" ) {
               $('.field-anketdailyroutine-field11').hide();
               $('.field-anketdailyroutine-field12').hide();
               $('.field-anketdailyroutine-field13').hide();
               $('.field-anketdailyroutine-field14').hide();
               $('.field-anketdailyroutine-field15').hide();
               $('.field-anketdailyroutine-field16').hide();
           }
           else{
              $('.field-anketdailyroutine-field11').show();
              $('.field-anketdailyroutine-field12').show();
              $('.field-anketdailyroutine-field13').show();
              $('.field-anketdailyroutine-field14').show();
              $('.field-anketdailyroutine-field15').show();
              $('.field-anketdailyroutine-field16').show();
           }
    });
    field2.trigger('change');
    
    var field4 = $('#anketdailyroutine-field24');
    field4.on('change', function () {
           if (field4.val() !== "да" ) {
               $('.field-anketdailyroutine-field26').hide();
               $('.field-anketdailyroutine-field25').hide();
           }
           else{
              $('.field-anketdailyroutine-field26').show();
              $('.field-anketdailyroutine-field25').show();
           }
    });
    field4.trigger('change');
    
    var field3 = $('#anketdailyroutine-change_training');
    field3.on('change', function () {
           if (field3.val() == "1") {
               
               $('.field-anketdailyroutine-field1').show();
               $('.field-anketdailyroutine-field2').hide();
           }
           else if (field3.val() == "2"){
               $('.field-anketdailyroutine-field2').show();
               $('.field-anketdailyroutine-field1').hide();
           }
           else{
                $('.field-anketdailyroutine-field1').hide();
                $('.field-anketdailyroutine-field2').hide();
           }
    });
    field3.trigger('change');
    
    
  

    
JS;
$this->registerJs($js, \yii\web\View::POS_READY);