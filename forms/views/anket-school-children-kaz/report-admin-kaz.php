<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AnketSchoolChildrenKaz */

$this->title = 'Результаты анкетирования «Характеристика питания и пищевые привычки школьников» (на примере обычного учебного дня)';
$this->params['breadcrumbs'][] = ['label' => 'Anket School Children Kazs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$two_column = ['options' => ['class' => 'row mt-3'], 'labelOptions' => ['class' => 'col-6 col-form-label font-weight-bold']];

if($post == '144'){
    $strol_class = '1100';
}
if($post == '7'){
    $strol_class = '914';
}
if($post == '168'){
    $strol_class = '210';
}
if($post == '68'){
    $strol_class = '625';
}
if($post == '65'){
    $strol_class = '447';
}
?>
<div class="anket-school-children-kaz-create container">

    <h1 align="center"><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>
    <? $items = [
        '144' => '144',
        '7' => '7',
        '168' => '168',
        '68' => '68',
        '65' => '65',
    ]; ?>
    <?= $form->field($model, 'field103', $two_column)->dropDownList($items, ['class' => 'form-control col-6', 'options' => [$post => ['Selected' => true]]])->label('Выберите номер школы') ?>
    <div class="form-group">
        <?= Html::submitButton('Показать', ['class' => 'btn btn-success btn-block mt-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?if(!empty($post)){
        if(!empty($anket)){
            echo "<script>var name='$post';</script>";
            $table = '';
            $gar_v = 0;
            $dif_v = 0;
            $izb_v = 0;
            $ojir_v = 0;
            $vseg_v = 0;
            foreach ($anket as $anketa){
                /*print_r($anketa['class']);
                print_r('<br>');*/
                $anket_a_bs = \common\models\AnketSchoolChildrenKaz::find()
                    ->select(['id','class_a_b'])
                    ->where(['federal_district_id' => 2])
                    ->andWhere(['region_id' => 20])
                    ->andWhere(['municipality_id' => 2217])
                    ->andWhere(['field103' => $post])
                    ->andWhere(['class' => $anketa['class']])
                    ->orderBy("class_a_b ASC")
                    ->groupBy("class_a_b")->all();


                foreach ($anket_a_bs as $anket_a_b){
                    $gar = 0;
                    $dif = 0;
                    $izb = 0;
                    $ojir = 0;
                    $vseg = 0;
                    $anks = \common\models\AnketSchoolChildrenKaz::find()
                        ->where(['federal_district_id' => 2])
                        ->andWhere(['region_id' => 20])
                        ->andWhere(['municipality_id' => 2217])
                        ->andWhere(['field103' => $post])
                        ->andWhere(['class' => $anketa['class']])
                        ->andWhere(['class_a_b' => $anket_a_b['class_a_b']])
                        ->all();
                    foreach ($anks as $ank){
                        $weight = $ank['weight']; //10. Укажите массу тела (кг)
                        $growth = $ank['length']; //10.1 Укажите длину тела в см
                        $sex = $ank['sex']; //пол
                        $age = $ank['age']; //возраст

                        if (!is_numeric($weight)) {
                            $weight = 1;
                        }
                        if (!is_numeric($growth)) {
                            $growth = 1;
                        }
                        if (!is_numeric($age)) {
                            $age = 1;
                        }
                        $imt = $model->get_imt2($growth, $weight, 2,$sex,$age,1);

                        $imt_str = '';
                        if($imt == 'Дефицит массы тела'){
                            $dif++;
                            //$imt_str = 'отмечается дефицит массы';
                        }
                        elseif($imt == 'Нормальный вес'){
                            $gar++;
                        }
                        elseif($imt == 'Избыточная масса тела'){
                            $izb++;
                            //$imt_str = 'отмечается избыток массы';
                        }
                        elseif($imt == 'Ожирение'){
                            $ojir++;
                            //$imt_str = 'отмечается ожирение';
                        }
                        $vseg++;
                    }

                    $rec = $dif+$izb+$ojir;
                    $table .= '
                        <tr>
                            <td>'.$anketa['class'].'</td>
                            <td>'.$anket_a_b['class_a_b'].'</td>
                            <td class="text-center">'.$vseg.'</td>
                            <td>'.$dif.'</td>
                            <td>'.$gar.'</td>
                            <td>'.$izb.'</td>
                            <td>'.$ojir.'</td>
                            <td class="text-center">'.$rec.'</td>
                            <td class="text-center">'.$vseg.'</td>
                        </tr>
                    ';
                    $dif_v = $dif_v+$dif;
                    $izb_v = $izb_v+$izb;
                    $ojir_v = $ojir_v+$ojir;
                    $gar_v = $gar_v+$gar;
                    $vseg_v = $vseg_v +$vseg;

                }

            }?>
            <?$efefe = $dif_v+$izb_v+$ojir_v?>
            <input type="button" class="btn btn-warning btn-block table2excel mb-3 mt-3"
                   title="Вы можете скачать в формате Excel" value="Скачать в Excel" id="pechat222">

            <h4 class="text-center">Школа № <?=$post?>, количество учеников в школе: <?=$strol_class?></h4>
            <div class="table-responsive">
                <table id="tableId" class="table table-bordered table-sm table2excel_with_colors">
                <tr>
                    <th class="text-center" rowspan="2">Класс</th>
                    <th class="text-center" rowspan="2">Буква</th>
                    <th class="text-center" rowspan="2">Проанкетировано</th>
                    <th class="text-center" colspan="4">ИМТ</th>
                    <th class="text-center" rowspan="2">Всего дано рекомендаций по питанию</th>
                    <th class="text-center" rowspan="2">Всего дано общих рекомендаций</th>
                </tr>
                <tr>
                    <th>Дефицит массы тела</th>
                    <th>Нормальная масса тела</th>
                    <th>Избыток массы тела</th>
                    <th>Ожирение</th>
                </tr>
                <?echo $table;?>
                <tr>
                    <td colspan="2"><b>Итого</b></td>
                    <td class="text-center"><?=$vseg_v?></td>
                    <td class="text-center"><?=$dif_v?></td>
                    <td class="text-center"><?=$gar_v?></td>
                    <td class="text-center"><?=$izb_v?></td>
                    <td class="text-center"><?=$ojir_v?></td>
                    <td class="text-center"><?=$efefe?></td>
                    <td class="text-center"><?=$vseg_v?></td>
                </tr>
            </table>
            </div>
        <?}else{?>
            Данных не найдено!
        <?}?>
     <?}?>
</div>

<?

$script = <<< JS
    $("#pechat222").click(function () {
    var table = $('#tableId');
        if (table && table.length) {
            var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
            $(table).table2excel({
                exclude: ".noExl",
                name: "Excel Document Name",
                filename: "Данные по результатм анкетирования школы № "+name+".xls",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true,
                preserveColors: preserveColors
            });
        }
    });

JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>