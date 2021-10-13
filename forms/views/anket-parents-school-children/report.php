<?php

use common\models\AnketParentsSchoolChildren;
use common\models\FederalDistrict;
use common\models\Region;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AnketPreschoolers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="anket-preschoolers-report-form container">
    <?php
    $form = ActiveForm::begin();
    $federal_district = FederalDistrict::find()->all();
    $federal_district_item = ArrayHelper::map($federal_district, 'id', 'name');

    $region = Region::find()->where(['district_id' => '1'])->all();
    $region_item = ArrayHelper::map($region, 'id', 'name');
    ?>

    <?php
    if (empty($district_for_district) && empty($region_for_district))
    {
        $district_for_district = 0;
        $region_for_district = 0;
    }
    $two_column = ['options' => ['class' => 'row mt-3'], 'labelOptions' => ['class' => 'col-4 col-form-label font-weight-bold']];
    ?>
    <?php $federal_district_item['0'] = 'Все'; ?>
    <?= $form->field($model, 'federal_district_id', $two_column)->dropDownList($federal_district_item,
        [
            'options' => [$district_for_district => ['Selected' => true]],
            'class' => 'form-control col-8'
        ]) ?>
    <?php $region_item['0'] = 'Все'; ?>
    <?= $form->field($model, 'region_id', $two_column)->dropDownList($region_item, ['options' => [$region_for_district => ['Selected' => true]], 'class' => 'form-control col-8']) ?>

    <div class="form-group row">
        <?= Html::submitButton('Показать', ['class' => 'btn main-color form-control col-12 mt-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<? if (!empty($districts))
{  ?>
    <?=Html::a('Скачать список в екселе', ['export-excel?federal_district_id=' . $district_for_district . '&region_id=' . $region_for_district], ['class' => 'btn btn-outline-secondary btn-sm be_export_ex_teacher',])?>


    <table class="table table-bordered table-sm table-responsive">
        <thead>
        <tr>
            <th class="text-center" rowspan="3" colspan="1">Федеральный округ</th>
            <th class="text-center" rowspan="3" colspan="1">Регион</th>
            <th class="text-center" rowspan="3" colspan="1">Школа</th>
            <th class="text-center" rowspan="1" colspan="4">Откуда Вы получаете или можете получить информацию о питании Вашего ребенка?
            </th>
            <th class="text-center" rowspan="1" colspan="12">Что, по Вашему мнению, больше всего нравится детям в школьной столовой?</th>
            <th class="text-center" rowspan="1" colspan="12">Что по Вашему мнению больше всего не нравится детям в школьной столовой?</th>
            <th class="text-center" rowspan="1" colspan="10">Оцените, насколько Вы удовлетворены питанием ребенка в школе? Оцените по 10-бальной системе (1 – минимум, 10 – максимум)</th>
        </tr>
        <tr>
            <th class="text-center" rowspan="2" colspan="1">от классного руководителя</th>
            <th class="text-center" rowspan="2" colspan="1">по рассказам ребенка</th>
            <th class="text-center" rowspan="2" colspan="1">информационная система (сайт школы)</th>
            <th class="text-center" rowspan="2" colspan="1">другое</th>
            <th class="text-center" rowspan="1" colspan="2">Еда вкусная</th>
            <th class="text-center" rowspan="1" colspan="2">Ребенку достаточно времени на прием пищи</th>
            <th class="text-center" rowspan="1" colspan="2">Меню достаточно разнообразно</th>
            <th class="text-center" rowspan="1" colspan="2">Есть возможность самостоятельного выбора блюд</th>
            <th class="text-center" rowspan="1" colspan="2">Всегда чистая посуда</th>
            <th class="text-center" rowspan="1" colspan="2">Столовая обладает достаточной площадью для комфортного питания детей</th>
            <th class="text-center" rowspan="1" colspan="2">Еда невкусная</th>
            <th class="text-center" rowspan="1" colspan="2">Ребенку недостаточно времени на прием пищи</th>
            <th class="text-center" rowspan="1" colspan="2">Меню однообразно</th>
            <th class="text-center" rowspan="1" colspan="2">Нет возможности самостоятельного выбора блюд</th>
            <th class="text-center" rowspan="1" colspan="2">Грязаня со сколами посуда</th>
            <th class="text-center" rowspan="1" colspan="2">Столовая маленькая, недостаточно места для комфортного размещения детей</th>
            <th class="text-center" rowspan="2" colspan="1">1</th>
            <th class="text-center" rowspan="2" colspan="1">2</th>
            <th class="text-center" rowspan="2" colspan="1">3</th>
            <th class="text-center" rowspan="2" colspan="1">4</th>
            <th class="text-center" rowspan="2" colspan="1">5</th>
            <th class="text-center" rowspan="2" colspan="1">6</th>
            <th class="text-center" rowspan="2" colspan="1">7</th>
            <th class="text-center" rowspan="2" colspan="1">8</th>
            <th class="text-center" rowspan="2" colspan="1">9</th>
            <th class="text-center" rowspan="2" colspan="1">10</th>
        </tr>
        <tr>
            <th class="text-center" rowspan="1">Да</th>
            <th class="text-center" rowspan="1">Нет</th>
            <th class="text-center" rowspan="1">Да</th>
            <th class="text-center" rowspan="1">Нет</th>
            <th class="text-center" rowspan="1">Да</th>
            <th class="text-center" rowspan="1">Нет</th>
            <th class="text-center" rowspan="1">Да</th>
            <th class="text-center" rowspan="1">Нет</th>
            <th class="text-center" rowspan="1">Да</th>
            <th class="text-center" rowspan="1">Нет</th>
            <th class="text-center" rowspan="1">Да</th>
            <th class="text-center" rowspan="1">Нет</th>
            <th class="text-center" rowspan="1">Да</th>
            <th class="text-center" rowspan="1">Нет</th>
            <th class="text-center" rowspan="1">Да</th>
            <th class="text-center" rowspan="1">Нет</th>
            <th class="text-center" rowspan="1">Да</th>
            <th class="text-center" rowspan="1">Нет</th>
            <th class="text-center" rowspan="1">Да</th>
            <th class="text-center" rowspan="1">Нет</th>
            <th class="text-center" rowspan="1">Да</th>
            <th class="text-center" rowspan="1">Нет</th>
            <th class="text-center" rowspan="1">Да</th>
            <th class="text-center" rowspan="1">Нет</th>
        </tr>
        </thead>
        <tbody>
        <?
        $array_org = array();
        $array_org[] = array();
        $array_reg = array();
        $array_reg[] = array();
        $array_fed = array();
        $array_fed[] = array();
        $array_result = array();
        $i = 0;
        $j = 0;
        $k = 0;

        //получили все федеральные округа
        $information = [['obtain_information', 4], ['delicious_food', 2], ['enough_time_eat', 2], ['menu_quite_diverse', 2], ['choice_dishes', 2], ['clean_dishes', 2], ['comfort_food_children', 2], ['not_delicious_food', 2], ['not_enough_time_eat', 2], ['not_menu_quite_diverse', 2], ['not_choice_dishes', 2], ['not_clean_dishes', 2], ['not_comfort_food_children', 2], ['rate_overall_satisfaction', 10]];
        //количество столбцов в таблице
        $count_col = array_sum(array_column($information, 1)) + 3;
        //$information = [['obtain_information', 3]];
        foreach ($districts as $district)//цикл по федеральному округу
        {
            if ($region_for_district == 0)
            {
                $regions = AnketParentsSchoolChildren::find()->select('region_id')->where(['federal_district_id' => $district->id])->groupBy('region_id')->all();//получили все регионы
            }
            else
            {
                $regions = AnketParentsSchoolChildren::find()->select('region_id')->where(['federal_district_id' => $district->id, 'region_id' => $region_for_district])->groupBy('region_id')->all();//получили все регионы
            }
            if ($regions)
            {
                foreach ($regions as $region)//цикл по регионам
                {
                    $querys = AnketParentsSchoolChildren::find()->select('school')->where(['region_id' => $region->region_id])->groupBy('school')->all();//получили все организации
                    if ($querys)
                    {
                        foreach ($querys as $query)//цикл по организации
                        {
                            //$tests = AnketPreschoolers::find()->where(['school'=>$query->school, 'region_id'=>$region->region_id])->all();
                            $tests = AnketParentsSchoolChildren::find()->where(['school' => $query->school, 'region_id' => $region->region_id])->all();
                            foreach ($tests as $test)
                            {
                                $array_org[$i][0] = $test->federal_district_id;
                                $array_org[$i][1] = $test->region_id;
                                $array_org[$i][2] = $test->school;
                                $array_reg[$j][0] = $test->federal_district_id;
                                $array_reg[$j][1] = $test->region_id;
                                $array_fed[$k][0] = $test->federal_district_id;
                                $element = 2;
                                for ($s = 0, $count_info = count($information); $count_info > 0; $count_info--, $s++)
                                {
                                    $var = $information[$s][1];
                                    for ($e = 0, $q = $var; $q > 0; $q--, $e++)
                                    {
                                        $element++;
                                        if ($test[$information[$s][0]] === $e)
                                        {
                                            $array_org[$i][$element]++;
                                            $array_reg[$j][$element]++;
                                            $array_fed[$k][$element]++;
                                            $array_result[$element]++;
                                        }
                                    }
                                }
                            }
                            $table = '<tr>';
                            $table .= '<td>' . $model->get_district_id($array_org[$i][0])->name . '</td>';
                            $table .= '<td>' . $model->get_region_id($array_org[$i][1])->name . '</td>';
                            $table .= '<td>' . $array_org[$i][2] . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][3]) ? $array_org[$i][3] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][4]) ? $array_org[$i][4] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][5]) ? $array_org[$i][5] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][6]) ? $array_org[$i][6] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][8]) ? $array_org[$i][8] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][7]) ? $array_org[$i][7] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][10]) ? $array_org[$i][10] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][9]) ? $array_org[$i][9] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][12]) ? $array_org[$i][12] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][11]) ? $array_org[$i][11] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][14]) ? $array_org[$i][14] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][13]) ? $array_org[$i][13] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][16]) ? $array_org[$i][16] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][15]) ? $array_org[$i][15] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][18]) ? $array_org[$i][18] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][17]) ? $array_org[$i][17] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][20]) ? $array_org[$i][20] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][19]) ? $array_org[$i][19] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][22]) ? $array_org[$i][22] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][21]) ? $array_org[$i][21] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][24]) ? $array_org[$i][24] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][23]) ? $array_org[$i][23] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][26]) ? $array_org[$i][26] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][25]) ? $array_org[$i][25] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][28]) ? $array_org[$i][28] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][27]) ? $array_org[$i][27] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][30]) ? $array_org[$i][30] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][29]) ? $array_org[$i][29] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][31]) ? $array_org[$i][31] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][32]) ? $array_org[$i][32] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][33]) ? $array_org[$i][33] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][34]) ? $array_org[$i][34] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][35]) ? $array_org[$i][35] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][36]) ? $array_org[$i][36] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][37]) ? $array_org[$i][37] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][38]) ? $array_org[$i][38] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][39]) ? $array_org[$i][39] : 0) . '</td>';
                            $table .= '<td>' . (isset($array_org[$i][40]) ? $array_org[$i][40] : 0) . '</td>';
                            $table .= '</tr>';
                            echo $table;
                            $i++;
                        }
                        $table = '<tr class="main-color-3">';
                        $table .= '<td>' . $model->get_district_id($array_reg[$j][0])->name . '</td>';
                        $table .= '<td colspan="2">' . $model->get_region_id($array_reg[$j][1])->name . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][3]) ? $array_reg[$j][3] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][4]) ? $array_reg[$j][4] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][5]) ? $array_reg[$j][5] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][6]) ? $array_reg[$j][6] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][8]) ? $array_reg[$j][8] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][7]) ? $array_reg[$j][7] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][10]) ? $array_reg[$j][10] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][9]) ? $array_reg[$j][9] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][12]) ? $array_reg[$j][12] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][11]) ? $array_reg[$j][11] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][14]) ? $array_reg[$j][14] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][13]) ? $array_reg[$j][13] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][16]) ? $array_reg[$j][16] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][15]) ? $array_reg[$j][15] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][18]) ? $array_reg[$j][18] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][17]) ? $array_reg[$j][17] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][20]) ? $array_reg[$j][20] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][19]) ? $array_reg[$j][19] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][22]) ? $array_reg[$j][22] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][21]) ? $array_reg[$j][21] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][24]) ? $array_reg[$j][24] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][23]) ? $array_reg[$j][23] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][26]) ? $array_reg[$j][26] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][25]) ? $array_reg[$j][25] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][28]) ? $array_reg[$j][28] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][27]) ? $array_reg[$j][27] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][30]) ? $array_reg[$j][30] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][29]) ? $array_reg[$j][29] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][31]) ? $array_reg[$j][31] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][32]) ? $array_reg[$j][32] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][33]) ? $array_reg[$j][33] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][34]) ? $array_reg[$j][34] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][35]) ? $array_reg[$j][35] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][36]) ? $array_reg[$j][36] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][37]) ? $array_reg[$j][37] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][38]) ? $array_reg[$j][38] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][39]) ? $array_reg[$j][39] : 0) . '</td>';
                        $table .= '<td>' . (isset($array_reg[$j][40]) ? $array_reg[$j][40] : 0) . '</td>';
                        $table .= '</tr>';
                        echo $table;
                        $j++;
                    }
                }
                if ($region_for_district == 0)
                {
                    $table = '<tr class="main-color">';
                    $table .= '<td colspan="3">' . $model->get_district_id($district->id)->name . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][3]) ? $array_fed[$k][3] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][4]) ? $array_fed[$k][4] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][5]) ? $array_fed[$k][5] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][6]) ? $array_fed[$k][6] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][8]) ? $array_fed[$k][8] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][7]) ? $array_fed[$k][7] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][10]) ? $array_fed[$k][10] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][9]) ? $array_fed[$k][9] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][12]) ? $array_fed[$k][12] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][11]) ? $array_fed[$k][11] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][14]) ? $array_fed[$k][14] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][13]) ? $array_fed[$k][13] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][16]) ? $array_fed[$k][16] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][15]) ? $array_fed[$k][15] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][18]) ? $array_fed[$k][18] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][17]) ? $array_fed[$k][17] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][20]) ? $array_fed[$k][20] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][19]) ? $array_fed[$k][19] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][22]) ? $array_fed[$k][22] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][21]) ? $array_fed[$k][21] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][24]) ? $array_fed[$k][24] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][23]) ? $array_fed[$k][23] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][26]) ? $array_fed[$k][26] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][25]) ? $array_fed[$k][25] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][28]) ? $array_fed[$k][28] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][27]) ? $array_fed[$k][27] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][30]) ? $array_fed[$k][30] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][29]) ? $array_fed[$k][29] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][31]) ? $array_fed[$k][31] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][32]) ? $array_fed[$k][32] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][33]) ? $array_fed[$k][33] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][34]) ? $array_fed[$k][34] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][35]) ? $array_fed[$k][35] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][36]) ? $array_fed[$k][36] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][37]) ? $array_fed[$k][37] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][38]) ? $array_fed[$k][38] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][39]) ? $array_fed[$k][39] : 0) . '</td>';
                    $table .= '<td>' . (isset($array_fed[$k][40]) ? $array_fed[$k][40] : 0) . '</td>';
                    $table .= '</tr>';
                    echo $table;
                }
                $k++;
            }
            else
            {
               /*//нули по округам
                $table = '<tr class="bg-primary">';
                $table .= '<td colspan="3">' . $model->get_district_id($district->id)->name . '</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '<td>0</td>';
                $table .= '</tr>';
                echo $table;*/
            }
        }
        $table = '<tr class="main-color-2">';
        $table .= '<td colspan="3">Итого</td>';
        $table .= '<td>' . (isset($array_result[3]) ? $array_result[3] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[4]) ? $array_result[4] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[5]) ? $array_result[5] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[6]) ? $array_result[6] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[8]) ? $array_result[8] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[7]) ? $array_result[7] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[10]) ? $array_result[10] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[9]) ? $array_result[9] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[12]) ? $array_result[12] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[11]) ? $array_result[11] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[14]) ? $array_result[14] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[13]) ? $array_result[13] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[16]) ? $array_result[16] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[15]) ? $array_result[15] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[18]) ? $array_result[18] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[17]) ? $array_result[17] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[20]) ? $array_result[20] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[19]) ? $array_result[19] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[22]) ? $array_result[22] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[21]) ? $array_result[21] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[24]) ? $array_result[24] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[23]) ? $array_result[23] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[26]) ? $array_result[26] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[25]) ? $array_result[25] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[28]) ? $array_result[28] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[27]) ? $array_result[27] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[30]) ? $array_result[30] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[29]) ? $array_result[29] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[31]) ? $array_result[31] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[32]) ? $array_result[32] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[33]) ? $array_result[33] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[34]) ? $array_result[34] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[35]) ? $array_result[35] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[36]) ? $array_result[36] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[37]) ? $array_result[37] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[38]) ? $array_result[38] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[39]) ? $array_result[39] : 0) .'</td>';
        $table .= '<td>' . (isset($array_result[40]) ? $array_result[40] : 0) .'</td>';
        $table .= '</tr>';
        echo $table;
        ?>
        </tbody>
    </table>
    <?
}
?>
<?
$script = <<< JS
$('#anketparentsschoolchildren-federal_district_id').change(function() {
    var value = $('#anketparentsschoolchildren-federal_district_id option:selected').val();
    $.ajax({
         url: "../anket-preschoolers/search",
              type: "GET",      // тип запроса
              data: { // действия
                  'id': value
              },
              // Данные пришли
              success: function( data ) {
                  $("#anketparentsschoolchildren-region_id").empty();
                  $("#anketparentsschoolchildren-region_id").append(data);
                
              }
         })
});
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>