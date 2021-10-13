<?php

use common\models\FederalDistrict;
use common\models\Region;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\AnketSchoolChildrenKaz */
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

/*print_r('rfrfrgr <br>');
print_r($post);*/

if(!empty($post2)){
    $post = \common\models\AnketSchoolChildrenKaz::find()->where(['id' => $post2])->one();
    //print_r($post);
    //exit();
    $weight = $post['weight']; //10. Укажите массу тела (кг)
    $growth = $post['length']; //10.1 Укажите длину тела в см
    $sex = $post['sex']; //пол
    $age = $post['age']; //возраст

    if (!is_numeric($weight)) {
        $weight = 1;
    }
    if (!is_numeric($growth)) {
        $growth = 1;
    }
    if (!is_numeric($age)) {
        $age = 1;
    }

   /* print_r($weight);
    print_r('<br>');
    print_r($growth);
    print_r('<br>');
    print_r($age);
    exit();*/
    $imt = $model->get_imt2($growth, $weight, 2,$sex,$age,1);

    $rr = $growth/100;
    //exit();
    $imt2 = $weight/($rr*$rr);
    $imt2 = round($imt2, 2);
    $imt_str = '';
    if($imt == 'Дефицит массы тела'){
        $imt_str = 'отмечается дефицит массы';
    }
    elseif($imt == 'Нормальный вес'){
        $imt_str = 'гармоничное';
    }
    elseif($imt == 'Избыточная масса тела'){
        $imt_str = 'отмечается избыток массы';
    }
    elseif($imt == 'Ожирение'){
        $imt_str = 'отмечается ожирение';
    }

    $str = '
                <div class="container">
                     <h5 class="text-center">Отчет о результатах анкетирования</h5>
                     <b>1.	ОБЩАЯ ИНФОРМАЦИЯ ПО ИТОГАМ АНКЕТИРОВАНИЯ:</b><br>
                     <b>Индекс массы тела:</b> составляет '.$imt2.'; физическое развитие - '.$imt_str.'.<br>
            ';
    if($post['field114'] == 'нет' || $post['field114'] == ''){
        if($imt_str == 'отмечается дефицит массы'){
        $str .= ' 
                    <b>Вероятные факторы риска:</b> не здоровые пищевые привычки.<br>
                    <b>Заболевания риска:</b> болезни нервной системы, заболевания опорно-двигательного аппарата, болезни органов дыхания, болезни органов пищеварения, нарушения роста и развития.<br>
                    <b>Рекомендации:</b> проконсультироваться у эндокринолога и детского диетолога, пересмотреть структуру питания и сложившиеся пищевые привычки.<br>
                ';
        }
        elseif ($imt_str == 'отмечается избыток массы'){
        $str .= ' 
                    <b>Вероятные факторы риска:</b> не здоровые пищевые привычки, избыточная калорийность пищи, дефицит двигательной активности.<br>
                    <b>Заболевания риска:</b> сахарный диабет, болезни системы кровообращения, болезни обмена веществ, плоскостопие, болезни органов дыхания.<br>
                    <b>Рекомендации:</b> пересмотреть структуру питания (сократить потребление жирной и сладкой пищи, кондитерские изделия, увеличить потребление овощей и фруктов), сложившиеся пищевые привычки, увеличить двигательную активность.<br>
                ';
        }
        elseif ($imt_str == 'отмечается ожирение'){
        $str .= ' 
                    <b>Вероятные факторы риска:</b> не здоровые пищевые привычки, избыточная калорийность пищи, дефицит двигательной активности.<br>
                    <b>Заболевания риска:</b> сахарный диабет, болезни системы кровообращения, болезни обмена веществ, плоскостопие, болезни органов дыхания.<br>
                    <b>Рекомендации:</b> проконсультироваться у эндокринолога и детского диетолога, ежедневно контролировать калорийность рациона и энерготрат, массу тела, пересмотреть структуру питания (сократить потребление жирной и сладкой пищи, кондитерские изделия, увеличить потребление овощей и фруктов), сложившиеся пищевые привычки, увеличить двигательную активность.<br>
                ';
        }
    }
    $str .= ' 
                <b>2. ПРАКТИЧЕСКИЕ РЕКОМЕНДАЦИИ ПО РЕЗУЛЬТАТАМ ОЦЕНКИ СТРУКТУРЫ ПИТАНИЯ И ПИЩЕВЫХ ПРИВЫЧЕК:</b><br>
            ';
    if($post['change_training'] == '1' && $post['field1'] == 'нет'){
        $str .= ' 
                    <b>Вам нужно работать по изменению пищевых привычек:</b> завтракать утром перед выходом в школу<br>
                ';
    }
    if($post['change_training'] == '2' && $post['field2'] == 'нет'){
        $str .= ' 
                    <b>Вам нужно работать по изменению пищевых привычек:</b> кушать дома перед выходом в школу<br>
                ';
    }
    if($post['field3'] == '1' || $post['field3'] == '2' || $post['field3'] == '3'){
        $str .= ' 
                    Увеличить количество приемов пищи – не менее 5 раз в день<br>
                ';
    }
    if($post['field4'] == '0'){
        $str .= ' 
                    Увеличить количество приемов пищи в школе – не менее одного раза<br>
                ';
    }
    if($post['field5'] == 'ем перед сном' || $post['field5'] == 'ем за час перед сном'){
        $str .= ' 
                    Пересмотреть время последнего приема пищи – есть не позднее двух часов до отхода ко сну<br>
                ';
    }
    if($post['field6'] == 'да'){
        $str .= ' 
                    Исключить привычку досаливать пищу<br>
                ';
    }
    if($post['field6'] == 'три ложки' || $post['field6'] == 'четыре ложки и более'){
        $str .= ' 
                    Сократить количество потребляемого сахара <br>
                ';
    }
    $str .= ' 
                <b>Реже употреблять:</b><br>
            ';
    if($post['field7'] == 'ежедневно' || $post['field7'] == '5-6 раз в неделю'){
        $str .= ' 
                    Пирожки и булочки <br>
                ';
    }
    if($post['field8'] == 'ежедневно' || $post['field8'] == '5-6 раз в неделю'){
        $str .= ' 
                    Пирожные, торты и печенье <br>
                ';
    }
    if($post['field9'] == 'ежедневно' || $post['field9'] == '5-6 раз в неделю'){
        $str .= ' 
                    Конфеты <br>
                ';
    }
    if($post['field13'] == 'ежедневно' || $post['field13'] == '5-6 раз в неделю' || $post['field13'] == '2-4 раза в неделю'){
        $str .= ' 
                    Колбасные изделия, сосиски, сардельки <br>
                ';
    }
    $str .= ' 
                <b>Чаще употреблять:</b><br>
            ';
    if($post['field10'] == '5-6 раз в неделю' || $post['field10'] == '2-4 раза в неделю' || $post['field10'] == '1 раз в неделю и реже' || $post['field10'] == 'не употребляю'){
        $str .= ' 
                    Фрукты <br>
                ';
    }
    if($post['field11'] == '5-6 раз в неделю' || $post['field11'] == '2-4 раза в неделю' || $post['field11'] == '1 раз в неделю и реже' || $post['field11'] == 'не употребляю'){
        $str .= ' 
                    Овощи <br>
                ';
    }
    if($post['field12'] == '5-6 раз в неделю' || $post['field12'] == '2-4 раза в неделю' || $post['field12'] == '1 раз в неделю и реже' || $post['field12'] == 'не употребляю'){
        $str .= ' 
                    Мясные блюда <br>
                ';
    }
    if($post['field14'] == 'ежедневно' || $post['field14'] == '5-6 раз в неделю' || $post['field14'] == '2-4 раза в неделю' || $post['field14'] == '1 раз в неделю или реже'){
        $str .= ' 
                    <b>Реже посещать:</b><br>
                    Организации быстрого питания<br>
                ';
    }
    $str .= ' 
                <b>3. ОБЩИЕ ПРОФИЛАКТИЧЕСКИЕ РЕКОМЕНДАЦИИ :</b><br>
                Важно ежедневно контролировать правильную рабочую позу. Расстояние от глаз до тетради, учебника, гаджета должно быть не менее 50 см.<br>
                Не забывайте регулярно делать гимнастику для глаз, дыхательную гимнастику, гимнастику для расслабления мышц спины и шеи.<br>
                Регулярно проветривайте помещение.<br>
                Гуляйте не менее 2-х часов в день в светлое время суток, это профилактика гиподинамии и нарушений зрения.<br>
                Не пользуйтесь сотовыми телефонами во время перемен и перед сном.<br>
                Сократите свое суммарное экранное время (сотовые телефоны, компьютер, ноутбук, планшет, телевизор) до двух часов в день. <br>
                При чтении старайтесь использовать бумажный носитель.<br><br>
                <h5>Рекомендации подготовлены ФБУН «Новосибирский НИИ гигиены» Роспотребнадзора</h5>
            ';
    $str .= ' 
                <div class="row">
                    <div class="col-6">
                    ' . Html::a('Сохранить отчет', ['printing?id=' . $post2], ['class' => 'btn btn-warning btn-sm btn-block ml-1']) .'
                    </div>
                    <div class="col-6">
                    ' . Html::a('Следующие анкетирование', ['anket-school-children-kaz/create'], ['class' => 'btn btn-danger btn-sm btn-block ml-1']) .'
                    </div>
                </div>
            ';
    $str .= ' 
                </div>
            ';


}
else{
    $str = '';
}

?>

    <div class="anket-school-children-kaz-form container">

        <?php
        $two_column = ['options' => ['class' => 'row mt-3'], 'labelOptions' => ['class' => 'col-6 col-form-label font-weight-bold']];
        ?>
        <?php $form = ActiveForm::begin(); ?>

        <div><?=$str?></div>
        <h5 class="text-center mt-4">ОБЩАЯ ИНФОРМАЦИЯ</h5>
        <?= $form->field($model, 'federal_district_id', ['options' => ['class' => 'row'], 'labelOptions' => ['class' => 'col-6 col-form-label font-weight-bold']])->dropDownList($district_items, [
            //'prompt' => 'Выберите федеральный округ ...',
            'class' => 'form-control col-6',
            'options' => [5 => ['Selected' => true]],
            'onchange' => '
                  $.get("../anket-school-children-kaz/subjectslist?id="+$(this).val(), function(data){
                  //$("#anketschoolchildrenkaz-region_id").prop("disabled", true);
                  
                    $("select#anketschoolchildrenkaz-region_id").html(data);
                    
                    document.getElementById("anketschoolchildrenkaz-region_id").disabled = false;
                  });
                  
                  $.get("../anket-school-children-kaz/municipalitylist?id=0", function(data){
                    $("select#anketschoolchildrenkaz-municipality_id").html(data);
                    //document.getElementById("anketschoolchildrenkaz-municipality_id").disabled = false;
                    });'
        ]); ?>
        <?= $form->field($model, 'region_id', $two_column)->dropDownList($region_items, [
            //'prompt' => 'Выберите регион ...',
            'class' => 'form-control col-6',
            'options' => [48 => ['Selected' => true]],
            'onchange' => '
                  $.get("../anket-school-children-kaz/municipalitylist?id="+$(this).val(), function(data){
                    $("select#anketschoolchildrenkaz-municipality_id").html(data);
                    document.getElementById("anketschoolchildrenkaz-municipality_id").disabled = false;
                  });'
        ]); ?>
        <?= $form->field($model, 'municipality_id', $two_column)->dropDownList($municipality_items, [
            'prompt' => 'Выберите муниципальное образование...',
            'class' => 'form-control col-6',
            'options' => [253 => ['Selected' => true]],
        ]); ?>

        <?= $form->field($model, 'school', $two_column)->textInput(['class' => 'form-control col-6']) ?>

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
            'а' => 'а',
            'б' => 'б',
            'в' => 'в',
            'г' => 'г',
            'д' => 'д',
            'е' => 'е',
            'ж' => 'ж',
            'з' => 'з',
            'и' => 'и',
            'к' => 'к',
            'л' => 'л',
            'м' => 'м',
            'н' => 'н',
            'о' => 'о',
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
        <?= $form->field($model, 'class_a_b', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            '1' => 'первая',
            '2' => 'вторая'
        ]; ?>
        <?= $form->field($model, 'change_training', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>
        <?= $form->field($model, 'fio', $two_column)->textInput(['class' => 'form-control col-6']) ?>

        <? $items = [
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
        ]; ?>
        <?= $form->field($model, 'age', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'м' => 'м',
            'ж' => 'ж'
        ]; ?>
        <?= $form->field($model, 'sex', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'да' => 'да',
            'нет' => 'нет'
        ]; ?>
        <?= $form->field($model, 'field114', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>
        <?= $form->field($model, 'weight', $two_column)->textInput(['class' => 'form-control col-6']) ?>
        <?= $form->field($model, 'length', $two_column)->textInput(['class' => 'form-control col-6']) ?>
        <div class="row mb-4">
            <div class="col-6"></div>
            <div class="col-6"><div id="imt" class="mt-3"></div></div>
        </div>

        <h5 class="text-center mt-3">ХАРАКТЕРИСТИКА ПИТАНИЯ (ПИЩЕВЫЕ ПРИВЫЧКИ)</h5>
        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <?= $form->field($model, 'field1', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>
        <?= $form->field($model, 'field2', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>


        <? $items = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6 и более' => '6 и более',
        ]; ?>
        <?= $form->field($model, 'field3', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            '0' => '0',
            '1' => '1',
            '2' => '2',
            '3' => '3',
        ]; ?>
        <?= $form->field($model, 'field4', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'ем перед сном' => 'ем перед сном',
            'ем за час перед сном' => 'ем за час перед сном',
            'ем более чем за два часа до сна' => 'ем более чем за два часа до сна',
        ]; ?>
        <?= $form->field($model, 'field5', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <?= $form->field($model, 'field6', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <div class="mt-3"><b><big>15. Как часто вы кушаете дома,</big></b></div>
        <? $items = [
            'ежедневно' => 'ежедневно',
            '5-6 раз в неделю' => '5-6 раз в неделю',
            '2-4 раза в неделю' => '2-4 раза в неделю',
            '1 раз в неделю или реже' => '1 раз в неделю или реже',
            'не употребляю' => 'не употребляю',
        ]; ?>
        <?= $form->field($model, 'field7', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('15.1. пирожки и булочки') ?>
        <? $items = [
            'ежедневно' => 'ежедневно',
            '5-6 раз в неделю' => '5-6 раз в неделю',
            '2-4 раза в неделю' => '2-4 раза в неделю',
            '1 раз в неделю или реже' => '1 раз в неделю или реже',
            'не употребляю' => 'не употребляю',
        ]; ?>
        <?= $form->field($model, 'field8', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('15.2. пирожные, торты, печенье') ?>
        <? $items = [
            'ежедневно' => 'ежедневно',
            '5-6 раз в неделю' => '5-6 раз в неделю',
            '2-4 раза в неделю' => '2-4 раза в неделю',
            '1 раз в неделю или реже' => '1 раз в неделю или реже',
            'не употребляю' => 'не употребляю',
        ]; ?>
        <?= $form->field($model, 'field9', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('15.3. конфеты, шоколад') ?>
        <? $items = [
            'ежедневно' => 'ежедневно',
            '5-6 раз в неделю' => '5-6 раз в неделю',
            '2-4 раза в неделю' => '2-4 раза в неделю',
            '1 раз в неделю или реже' => '1 раз в неделю или реже',
            'не употребляю' => 'не употребляю',
        ]; ?>
        <?= $form->field($model, 'field10', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('15.4. фрукты') ?>
        <? $items = [
            'ежедневно' => 'ежедневно',
            '5-6 раз в неделю' => '5-6 раз в неделю',
            '2-4 раза в неделю' => '2-4 раза в неделю',
            '1 раз в неделю или реже' => '1 раз в неделю или реже',
            'не употребляю' => 'не употребляю',
        ]; ?>
        <?= $form->field($model, 'field11', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('15.5. овощи') ?>
        <? $items = [
            'ежедневно' => 'ежедневно',
            '5-6 раз в неделю' => '5-6 раз в неделю',
            '2-4 раза в неделю' => '2-4 раза в неделю',
            '1 раз в неделю или реже' => '1 раз в неделю или реже',
            'не употребляю' => 'не употребляю',
        ]; ?>
        <?= $form->field($model, 'field12', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('15.6. мясные блюда') ?>
        <? $items = [
            'ежедневно' => 'ежедневно',
            '5-6 раз в неделю' => '5-6 раз в неделю',
            '2-4 раза в неделю' => '2-4 раза в неделю',
            '1 раз в неделю или реже' => '1 раз в неделю или реже',
            'не употребляю' => 'не употребляю',
        ]; ?>
        <?= $form->field($model, 'field13', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('15.7. колбасные изделия, сосиски, сардельки') ?>
        <? $items = [
            'ежедневно' => 'ежедневно',
            '5-6 раз в неделю' => '5-6 раз в неделю',
            '2-4 раза в неделю' => '2-4 раза в неделю',
            '1 раз в неделю или реже' => '1 раз в неделю или реже',
            '1 раз в месяц или реже' => '1 раз в месяц или реже',
            'не посещаю' => 'не посещаю',
        ]; ?>
        <?= $form->field($model, 'field14', ['options' => ['class' => 'row mt-5'], 'labelOptions' => ['class' => 'col-6 col-form-label font-weight-bold']])->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>
        <? $items = [
            'пью без сахара' => 'пью без сахара',
            '1 ложка' => '1 ложка',
            '2 ложки' => '2 ложки',
            'три ложки' => 'три ложки',
            'четыре ложки и более' => 'четыре ложки и более',
            'не употребляю' => 'не употребляю',
        ]; ?>
        <?= $form->field($model, 'field15', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <h6>Рекомендовано заполнение с родителями</h6>
        <?= $form->field($model, 'field106', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'один раз' => 'один раз',
            'два раза и более' => 'два раза и более',
        ]; ?>
        <?= $form->field($model, 'field107', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'завтрак' => 'завтрак',
            'обед' => 'обед',
        ]; ?>
        <?= $form->field($model, 'field108', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'завтрак и обед' => 'завтрак и обед',
            'завтрак, обед и полдник' => 'завтрак, обед и полдник',
            'обед и полдник' => 'обед и полдник',
        ]; ?>
        <?= $form->field($model, 'field109', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <h6>Рекомендовано заполнение с родителями</h6>
        <?= $form->field($model, 'field110', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'первое блюдо' => 'первое блюдо',
            'салат' => 'салат',
            'гарнир' => 'гарнир',
            'мясное или рыбное блюдо' => 'мясное или рыбное блюдо',
            'булочка, пирожок' => 'булочка, пирожок',
            'напиток' => 'напиток',
            'шоколад, конфеты' => 'шоколад, конфеты',
            'фрукты' => 'фрукты',
        ]; ?>
        <?= $form->field($model, 'field111', $two_column)->dropDownList($items, ['class' => 'form-control col-6']) ?>

        <? $items = [
            'вкусно готовят' =>  'вкусно готовят',
            'всегда можно купить выпечку или что-нибудь сладкое'  => 'всегда можно купить выпечку или что-нибудь сладкое',
            'приятный интерьер столовой'  => 'приятный интерьер столовой',
            'можно не спеша поесть и пообщаться с друзьями'  => 'можно не спеша поесть и пообщаться с друзьями',
            'всегда вежливые и внимательные работники столовой'  => 'всегда вежливые и внимательные работники столовой',
            'ничего из вышеперечисленного'  => 'ничего из вышеперечисленного',
        ]; ?>
        <h6>Рекомендовано заполнение с родителями</h6>
        <?= $form->field($model, 'field112', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'НЕ вкусно готовят' =>  'НЕ вкусно готовят',
            'когда хочется есть столовая уже не работает'  => 'когда хочется есть столовая уже не работает',
            'всегда много народа'  => 'всегда много народа',
            'не хватает времени спокойно поесть за перемену'  => 'не хватает времени спокойно поесть за перемену',
            'грубость работников столовой'  => 'грубость работников столовой',
            'грязная посуда'  => 'грязная посуда',
            'остывшая еда'  => 'остывшая еда',
            'ничего из вышеперечисленного'  => 'ничего из вышеперечисленного',
        ]; ?>
        <h6>Рекомендовано заполнение с родителями</h6>
        <?= $form->field($model, 'field113', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>


        <h5 class="text-center mt-3">ХАРАКТЕРИСТИКА ШКОЛЬНОЙ И ВНЕШКОЛЬНОЙ ДЕЯТЕЛЬНОСТИ</h5>

        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <?= $form->field($model, 'field16', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            'более трех' => 'более трех',
        ]; ?>

        <?= $form->field($model, 'field17', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>
        <?= $form->field($model, 'field18', $two_column)->textInput(['class' => 'form-control col-6']) ?>
        <? $items = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
        ]; ?>
        <?= $form->field($model, 'field19', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <?= $form->field($model, 'field20', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>
        <? $items = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4 раза и более' => '4 раза и более',
        ]; ?>
        <?= $form->field($model, 'field21', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>
        <?= $form->field($model, 'field22', $two_column)->textInput(['class' => 'form-control col-6']) ?>

        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <?= $form->field($model, 'field23', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>
        <? $items = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            'более трех' => 'более трех',
        ]; ?>
        <?= $form->field($model, 'field24', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>
        <?= $form->field($model, 'field25', $two_column)->textInput(['class' => 'form-control col-6']) ?>
        <? $items = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
        ]; ?>
        <?= $form->field($model, 'field26', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'домашних заданий нет' => 'домашних заданий нет',
            'до 1 часа' => 'до 1 часа',
            '1-2 ч.' => '1-2 ч.',
            '2-3 ч.' => '2-3 ч.',
            '3-4 ч.' => '3-4 ч.',
            '4-5 ч.' => '4-5 ч.',
            '5 ч и более' => '5 ч и более',
        ]; ?>
        <?= $form->field($model, 'field27', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <div class="mt-3"><b><big>26. Сколько времени в учебный день вы тратите:</big></b></div>

        <? $items = [
            'не гуляю вообще' => 'не гуляю вообще',
            'до 1 часа' => 'до 1 часа',
            '1-2 ч.' => '1-2 ч.',
            '2-3 ч.' => '2-3 ч.',
            '3-4 ч.' => '3-4 ч.',
            '4-5 ч.' => '4-5 ч.',
            '5 ч и более' => '5 ч и более',
        ]; ?>
        <?= $form->field($model, 'field28', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('26.1. на прогулки') ?>
        <? $items = [
            'не пользуюсь' => 'не пользуюсь',
            'до 1 часа' => 'до 1 часа',
            '1-2 ч.' => '1-2 ч.',
            '2-3 ч.' => '2-3 ч.',
            '3-4 ч.' => '3-4 ч.',
            '4-5 ч.' => '4-5 ч.',
            '5 ч и более' => '5 ч и более',
        ]; ?>
        <?= $form->field($model, 'field29', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('26.2. на работу и досуг с компьютером') ?>
        <? $items = [
            'не пользуюсь' => 'не пользуюсь',
            'до 1 часа' => 'до 1 часа',
            '1-2 ч.' => '1-2 ч.',
            '2-3 ч.' => '2-3 ч.',
            '3-4 ч.' => '3-4 ч.',
            '4-5 ч.' => '4-5 ч.',
            '5 ч и более' => '5 ч и более',
        ]; ?>
        <?= $form->field($model, 'field30', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('26.3. на работу и досуг с ноутбуком') ?>
        <? $items = [
            'не пользуюсь' => 'не пользуюсь',
            'до 1 часа' => 'до 1 часа',
            '1-2 ч.' => '1-2 ч.',
            '2-3 ч.' => '2-3 ч.',
            '3-4 ч.' => '3-4 ч.',
            '4-5 ч.' => '4-5 ч.',
            '5 ч и более' => '5 ч и более',
        ]; ?>
        <?= $form->field($model, 'field31', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('26.4. на работу и досуг с планшетом') ?>
        <? $items = [
            'не пользуюсь' => 'не пользуюсь',
            'до 1 часа' => 'до 1 часа',
            '1-2 ч.' => '1-2 ч.',
            '2-3 ч.' => '2-3 ч.',
            '3-4 ч.' => '3-4 ч.',
            '4-5 ч.' => '4-5 ч.',
            '5 ч и более' => '5 ч и более',
        ]; ?>
        <?= $form->field($model, 'field32', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('26.5. на работу и досуг с сотовым телефоном') ?>
        <? $items = [
            'не пользуюсь' => 'не пользуюсь',
            'до 1 часа' => 'до 1 часа',
            '1-2 ч.' => '1-2 ч.',
            '2-3 ч.' => '2-3 ч.',
            '3-4 ч.' => '3-4 ч.',
            '4-5 ч.' => '4-5 ч.',
            '5 ч и более' => '5 ч и более',
        ]; ?>
        <?= $form->field($model, 'field33', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('26.6. на просмотр телевизора') ?>
        <div class="cls_6_11_2">
            <div class="mt-5"><b><big>27. Укажите привычное расстояние от глаз до разных видов рабочих поверхностей при
                        выполнении домашнего задания:</big></b></div>
            <? $items = [
                'до 10 см' => 'до 10 см',
                '10-20 см' => '10-20 см',
                '20-30 см' => '20-30 см',
                '30-40 см' => '30-40 см',
                '40-50 см' => '40-50 см',
                '50-60 см' => '50-60 см',
                '60 см и более' => '60 см и более',
            ]; ?>
            <?= $form->field($model, 'field35', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('27.1. от глаз до тетради') ?>
            <? $items = [
                'до 10 см' => 'до 10 см',
                '10-20 см' => '10-20 см',
                '20-30 см' => '20-30 см',
                '30-40 см' => '30-40 см',
                '40-50 см' => '40-50 см',
                '50-60 см' => '50-60 см',
                '60 см и более' => '60 см и более',
            ]; ?>
            <?= $form->field($model, 'field36', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('27.2. от глаз до учебника') ?>
            <? $items = [
                'до 10 см' => 'до 10 см',
                '10-20 см' => '10-20 см',
                '20-30 см' => '20-30 см',
                '30-40 см' => '30-40 см',
                '40-50 см' => '40-50 см',
                '50-60 см' => '50-60 см',
                '60 см и более' => '60 см и более',
                'не пользуюсь' => 'не пользуюсь',
            ]; ?>
            <?= $form->field($model, 'field37', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('27.3. от глаз до монитора компьютера') ?>
            <? $items = [
                'до 10 см' => 'до 10 см',
                '10-20 см' => '10-20 см',
                '20-30 см' => '20-30 см',
                '30-40 см' => '30-40 см',
                '40-50 см' => '40-50 см',
                '50-60 см' => '50-60 см',
                '60 см и более' => '60 см и более',
                'не пользуюсь' => 'не пользуюсь',
            ]; ?>
            <?= $form->field($model, 'field38', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('27.4. от глаз до монитора ноутбука') ?>
            <? $items = [
                'до 10 см' => 'до 10 см',
                '10-20 см' => '10-20 см',
                '20-30 см' => '20-30 см',
                '30-40 см' => '30-40 см',
                '40-50 см' => '40-50 см',
                '50-60 см' => '50-60 см',
                '60 см и более' => '60 см и более',
                'не пользуюсь' => 'не пользуюсь',
            ]; ?>
            <?= $form->field($model, 'field39', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('27.5. от глаз до планшета') ?>
            <? $items = [
                'до 10 см' => 'до 10 см',
                '10-20 см' => '10-20 см',
                '20-30 см' => '20-30 см',
                '30-40 см' => '30-40 см',
                '40-50 см' => '40-50 см',
                '50-60 см' => '50-60 см',
                '60 см и более' => '60 см и более',
                'не пользуюсь' => 'не пользуюсь',
            ]; ?>
            <?= $form->field($model, 'field40', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('27.6. от глаз до сотового телефона') ?>

        </div>

        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <?= $form->field($model, 'field41', ['options' => ['class' => 'row mt-5'], 'labelOptions' => ['class' => 'col-6 col-form-label font-weight-bold']])->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <?= $form->field($model, 'field42', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <?= $form->field($model, 'field43', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <?= $form->field($model, 'field44', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <?= $form->field($model, 'field45', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <?= $form->field($model, 'field46', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <?= $form->field($model, 'field47', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <?= $form->field($model, 'field48', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <?= $form->field($model, 'field49', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <div class="mt-5"><b><big>37. Испытываете ли вы дискомфорт (боль в спине, боль в шее, головную боль,
                    компьютерный зрительный синдром (зрительную усталость)) в течение учебного дня:</big></b></div>
        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <?= $form->field($model, 'field52', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('37.3. Боль в спине') ?>
        <? $items = [
            'в школе' => 'в школе',
            'дома' => 'дома',
            'в школе и дома' => 'в школе и дома',
        ]; ?>
        <?= $form->field($model, 'field53', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>
        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <?= $form->field($model, 'field54', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('37.4. Боль в шее') ?>
        <? $items = [
            'в школе' => 'в школе',
            'дома' => 'дома',
            'в школе и дома' => 'в школе и дома',
        ]; ?>
        <?= $form->field($model, 'field55', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>
        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <?= $form->field($model, 'field56', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('37.5. Головная боль') ?>
        <? $items = [
            'в школе' => 'в школе',
            'дома' => 'дома',
            'в школе и дома' => 'в школе и дома',
        ]; ?>
        <?= $form->field($model, 'field57', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>
        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <?= $form->field($model, 'field58', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('37.6. Компьютерный зрительный синдром (зрительную усталость)') ?>
        <? $items = [
            'в школе' => 'в школе',
            'дома' => 'дома',
            'в школе и дома' => 'в школе и дома',
        ]; ?>
        <?= $form->field($model, 'field59', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>


        <div class="cls_6_11">
            <div class="mt-5"><b><big>38. Оцените учебные предметы по степени трудности для Вас от 1 (минимальная) до 10
                        (максимальная), пропускайте тот предмет, который не изучаете.</big></b></div>
            <table class="table table-bordered table-sm">
                <tr>
                    <th class="text-center" style="width:33%">Предмет</th>
                    <th class="text-center" style="width:33%">Трудность (баллы от 0 до 10)</th>
                    <th class="text-center" style="width:33%">Среднее время в минутах на выполнение домашнего задания
                    </th>
                </tr>
                <tr>
                    <td>математика</td>
                    <td>
                        <? $items = [
                            '10' => '10',
                            '9' => '9',
                            '8' => '8',
                            '7' => '7',
                            '6' => '6',
                            '5' => '5',
                            '4' => '4',
                            '3' => '3',
                            '2' => '2',
                            '1' => '1',
                            '0' => '0',
                        ]; ?>
                        <?= $form->field($model, 'field60')->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control'])->label(false) ?>
                    </td>
                    <td>
                        <?= $form->field($model, 'field61')->textInput(['class' => 'form-control'])->label(false) ?>
                    </td>
                </tr>
                <tr>
                    <td>русский язык</td>
                    <td>
                        <? $items = [
                            '10' => '10',
                            '9' => '9',
                            '8' => '8',
                            '7' => '7',
                            '6' => '6',
                            '5' => '5',
                            '4' => '4',
                            '3' => '3',
                            '2' => '2',
                            '1' => '1',
                            '0' => '0',
                        ]; ?>
                        <?= $form->field($model, 'field62')->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control'])->label(false) ?>
                    </td>
                    <td>
                        <?= $form->field($model, 'field63')->textInput(['class' => 'form-control'])->label(false) ?>
                    </td>
                </tr>
                <tr>
                    <td>родной язык</td>
                    <td>
                        <? $items = [
                            '10' => '10',
                            '9' => '9',
                            '8' => '8',
                            '7' => '7',
                            '6' => '6',
                            '5' => '5',
                            '4' => '4',
                            '3' => '3',
                            '2' => '2',
                            '1' => '1',
                            '0' => '0',
                        ]; ?>
                        <?= $form->field($model, 'field64')->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control'])->label(false) ?>
                    </td>
                    <td>
                        <?= $form->field($model, 'field65')->textInput(['class' => 'form-control'])->label(false) ?>
                    </td>
                </tr>
                <tr>
                    <td>литература</td>
                    <td>
                        <? $items = [
                            '10' => '10',
                            '9' => '9',
                            '8' => '8',
                            '7' => '7',
                            '6' => '6',
                            '5' => '5',
                            '4' => '4',
                            '3' => '3',
                            '2' => '2',
                            '1' => '1',
                            '0' => '0',
                        ]; ?>
                        <?= $form->field($model, 'field66')->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control'])->label(false) ?>
                    </td>
                    <td>
                        <?= $form->field($model, 'field67')->textInput(['class' => 'form-control'])->label(false) ?>
                    </td>
                </tr>
                <tr>
                    <td>родная литература</td>
                    <td>
                        <? $items = [
                            '10' => '10',
                            '9' => '9',
                            '8' => '8',
                            '7' => '7',
                            '6' => '6',
                            '5' => '5',
                            '4' => '4',
                            '3' => '3',
                            '2' => '2',
                            '1' => '1',
                            '0' => '0',
                        ]; ?>
                        <?= $form->field($model, 'field68')->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control'])->label(false) ?>
                    </td>
                    <td>
                        <?= $form->field($model, 'field69')->textInput(['class' => 'form-control'])->label(false) ?>
                    </td>
                </tr>
                <tr>
                    <td>история</td>
                    <td>
                        <? $items = [
                            '10' => '10',
                            '9' => '9',
                            '8' => '8',
                            '7' => '7',
                            '6' => '6',
                            '5' => '5',
                            '4' => '4',
                            '3' => '3',
                            '2' => '2',
                            '1' => '1',
                            '0' => '0',
                        ]; ?>
                        <?= $form->field($model, 'field70')->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control'])->label(false) ?>
                    </td>
                    <td>
                        <?= $form->field($model, 'field71')->textInput(['class' => 'form-control'])->label(false) ?>
                    </td>
                </tr>
                <tr>
                    <td>биология</td>
                    <td>
                        <? $items = [
                            '10' => '10',
                            '9' => '9',
                            '8' => '8',
                            '7' => '7',
                            '6' => '6',
                            '5' => '5',
                            '4' => '4',
                            '3' => '3',
                            '2' => '2',
                            '1' => '1',
                            '0' => '0',
                        ]; ?>
                        <?= $form->field($model, 'field72')->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control'])->label(false) ?>
                    </td>
                    <td>
                        <?= $form->field($model, 'field73')->textInput(['class' => 'form-control'])->label(false) ?>
                    </td>
                </tr>
                <tr>
                    <td>география</td>
                    <td>
                        <? $items = [
                            '10' => '10',
                            '9' => '9',
                            '8' => '8',
                            '7' => '7',
                            '6' => '6',
                            '5' => '5',
                            '4' => '4',
                            '3' => '3',
                            '2' => '2',
                            '1' => '1',
                            '0' => '0',
                        ]; ?>
                        <?= $form->field($model, 'field74')->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control'])->label(false) ?>
                    </td>
                    <td>
                        <?= $form->field($model, 'field75')->textInput(['class' => 'form-control'])->label(false) ?>
                    </td>
                </tr>
                <tr>
                    <td>иностранный язык</td>
                    <td>
                        <? $items = [
                            '10' => '10',
                            '9' => '9',
                            '8' => '8',
                            '7' => '7',
                            '6' => '6',
                            '5' => '5',
                            '4' => '4',
                            '3' => '3',
                            '2' => '2',
                            '1' => '1',
                            '0' => '0',
                        ]; ?>
                        <?= $form->field($model, 'field76')->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control'])->label(false) ?>
                    </td>
                    <td>
                        <?= $form->field($model, 'field77')->textInput(['class' => 'form-control'])->label(false) ?>
                    </td>
                </tr>
                <tr>
                    <td>изобразительное искусство</td>
                    <td>
                        <? $items = [
                            '10' => '10',
                            '9' => '9',
                            '8' => '8',
                            '7' => '7',
                            '6' => '6',
                            '5' => '5',
                            '4' => '4',
                            '3' => '3',
                            '2' => '2',
                            '1' => '1',
                            '0' => '0',
                        ]; ?>
                        <?= $form->field($model, 'field78')->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control'])->label(false) ?>
                    </td>
                    <td>
                        <?= $form->field($model, 'field79')->textInput(['class' => 'form-control'])->label(false) ?>
                    </td>
                </tr>
                <tr>
                    <td>технология</td>
                    <td>
                        <? $items = [
                            '10' => '10',
                            '9' => '9',
                            '8' => '8',
                            '7' => '7',
                            '6' => '6',
                            '5' => '5',
                            '4' => '4',
                            '3' => '3',
                            '2' => '2',
                            '1' => '1',
                            '0' => '0',
                        ]; ?>
                        <?= $form->field($model, 'field80')->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control'])->label(false) ?>
                    </td>
                    <td>
                        <?= $form->field($model, 'field81')->textInput(['class' => 'form-control'])->label(false) ?>
                    </td>
                </tr>
                <tr>
                    <td>алгебра</td>
                    <td>
                        <? $items = [
                            '10' => '10',
                            '9' => '9',
                            '8' => '8',
                            '7' => '7',
                            '6' => '6',
                            '5' => '5',
                            '4' => '4',
                            '3' => '3',
                            '2' => '2',
                            '1' => '1',
                            '0' => '0',
                        ]; ?>
                        <?= $form->field($model, 'field82')->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control'])->label(false) ?>
                    </td>
                    <td>
                        <?= $form->field($model, 'field83')->textInput(['class' => 'form-control'])->label(false) ?>
                    </td>
                </tr>
                <tr>
                    <td>геометрия</td>
                    <td>
                        <? $items = [
                            '10' => '10',
                            '9' => '9',
                            '8' => '8',
                            '7' => '7',
                            '6' => '6',
                            '5' => '5',
                            '4' => '4',
                            '3' => '3',
                            '2' => '2',
                            '1' => '1',
                            '0' => '0',
                        ]; ?>
                        <?= $form->field($model, 'field84')->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control'])->label(false) ?>
                    </td>
                    <td>
                        <?= $form->field($model, 'field85')->textInput(['class' => 'form-control'])->label(false) ?>
                    </td>
                </tr>
                <tr>
                    <td>физика</td>
                    <td>
                        <? $items = [
                            '10' => '10',
                            '9' => '9',
                            '8' => '8',
                            '7' => '7',
                            '6' => '6',
                            '5' => '5',
                            '4' => '4',
                            '3' => '3',
                            '2' => '2',
                            '1' => '1',
                            '0' => '0',
                        ]; ?>
                        <?= $form->field($model, 'field86')->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control'])->label(false) ?>
                    </td>
                    <td>
                        <?= $form->field($model, 'field87')->textInput(['class' => 'form-control'])->label(false) ?>
                    </td>
                </tr>
                <tr>
                    <td>обществознание</td>
                    <td>
                        <? $items = [
                            '10' => '10',
                            '9' => '9',
                            '8' => '8',
                            '7' => '7',
                            '6' => '6',
                            '5' => '5',
                            '4' => '4',
                            '3' => '3',
                            '2' => '2',
                            '1' => '1',
                            '0' => '0',
                        ]; ?>
                        <?= $form->field($model, 'field88')->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control'])->label(false) ?>
                    </td>
                    <td>
                        <?= $form->field($model, 'field89')->textInput(['class' => 'form-control'])->label(false) ?>
                    </td>
                </tr>
                <tr>
                    <td>информатика</td>
                    <td>
                        <? $items = [
                            '10' => '10',
                            '9' => '9',
                            '8' => '8',
                            '7' => '7',
                            '6' => '6',
                            '5' => '5',
                            '4' => '4',
                            '3' => '3',
                            '2' => '2',
                            '1' => '1',
                            '0' => '0',
                        ]; ?>
                        <?= $form->field($model, 'field90')->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control'])->label(false) ?>
                    </td>
                    <td>
                        <?= $form->field($model, 'field91')->textInput(['class' => 'form-control'])->label(false) ?>
                    </td>
                </tr>
                <tr>
                    <td>химия</td>
                    <td>
                        <? $items = [
                            '10' => '10',
                            '9' => '9',
                            '8' => '8',
                            '7' => '7',
                            '6' => '6',
                            '5' => '5',
                            '4' => '4',
                            '3' => '3',
                            '2' => '2',
                            '1' => '1',
                            '0' => '0',
                        ]; ?>
                        <?= $form->field($model, 'field92')->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control'])->label(false) ?>
                    </td>
                    <td>
                        <?= $form->field($model, 'field93')->textInput(['class' => 'form-control'])->label(false) ?>
                    </td>
                </tr>
            </table>
            <? $items = [
                'да' => 'да',
                'нет' => 'нет',
            ]; ?>
            <?= $form->field($model, 'field94', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

            <? $items = [
                'сократить количество уроков' => 'сократить количество уроков',
                'ввести сдвоенные уроки по большинству предметов' => 'ввести сдвоенные уроки по большинству предметов',
                'перейти на пятидневный режим обучения' => 'перейти на пятидневный режим обучения',
                'позднее начинать уроки' => 'позднее начинать уроки',
                'сократить продолжительность уроков' => 'сократить продолжительность уроков',
                'сократить объем домашних заданий' => 'сократить объем домашних заданий',
                'конкретизировать источники информации для подготовки домашних заданий' => 'конкретизировать источники информации для подготовки домашних заданий',
                'ни один из перечисленных вариантов не снизит избыточную нагрузку' => 'ни один из перечисленных вариантов не снизит избыточную нагрузку',
            ]; ?>
            <?= $form->field($model, 'field95', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>
        </div>

        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <?= $form->field($model, 'field96', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <? $items = [
            'да' => 'да',
            'нет' => 'нет',
        ]; ?>
        <?= $form->field($model, 'field97', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6']) ?>

        <div class="trtrtrtr">
            <div class="mt-5"><b><big>43. Изменялось ли в этот период время затрачиваемое Вами на:</big></b></div>
            <? $items = [
                'увеличилось' => 'увеличилось',
                'сократилось' => 'сократилось',
                'не изменилось' => 'не изменилось',
            ]; ?>
            <?= $form->field($model, 'field98', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('43.1. выполнение домашних заданий') ?>
            <? $items = [
                'увеличилось' => 'увеличилось',
                'сократилось' => 'сократилось',
                'не изменилось' => 'не изменилось',
            ]; ?>
            <?= $form->field($model, 'field99', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('43.2. прогулки') ?>
            <? $items = [
                'увеличилось' => 'увеличилось',
                'сократилось' => 'сократилось',
                'не изменилось' => 'не изменилось',
            ]; ?>
            <?= $form->field($model, 'field100', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('43.3. двигательную активность') ?>
            <? $items = [
                'увеличилось' => 'увеличилось',
                'сократилось' => 'сократилось',
                'не изменилось' => 'не изменилось',
            ]; ?>
            <?= $form->field($model, 'field101', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('43.4. сон') ?>
            <? $items = [
                'увеличилось' => 'увеличилось',
                'сократилось' => 'сократилось',
                'не изменилось' => 'не изменилось',
            ]; ?>
            <?= $form->field($model, 'field102', $two_column)->dropDownList($items, ['prompt' => 'Выберите...', 'class' => 'form-control col-6'])->label('43.5. общения с друзьями') ?>

        </div>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-block mt-3']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
<?php
$js = <<< JS
	//document.getElementById("btn").disabled = false;
  /*  $('#anketschoolchildrenkaz-region_id').attr('disabled', 'true');
    $('#anketschoolchildrenkaz-municipality_id').attr('disabled', 'true');*/
     
     //ИМт
        var weight = $('#anketschoolchildrenkaz-length'); //рост
        var growth = $('#anketschoolchildrenkaz-weight'); //масса тела
        var imt = 0;
    
        var payment_queteletIndex = function () {
            if (weight.val() !== '' && growth.val() !== '')
            {
                var weight2 = weight.val();
                //console.log('рост тела '+weight2+' в см');
                //console.log('рост тела '+weight2/100+' в м');
                //console.log('масса тела '+growth);        
                
                imt = growth.val()/((weight2)/100*(weight2)/100);
                imt = imt.toFixed(2)
                var str_imt = 'Ваш ИМТ: <b>'+imt +'';
                document.getElementById("imt").innerHTML = str_imt;
                
            }
            else {
               document.getElementById("imt").innerHTML = imt;
            }
        };
    
        weight.on('focusout', function () {
            setTimeout(payment_queteletIndex, 500)
        });
        growth.on('focusout', function () {
            setTimeout(payment_queteletIndex, 500)
        });
     
    //Выборка если казань то школы!!
    
     //var field_munici = $('#anketschoolchildrenkaz-municipality_id');
     //field_munici.on('change', function () {
     //       if (field_munici.val() === "2217" ) {
     //           $('.field-anketschoolchildrenkaz-school').hide();
     //           $('.field-anketschoolchildrenkaz-field103').show();
     //       }
     //       else{
     //        $('.field-anketschoolchildrenkaz-school').show();
     //           $('.field-anketschoolchildrenkaz-field103').hide();
     //       }
     //});
     //field_munici.trigger('change');
    
     
     
     //var field_field103 = $('#anketschoolchildrenkaz-field103');
     //field_field103.on('change', function () {
     //       if (field_field103.val() !== "Организации нет в списке" ) {
     //            $('.field-anketschoolchildrenkaz-school').hide();
     //       }
     //       else{
     //           $('.field-anketschoolchildrenkaz-school').show();
     //       }
     //});
     //field_field103.trigger('change');
     
     
     var field_field106 = $('#anketschoolchildrenkaz-field106');
     field_field106.on('change', function () {
            if (field_field106.val() !== "да" ) {
                $('.field-anketschoolchildrenkaz-field107').hide();
                $('.field-anketschoolchildrenkaz-field108').hide();
                $('.field-anketschoolchildrenkaz-field109').hide();
            }
            else{
               $('.field-anketschoolchildrenkaz-field107').show();
                $('.field-anketschoolchildrenkaz-field108').show();
                $('.field-anketschoolchildrenkaz-field109').show();
            }
     });
     field_field106.trigger('change');
    
     
     var field_field107 = $('#anketschoolchildrenkaz-field107');
     field_field107.on('change', function () {
            if (field_field107.val() === "один раз" ) {
                $('.field-anketschoolchildrenkaz-field108').show();
                $('.field-anketschoolchildrenkaz-field109').hide();
            } 
            else if (field_field107.val() === "два раза и более" ) {
                $('.field-anketschoolchildrenkaz-field108').hide();
                $('.field-anketschoolchildrenkaz-field109').show();
            }
            else{
               $('.field-anketschoolchildrenkaz-field108').hide();
               $('.field-anketschoolchildrenkaz-field109').hide();
            }
     });
     field_field107.trigger('change');
    
     
    var field_field110 = $('#anketschoolchildrenkaz-field110');
    field_field110.on('change', function () {
           if (field_field110.val() !== "да" ) {
               $('.field-anketschoolchildrenkaz-field111').hide();
           }
           else{
               $('.field-anketschoolchildrenkaz-field111').show();
           }
    });
    field_field110.trigger('change');
     
    var field_field96 = $('#anketschoolchildrenkaz-field96');
    field_field96.on('change', function () {
           if (field_field96.val() !== "да" ) {
               $('.field-anketschoolchildrenkaz-field97').hide();
               $('.trtrtrtr').hide();
           }
           else{
               $('.field-anketschoolchildrenkaz-field97').show();
               $('.trtrtrtr').show();
           }
    });
    field_field96.trigger('change');
    
    var field_change_train = $('#anketschoolchildrenkaz-change_training');
    field_change_train.on('change', function () {
           if (field_change_train.val() == "1") {
               
               $('.field-anketschoolchildrenkaz-field1').show();
               $('.field-anketschoolchildrenkaz-field2').hide();
           }
           else if (field_change_train.val() == "2"){
               $('.field-anketschoolchildrenkaz-field2').show();
               $('.field-anketschoolchildrenkaz-field1').hide();
           }
           else{
                $('.field-anketschoolchildrenkaz-field1').hide();
                $('.field-anketschoolchildrenkaz-field2').hide();
           }
    });
    field_change_train.trigger('change');
    
    
    var field_field16 = $('#anketschoolchildrenkaz-field16');
    field_field16.on('change', function () {
           if (field_field16.val() !== "да" ) {
               $('.field-anketschoolchildrenkaz-field17').hide();
               $('.field-anketschoolchildrenkaz-field18').hide();
               $('.field-anketschoolchildrenkaz-field19').hide();
           }
           else{
            $('.field-anketschoolchildrenkaz-field17').show();
               $('.field-anketschoolchildrenkaz-field18').show();
               $('.field-anketschoolchildrenkaz-field19').show();
           }
    });
    field_field16.trigger('change');
    
    var field_field20 = $('#anketschoolchildrenkaz-field20');
    field_field20.on('change', function () {
           if (field_field20.val() !== "да" ) {
               $('.field-anketschoolchildrenkaz-field21').hide();
               $('.field-anketschoolchildrenkaz-field22').hide();
           }
           else{
               $('.field-anketschoolchildrenkaz-field21').show();
               $('.field-anketschoolchildrenkaz-field22').show();
           }
    });
    field_field20.trigger('change');
    
    var field_field23 = $('#anketschoolchildrenkaz-field23');
    field_field23.on('change', function () {
           if (field_field23.val() !== "да" ) {
               $('.field-anketschoolchildrenkaz-field24').hide();
               $('.field-anketschoolchildrenkaz-field25').hide();
               $('.field-anketschoolchildrenkaz-field26').hide();
           }
           else{
               $('.field-anketschoolchildrenkaz-field24').show();
               $('.field-anketschoolchildrenkaz-field25').show();
               $('.field-anketschoolchildrenkaz-field26').show();
           }
    });
    field_field23.trigger('change');
    
    var field_class = $('#anketschoolchildrenkaz-class');
    field_class.on('change', function () {
           if (field_class.val() === "1" || field_class.val() === "2" || field_class.val() === "3" || field_class.val() === "4" || field_class.val() === "5") {
               $('.cls_6_11').hide();
               $('.cls_6_11_2').hide();
           }
           else{
               $('.cls_6_11').show();
               $('.cls_6_11_2').show();
           }
    });
    field_class.trigger('change');
    
    var field_field52 = $('#anketschoolchildrenkaz-field52');
    field_field52.on('change', function () {
           if (field_field52.val() !== "да" ) {
               $('.field-anketschoolchildrenkaz-field53').hide();
           }
           else{
               $('.field-anketschoolchildrenkaz-field53').show();
           }
    });
    field_field52.trigger('change');
    
    var field_field54 = $('#anketschoolchildrenkaz-field54');
    field_field54.on('change', function () {
           if (field_field54.val() !== "да" ) {
               $('.field-anketschoolchildrenkaz-field55').hide();
           }
           else{
               $('.field-anketschoolchildrenkaz-field55').show();
           }
    });
    field_field54.trigger('change');
    
    var field_field56 = $('#anketschoolchildrenkaz-field56');
    field_field56.on('change', function () {
           if (field_field56.val() !== "да" ) {
               $('.field-anketschoolchildrenkaz-field57').hide();
           }
           else{
               $('.field-anketschoolchildrenkaz-field57').show();
           }
    });
    field_field56.trigger('change');
    
    var field_field58 = $('#anketschoolchildrenkaz-field58');
    field_field58.on('change', function () {
           if (field_field58.val() !== "да" ) {
               $('.field-anketschoolchildrenkaz-field59').hide();
           }
           else{
               $('.field-anketschoolchildrenkaz-field59').show();
           }
    });
    field_field58.trigger('change');
    
    var field_field94 = $('#anketschoolchildrenkaz-field94');
    field_field94.on('change', function () {
           if (field_field94.val() !== "да" ) {
               $('.field-anketschoolchildrenkaz-field95').hide();
           }
           else{
               $('.field-anketschoolchildrenkaz-field95').show();
           }
    });
    field_field94.trigger('change');
JS;
$this->registerJs($js, \yii\web\View::POS_READY);