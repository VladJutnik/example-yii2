<?php

use common\models\ThermometryCamp;
use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;

$two_column = ['options' => ['class' => 'row mt-3'], 'labelOptions' => ['class' => 'col-6 col-form-label font-weight-bold']];

?>

<div class="user-create">
    <div class="row justify-content-center mt-3">
        <div class="col-md-6">
            <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
            <? $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'date_surveys', $two_column)->textInput(['autocomplete' => 'on', 'class' => 'form-control  datepicker-here  col-6', 'value'=>$data]); ?>
            <?if (!empty($model->normal_temperature_morning))
                {
                    echo $form->field($model, 'normal_temperature_morning')->checkbox(['value' => '1', 'checked ' => true, 'labelOptions' => []]);
                }
                else
                {
                    echo $form->field($model, 'normal_temperature_morning')->checkbox(['labelOptions' => []]);
                }
            ?>
            <?= $form->field($model, 'no_normal_temperature_morning', $two_column)->textInput(['type'=>"number", 'step'=>"0.1", 'min'=>"37.2", 'max'=>"41.2", 'placeholder'=>"37.2", 'class' => 'form-control col-6']); ?>
            <?if (!empty($model->normal_temperature_evening))
                {
                    echo $form->field($model, 'normal_temperature_evening')->checkbox(['value' => '1', 'checked ' => true, 'labelOptions' => []]);
                }
                else
                {
                    echo $form->field($model, 'normal_temperature_evening')->checkbox(['labelOptions' => []]);
                }
            ?>
            <?= $form->field($model, 'no_normal_evening', $two_column)->textInput(['type'=>"number", 'step'=>"0.1", 'min'=>"37.2", 'max'=>"41.2", 'placeholder'=>"37.2", 'class' => 'form-control col-6']); ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn main-button-3 col-md-12'])?>
            </div>
            <?ActiveForm::end(); ?>
        </div>
    </div>
</div>
    <script>
        //дообследование
        var additional_examination = $('#thermometrycamp-normal_temperature_morning');
        var additional_examinationFunc = function () {
            if ((additional_examination.prop('checked')) === true)
            {
                $('.field-thermometrycamp-no_normal_temperature_morning').hide();
            }
            else
            {
                $('.field-thermometrycamp-no_normal_temperature_morning').show();
            }
        }
        additional_examinationFunc();
        additional_examination.on('click', function () {
            additional_examinationFunc();
        })     //дообследование
        var additional_examination2 = $('#thermometrycamp-normal_temperature_evening');
        var additional_examinationFunc2 = function () {
            if ((additional_examination2.prop('checked')) === true)
            {
                $('.field-thermometrycamp-no_normal_evening').hide();
            }
            else
            {
                $('.field-thermometrycamp-no_normal_evening').show();
            }
        }
        additional_examinationFunc2();
        additional_examination2.on('click', function () {
            additional_examinationFunc2();
        })
    </script>



