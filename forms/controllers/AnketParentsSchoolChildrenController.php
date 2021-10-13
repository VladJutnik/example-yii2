<?php

namespace backend\controllers;

use common\models\AnketPreschoolers;
use common\models\FederalDistrict;
use common\models\Region;
use Yii;
use common\models\AnketParentsSchoolChildren;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AnketParentsSchoolChildrenController implements the CRUD actions for AnketParentsSchoolChildren model.
 */
class AnketParentsSchoolChildrenController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Creates a new AnketParentsSchoolChildren model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AnketParentsSchoolChildren();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the AnketParentsSchoolChildren model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AnketParentsSchoolChildren the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AnketParentsSchoolChildren::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSearch($id)
    {
        $groups = Region::find()->where(['district_id'=>$id])->all();
        $json = array();
        if(!empty($groups)){
            foreach ($groups as $key => $group) {
                $json .= "<option value='{$group->id}'>{$group->name}</option>";
            }

        }
        else {
            $json .= '<option value=""></option>';
        }
        return $json;
    }

    public function actionReport()
    {
        $model = new AnketParentsSchoolChildren();
        if (Yii::$app->request->post()) {

            $district = Yii::$app->request->post()['AnketParentsSchoolChildren']['federal_district_id'];
            $district_for_district = $district;
            $region_for_district = Yii::$app->request->post()['AnketParentsSchoolChildren']['region_id'];

            if($district == 0) {
                $districts = FederalDistrict::find()->all();
            } else {
                $districts = FederalDistrict::find()->where(['id'=>$district])->all();
            }

            return $this->render('report', [
                'districts' => $districts,
                'model' => $model,
                'district_for_district' => $district_for_district,
                'region_for_district' => $region_for_district
            ]);
        }
        return $this->render('report',
            [
                'model' => $model
            ]);
    }

    public function actionExportExcel($federal_district_id, $region_id)
    {
        $model = new AnketParentsSchoolChildren();
        require_once Yii::$app->basePath . '\Excel\PHPExcel.php';
        require_once Yii::$app->basePath . '\Excel\PHPExcel\IOFactory.php';
        require_once Yii::$app->basePath . '\Excel\PHPExcel\Style\Alignment.php';
        $district = $federal_district_id;
        if ($district == 0)
        {
            $districts = FederalDistrict::find()->all();
        }
        else
        {
            $districts = FederalDistrict::find()->where(['id' => $district])->all();
        }
        //print_r($districts);
        //exit();
        $document = new \PHPExcel();
        //подгружаем готовый шаблон !!!!
        //$document = \PHPExcel_IOFactory::load('../web/images/generator.xlsx');
        $style = array(
            'font' => array(
                'name' => 'Times New Roman',
                'size' => 12,
                //'color'     => array('rgb' => 'FF0000'),
                'bold' => true,
                //'italic'    => true,
                //'underline' => true,
                //'strike'    => true,
            )
        );
        $style2 = array(
            'font' => array(
                'name' => 'Times New Roman',
                'size' => 12,
                //'color'     => array('rgb' => 'FF0000'),
                //'bold' => true,
                //'italic'    => true,
                //'underline' => true,
                //'strike'    => true,
            )
        );
        $style_fed = array(
            'font' => array(
                'name' => 'Times New Roman',
                'size' => 12,
                'color'     => array('rgb' => '2F6169'),
                //'bold' => true,
                //'italic'    => true,
                //'underline' => true,
                //'strike'    => true,
            )
        );
        $style_itog = array(
            'font' => array(
                'name' => 'Times New Roman',
                'size' => 12,
                'color'     => array('rgb' => 'EFA94A'),
                //'bold' => true,
                //'italic'    => true,
                //'underline' => true,
                //'strike'    => true,
            )
        );
        $sheet = $document->getActiveSheet();
        $sheet->mergeCells("A1:A3");
        $sheet->setCellValue("A1", "Федеральный округ");
        $sheet->mergeCells("B1:B3");
        $sheet->setCellValue("B1", "Регион");
        $sheet->mergeCells("C1:C3");
        $sheet->setCellValue("C1", "Школа");
        $sheet->mergeCells("D1:S1");
        $sheet->setCellValue("D1", "2. Что, по Вашему мнению, больше всего нравится детям в школьной столовой?");
        $sheet->mergeCells("D2:E2");
        $sheet->setCellValue("D2", "2.1 Вкусная еда");
        $sheet->setCellValue("D3", "Да");
        $sheet->setCellValue("E3", "Нет");
        $sheet->mergeCells("F2:G2");
        $sheet->setCellValue("F2", "2.2 Еда всегда теплая");
        $sheet->setCellValue("F3", "Да");
        $sheet->setCellValue("G3", "Нет");
        $sheet->mergeCells("H2:I2");
        $sheet->setCellValue("H2", "2.3 Достаточно времени для того чтобы поесть");
        $sheet->setCellValue("H3", "Да");
        $sheet->setCellValue("I3", "Нет");
        $sheet->mergeCells("J2:K2");
        $sheet->setCellValue("J2", "2.4 Меню разнообразно");
        $sheet->setCellValue("J3", "Да");
        $sheet->setCellValue("K3", "Нет");
        $sheet->mergeCells("L2:M2");
        $sheet->setCellValue("L2", "2.5 Есть возможность самостоятельного выбора блюд");
        $sheet->setCellValue("L3", "Да");
        $sheet->setCellValue("M3", "Нет");
        $sheet->mergeCells("N2:O2");
        $sheet->setCellValue("N2", "2.6 Всегда чистая посуда");
        $sheet->setCellValue("N3", "Да");
        $sheet->setCellValue("O3", "Нет");
        $sheet->mergeCells("P2:Q2");
        $sheet->setCellValue("P2", "2.7 В столовой достаточно места для комфортного питания");
        $sheet->setCellValue("P3", "Да");
        $sheet->setCellValue("Q3", "Нет");
        $sheet->mergeCells("R2:S2");
        $sheet->setCellValue("R2", "2.8 Дети питаются всем классом");
        $sheet->setCellValue("R3", "Да");
        $sheet->setCellValue("S3", "Нет");
        $sheet->mergeCells("T1:AG1");
        $sheet->setCellValue("T1", "3. Что по Вашему мнению больше всего не нравится детям в школьной столовой?");
        $sheet->mergeCells("AH1:AQ1");
        $sheet->mergeCells("T2:U2");
        $sheet->setCellValue("T2", "3.1 Еда невкусная");
        $sheet->setCellValue("T3", "Да");
        $sheet->setCellValue("U3", "Нет");
        $sheet->mergeCells("V2:W2");
        $sheet->setCellValue("V2", "3.2 Еду подают холодной");
        $sheet->setCellValue("V3", "Да");
        $sheet->setCellValue("W3", "Нет");
        $sheet->mergeCells("X2:Y2");
        $sheet->setCellValue("X2", "3.3 Дети не успеваю поесть, т.к. времени на перемене недостаточно");
        $sheet->setCellValue("X3", "Да");
        $sheet->setCellValue("Y3", "Нет");
        $sheet->mergeCells("Z2:AA2");
        $sheet->setCellValue("Z2", "3.4 Однообразное меню");
        $sheet->setCellValue("Z3", "Да");
        $sheet->setCellValue("AA3", "Нет");
        $sheet->mergeCells("AB2:AC2");
        $sheet->setCellValue("AB2", "3.5 Отсутствует возможность самостоятельного выбора блюд");
        $sheet->setCellValue("AB3", "Да");
        $sheet->setCellValue("AC3", "Нет");
        $sheet->mergeCells("AD2:AE2");
        $sheet->setCellValue("AD2", "3.6 Не всегда чистая посуда");
        $sheet->setCellValue("AD3", "Да");
        $sheet->setCellValue("AE3", "Нет");
        $sheet->mergeCells("AF2:AG2");
        $sheet->setCellValue("R2", "3.7 Большое количество одновременно питающихся детей, недостаточно места");
        $sheet->setCellValue("AF3", "Да");
        $sheet->setCellValue("AG3", "Нет");
        $sheet->setCellValue("AH1", "Удовлетворены ли Вы питанием ребенка детском саду? Оцените по 10-бальной системе (1 – минимум, 10 – максимум)");
        $sheet->mergeCells("AH2:AH3");
        $sheet->setCellValue("AH2", "1");
        $sheet->mergeCells("AI2:AI3");
        $sheet->setCellValue("AI2", "2");
        $sheet->mergeCells("AJ2:AJ3");
        $sheet->setCellValue("AJ2", "3");
        $sheet->mergeCells("AK2:AK3");
        $sheet->setCellValue("AK2", "4");
        $sheet->mergeCells("AL2:AL3");
        $sheet->setCellValue("AL2", "5");
        $sheet->mergeCells("AM2:AM3");
        $sheet->setCellValue("AM2", "6");
        $sheet->mergeCells("AN2:AN3");
        $sheet->setCellValue("AN2", "7");
        $sheet->mergeCells("AO2:AO3");
        $sheet->setCellValue("AO2", "8");
        $sheet->mergeCells("AP2:AP3");
        $sheet->setCellValue("AP2", "9");
        $sheet->mergeCells("AQ2:AQ3");
        $sheet->setCellValue("AQ2", "10");
        $sheet->getStyle('A1:AQ3')->applyFromArray($style);
        $sheet->getRowDimension("2")->setRowHeight(50);
        $sheet->getStyle("A1:AQ3")->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension("A")->setWidth(45);
        $sheet->getColumnDimension("B")->setWidth(30);
        $sheet->getColumnDimension("C")->setWidth(35);

        //$sheet->getStyle("A1:AH3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
        $numRow = 4;
        $information = [['obtain_information', 4], ['delicious_food', 2], ['enough_time_eat', 2], ['menu_quite_diverse', 2], ['choice_dishes', 2], ['clean_dishes', 2], ['comfort_food_children', 2], ['not_delicious_food', 2], ['not_enough_time_eat', 2], ['not_menu_quite_diverse', 2], ['not_choice_dishes', 2], ['not_clean_dishes', 2], ['not_comfort_food_children', 2], ['rate_overall_satisfaction', 10]];
        //количество столбцов в таблице
        $count_col = array_sum(array_column($information, 1)) + 3;
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
                            //$tests = AnketPreschoolers::find()->where(['kindergarten'=>$query->kindergarten, 'region_id'=>$region->region_id])->all();
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
                            $sheet->setCellValue('A' . $numRow, $model->get_district_id($array_org[$i][0])->name);
                            $sheet->setCellValue('B' . $numRow, $model->get_region_id($array_org[$i][1])->name);
                            $sheet->setCellValue('C' . $numRow, $array_org[$i][2]);
                            $sheet->setCellValue('D' . $numRow, (isset($array_org[$i][4]) ? $array_org[$i][4] : 0));
                            $sheet->setCellValue('E' . $numRow, (isset($array_org[$i][3]) ? $array_org[$i][3] : 0));
                            $sheet->setCellValue('F' . $numRow, (isset($array_org[$i][6]) ? $array_org[$i][6] : 0));
                            $sheet->setCellValue('G' . $numRow, (isset($array_org[$i][5]) ? $array_org[$i][5] : 0));
                            $sheet->setCellValue('H' . $numRow, (isset($array_org[$i][8]) ? $array_org[$i][8] : 0));
                            $sheet->setCellValue('I' . $numRow, (isset($array_org[$i][7]) ? $array_org[$i][7] : 0));
                            $sheet->setCellValue('J' . $numRow, (isset($array_org[$i][10]) ? $array_org[$i][10] : 0));
                            $sheet->setCellValue('K' . $numRow, (isset($array_org[$i][9]) ? $array_org[$i][9] : 0));
                            $sheet->setCellValue('L' . $numRow, (isset($array_org[$i][12]) ? $array_org[$i][12] : 0));
                            $sheet->setCellValue('M' . $numRow, (isset($array_org[$i][11]) ? $array_org[$i][11] : 0));
                            $sheet->setCellValue('N' . $numRow, (isset($array_org[$i][14]) ? $array_org[$i][14] : 0));
                            $sheet->setCellValue('O' . $numRow, (isset($array_org[$i][13]) ? $array_org[$i][13] : 0));
                            $sheet->setCellValue('P' . $numRow, (isset($array_org[$i][16]) ? $array_org[$i][16] : 0));
                            $sheet->setCellValue('Q' . $numRow, (isset($array_org[$i][15]) ? $array_org[$i][15] : 0));
                            $sheet->setCellValue('R' . $numRow, (isset($array_org[$i][18]) ? $array_org[$i][18] : 0));
                            $sheet->setCellValue('S' . $numRow, (isset($array_org[$i][17]) ? $array_org[$i][17] : 0));
                            $sheet->setCellValue('T' . $numRow, (isset($array_org[$i][20]) ? $array_org[$i][20] : 0));
                            $sheet->setCellValue('U' . $numRow, (isset($array_org[$i][19]) ? $array_org[$i][19] : 0));
                            $sheet->setCellValue('V' . $numRow, (isset($array_org[$i][22]) ? $array_org[$i][22] : 0));
                            $sheet->setCellValue('W' . $numRow, (isset($array_org[$i][21]) ? $array_org[$i][21] : 0));
                            $sheet->setCellValue('X' . $numRow, (isset($array_org[$i][24]) ? $array_org[$i][24] : 0));
                            $sheet->setCellValue('Y' . $numRow, (isset($array_org[$i][23]) ? $array_org[$i][23] : 0));
                            $sheet->setCellValue('Z' . $numRow, (isset($array_org[$i][26]) ? $array_org[$i][26] : 0));
                            $sheet->setCellValue('AA' . $numRow, (isset($array_org[$i][25]) ? $array_org[$i][25] : 0));
                            $sheet->setCellValue('AB' . $numRow, (isset($array_org[$i][28]) ? $array_org[$i][28] : 0));
                            $sheet->setCellValue('AC' . $numRow, (isset($array_org[$i][27]) ? $array_org[$i][27] : 0));
                            $sheet->setCellValue('AD' . $numRow, (isset($array_org[$i][30]) ? $array_org[$i][30] : 0));
                            $sheet->setCellValue('AE' . $numRow, (isset($array_org[$i][29]) ? $array_org[$i][29] : 0));
                            $sheet->setCellValue('AF' . $numRow, (isset($array_org[$i][32]) ? $array_org[$i][32] : 0));
                            $sheet->setCellValue('AG' . $numRow, (isset($array_org[$i][31]) ? $array_org[$i][31] : 0));
                            $sheet->setCellValue('AH' . $numRow, (isset($array_org[$i][33]) ? $array_org[$i][33] : 0));
                            $sheet->setCellValue('AI' . $numRow, (isset($array_org[$i][34]) ? $array_org[$i][34] : 0));
                            $sheet->setCellValue('AJ' . $numRow, (isset($array_org[$i][35]) ? $array_org[$i][35] : 0));
                            $sheet->setCellValue('AK' . $numRow, (isset($array_org[$i][36]) ? $array_org[$i][36] : 0));
                            $sheet->setCellValue('AL' . $numRow, (isset($array_org[$i][37]) ? $array_org[$i][37] : 0));
                            $sheet->setCellValue('AM' . $numRow, (isset($array_org[$i][38]) ? $array_org[$i][38] : 0));
                            $sheet->setCellValue('AN' . $numRow, (isset($array_org[$i][39]) ? $array_org[$i][39] : 0));
                            $sheet->setCellValue('AO' . $numRow, (isset($array_org[$i][40]) ? $array_org[$i][40] : 0));
                            $sheet->setCellValue('AP' . $numRow, (isset($array_org[$i][41]) ? $array_org[$i][41] : 0));
                            $sheet->setCellValue('AQ' . $numRow, (isset($array_org[$i][42]) ? $array_org[$i][42] : 0));
                            $i++;
                            $numRow++;
                        }
                        //вывод по региону
                        $sheet->setCellValue('A' . $numRow, $model->get_district_id($array_reg[$j][0])->name);
                        //$sheet->mergeCells('B' . $numRow . ':С' . $numRow);
                        $sheet->setCellValue('B' . $numRow, $model->get_region_id($array_reg[$j][1])->name);
                        $sheet->setCellValue('D' . $numRow, (isset($array_reg[$j][4]) ? $array_reg[$j][4] : 0));
                        $sheet->setCellValue('E' . $numRow, (isset($array_reg[$j][3]) ? $array_reg[$j][3] : 0));
                        $sheet->setCellValue('F' . $numRow, (isset($array_reg[$j][6]) ? $array_reg[$j][6] : 0));
                        $sheet->setCellValue('G' . $numRow, (isset($array_reg[$j][5]) ? $array_reg[$j][5] : 0));
                        $sheet->setCellValue('H' . $numRow, (isset($array_reg[$j][8]) ? $array_reg[$j][8] : 0));
                        $sheet->setCellValue('I' . $numRow, (isset($array_reg[$j][7]) ? $array_reg[$j][7] : 0));
                        $sheet->setCellValue('J' . $numRow, (isset($array_reg[$j][10]) ? $array_reg[$j][10] : 0));
                        $sheet->setCellValue('K' . $numRow, (isset($array_reg[$j][9]) ? $array_reg[$j][9] : 0));
                        $sheet->setCellValue('L' . $numRow, (isset($array_reg[$j][12]) ? $array_reg[$j][12] : 0));
                        $sheet->setCellValue('M' . $numRow, (isset($array_reg[$j][11]) ? $array_reg[$j][11] : 0));
                        $sheet->setCellValue('N' . $numRow, (isset($array_reg[$j][14]) ? $array_reg[$j][14] : 0));
                        $sheet->setCellValue('O' . $numRow, (isset($array_reg[$j][13]) ? $array_reg[$j][13] : 0));
                        $sheet->setCellValue('P' . $numRow, (isset($array_reg[$j][16]) ? $array_reg[$j][16] : 0));
                        $sheet->setCellValue('Q' . $numRow, (isset($array_reg[$j][15]) ? $array_reg[$j][15] : 0));
                        $sheet->setCellValue('R' . $numRow, (isset($array_reg[$j][18]) ? $array_reg[$j][18] : 0));
                        $sheet->setCellValue('S' . $numRow, (isset($array_reg[$j][17]) ? $array_reg[$j][17] : 0));
                        $sheet->setCellValue('T' . $numRow, (isset($array_reg[$j][20]) ? $array_reg[$j][20] : 0));
                        $sheet->setCellValue('U' . $numRow, (isset($array_reg[$j][19]) ? $array_reg[$j][19] : 0));
                        $sheet->setCellValue('V' . $numRow, (isset($array_reg[$j][22]) ? $array_reg[$j][22] : 0));
                        $sheet->setCellValue('W' . $numRow, (isset($array_reg[$j][21]) ? $array_reg[$j][21] : 0));
                        $sheet->setCellValue('X' . $numRow, (isset($array_reg[$j][24]) ? $array_reg[$j][24] : 0));
                        $sheet->setCellValue('Y' . $numRow, (isset($array_reg[$j][23]) ? $array_reg[$j][23] : 0));
                        $sheet->setCellValue('Z' . $numRow, (isset($array_reg[$j][26]) ? $array_reg[$j][26] : 0));
                        $sheet->setCellValue('AA' . $numRow, (isset($array_reg[$j][25]) ? $array_reg[$j][25] : 0));
                        $sheet->setCellValue('AB' . $numRow, (isset($array_reg[$j][28]) ? $array_reg[$j][28] : 0));
                        $sheet->setCellValue('AC' . $numRow, (isset($array_reg[$j][27]) ? $array_reg[$j][27] : 0));
                        $sheet->setCellValue('AD' . $numRow, (isset($array_reg[$j][30]) ? $array_reg[$j][30] : 0));
                        $sheet->setCellValue('AE' . $numRow, (isset($array_reg[$j][29]) ? $array_reg[$j][29] : 0));
                        $sheet->setCellValue('AF' . $numRow, (isset($array_reg[$j][32]) ? $array_reg[$j][32] : 0));
                        $sheet->setCellValue('AG' . $numRow, (isset($array_reg[$j][31]) ? $array_reg[$j][31] : 0));
                        $sheet->setCellValue('AH' . $numRow, (isset($array_reg[$j][33]) ? $array_reg[$j][33] : 0));
                        $sheet->setCellValue('AI' . $numRow, (isset($array_reg[$j][34]) ? $array_reg[$j][34] : 0));
                        $sheet->setCellValue('AJ' . $numRow, (isset($array_reg[$j][35]) ? $array_reg[$j][35] : 0));
                        $sheet->setCellValue('AK' . $numRow, (isset($array_reg[$j][36]) ? $array_reg[$j][36] : 0));
                        $sheet->setCellValue('AL' . $numRow, (isset($array_reg[$j][37]) ? $array_reg[$j][37] : 0));
                        $sheet->setCellValue('AM' . $numRow, (isset($array_reg[$j][38]) ? $array_reg[$j][38] : 0));
                        $sheet->setCellValue('AN' . $numRow, (isset($array_reg[$j][39]) ? $array_reg[$j][39] : 0));
                        $sheet->setCellValue('AO' . $numRow, (isset($array_reg[$j][40]) ? $array_reg[$j][40] : 0));
                        $sheet->setCellValue('AP' . $numRow, (isset($array_reg[$j][41]) ? $array_reg[$j][41] : 0));
                        $sheet->setCellValue('AQ' . $numRow, (isset($array_reg[$j][42]) ? $array_reg[$j][42] : 0));
                        $j++;
                        $numRow++;
                    }
                }
                //вывод по округу
                if ($region_for_district == 0)
                {
                    $sheet->setCellValue('A' . $numRow, $model->get_district_id($district->id)->name);
                    $sheet->setCellValue('D' . $numRow, (isset($array_fed[$k][4]) ? $array_fed[$k][4] : 0));
                    $sheet->setCellValue('E' . $numRow, (isset($array_fed[$k][3]) ? $array_fed[$k][3] : 0));
                    $sheet->setCellValue('F' . $numRow, (isset($array_fed[$k][6]) ? $array_fed[$k][6] : 0));
                    $sheet->setCellValue('G' . $numRow, (isset($array_fed[$k][5]) ? $array_fed[$k][5] : 0));
                    $sheet->setCellValue('H' . $numRow, (isset($array_fed[$k][8]) ? $array_fed[$k][8] : 0));
                    $sheet->setCellValue('I' . $numRow, (isset($array_fed[$k][7]) ? $array_fed[$k][7] : 0));
                    $sheet->setCellValue('J' . $numRow, (isset($array_fed[$k][10]) ? $array_fed[$k][10] : 0));
                    $sheet->setCellValue('K' . $numRow, (isset($array_fed[$k][9]) ? $array_fed[$k][9] : 0));
                    $sheet->setCellValue('L' . $numRow, (isset($array_fed[$k][12]) ? $array_fed[$k][12] : 0));
                    $sheet->setCellValue('M' . $numRow, (isset($array_fed[$k][11]) ? $array_fed[$k][11] : 0));
                    $sheet->setCellValue('N' . $numRow, (isset($array_fed[$k][14]) ? $array_fed[$k][14] : 0));
                    $sheet->setCellValue('O' . $numRow, (isset($array_fed[$k][13]) ? $array_fed[$k][13] : 0));
                    $sheet->setCellValue('P' . $numRow, (isset($array_fed[$k][16]) ? $array_fed[$k][16] : 0));
                    $sheet->setCellValue('Q' . $numRow, (isset($array_fed[$k][15]) ? $array_fed[$k][15] : 0));
                    $sheet->setCellValue('R' . $numRow, (isset($array_fed[$k][18]) ? $array_fed[$k][18] : 0));
                    $sheet->setCellValue('S' . $numRow, (isset($array_fed[$k][17]) ? $array_fed[$k][17] : 0));
                    $sheet->setCellValue('T' . $numRow, (isset($array_fed[$k][20]) ? $array_fed[$k][20] : 0));
                    $sheet->setCellValue('U' . $numRow, (isset($array_fed[$k][19]) ? $array_fed[$k][19] : 0));
                    $sheet->setCellValue('V' . $numRow, (isset($array_fed[$k][22]) ? $array_fed[$k][22] : 0));
                    $sheet->setCellValue('W' . $numRow, (isset($array_fed[$k][21]) ? $array_fed[$k][21] : 0));
                    $sheet->setCellValue('X' . $numRow, (isset($array_fed[$k][24]) ? $array_fed[$k][24] : 0));
                    $sheet->setCellValue('Y' . $numRow, (isset($array_fed[$k][23]) ? $array_fed[$k][23] : 0));
                    $sheet->setCellValue('Z' . $numRow, (isset($array_fed[$k][26]) ? $array_fed[$k][26] : 0));
                    $sheet->setCellValue('AA' . $numRow, (isset($array_fed[$k][25]) ? $array_fed[$k][25] : 0));
                    $sheet->setCellValue('AB' . $numRow, (isset($array_fed[$k][28]) ? $array_fed[$k][28] : 0));
                    $sheet->setCellValue('AC' . $numRow, (isset($array_fed[$k][27]) ? $array_fed[$k][27] : 0));
                    $sheet->setCellValue('AD' . $numRow, (isset($array_fed[$k][30]) ? $array_fed[$k][30] : 0));
                    $sheet->setCellValue('AE' . $numRow, (isset($array_fed[$k][29]) ? $array_fed[$k][29] : 0));
                    $sheet->setCellValue('AF' . $numRow, (isset($array_fed[$k][32]) ? $array_fed[$k][32] : 0));
                    $sheet->setCellValue('AG' . $numRow, (isset($array_fed[$k][31]) ? $array_fed[$k][31] : 0));
                    $sheet->setCellValue('AH' . $numRow, (isset($array_fed[$k][33]) ? $array_fed[$k][33] : 0));
                    $sheet->setCellValue('AI' . $numRow, (isset($array_fed[$k][34]) ? $array_fed[$k][34] : 0));
                    $sheet->setCellValue('AJ' . $numRow, (isset($array_fed[$k][35]) ? $array_fed[$k][35] : 0));
                    $sheet->setCellValue('AK' . $numRow, (isset($array_fed[$k][36]) ? $array_fed[$k][36] : 0));
                    $sheet->setCellValue('AL' . $numRow, (isset($array_fed[$k][37]) ? $array_fed[$k][37] : 0));
                    $sheet->setCellValue('AM' . $numRow, (isset($array_fed[$k][38]) ? $array_fed[$k][38] : 0));
                    $sheet->setCellValue('AN' . $numRow, (isset($array_fed[$k][39]) ? $array_fed[$k][39] : 0));
                    $sheet->setCellValue('AO' . $numRow, (isset($array_fed[$k][40]) ? $array_fed[$k][40] : 0));
                    $sheet->setCellValue('AP' . $numRow, (isset($array_fed[$k][41]) ? $array_fed[$k][41] : 0));
                    $sheet->setCellValue('AQ' . $numRow, (isset($array_fed[$k][42]) ? $array_fed[$k][42] : 0));
                    $sheet->getStyle($numRow)->applyFromArray($style_fed);
                }

                $k++;
                $numRow++;

            }
        }
        $sheet->setCellValue('A' . $numRow, "Итого");
        $sheet->setCellValue('D' . $numRow,  (isset($array_result[4]) ? $array_result[4] : 0));
        $sheet->setCellValue('E' . $numRow,  (isset($array_result[3]) ? $array_result[3] : 0));
        $sheet->setCellValue('F' . $numRow,  (isset($array_result[6]) ? $array_result[6] : 0));
        $sheet->setCellValue('G' . $numRow,  (isset($array_result[5]) ? $array_result[5] : 0));
        $sheet->setCellValue('H' . $numRow,  (isset($array_result[8]) ? $array_result[8] : 0));
        $sheet->setCellValue('I' . $numRow,  (isset($array_result[7]) ? $array_result[7] : 0));
        $sheet->setCellValue('J' . $numRow,  (isset($array_result[10]) ? $array_result[10] : 0));
        $sheet->setCellValue('K' . $numRow,  (isset($array_result[9]) ? $array_result[9] : 0));
        $sheet->setCellValue('L' . $numRow,  (isset($array_result[12]) ? $array_result[12] : 0));
        $sheet->setCellValue('M' . $numRow,  (isset($array_result[11]) ? $array_result[11] : 0));
        $sheet->setCellValue('N' . $numRow,  (isset($array_result[14]) ? $array_result[14] : 0));
        $sheet->setCellValue('O' . $numRow,  (isset($array_result[13]) ? $array_result[13] : 0));
        $sheet->setCellValue('P' . $numRow,  (isset($array_result[16]) ? $array_result[16] : 0));
        $sheet->setCellValue('Q' . $numRow,  (isset($array_result[15]) ? $array_result[15] : 0));
        $sheet->setCellValue('R' . $numRow,  (isset($array_result[18]) ? $array_result[18] : 0));
        $sheet->setCellValue('S' . $numRow,  (isset($array_result[17]) ? $array_result[17] : 0));
        $sheet->setCellValue('T' . $numRow,  (isset($array_result[20]) ? $array_result[20] : 0));
        $sheet->setCellValue('U' . $numRow,  (isset($array_result[19]) ? $array_result[19] : 0));
        $sheet->setCellValue('V' . $numRow,  (isset($array_result[22]) ? $array_result[22] : 0));
        $sheet->setCellValue('W' . $numRow,  (isset($array_result[21]) ? $array_result[21] : 0));
        $sheet->setCellValue('X' . $numRow,  (isset($array_result[24]) ? $array_result[24] : 0));
        $sheet->setCellValue('Y' . $numRow,  (isset($array_result[23]) ? $array_result[23] : 0));
        $sheet->setCellValue('Z' . $numRow,  (isset($array_result[26]) ? $array_result[26] : 0));
        $sheet->setCellValue('AA' . $numRow, (isset($array_result[25]) ? $array_result[25] : 0));
        $sheet->setCellValue('AB' . $numRow, (isset($array_result[28]) ? $array_result[28] : 0));
        $sheet->setCellValue('AC' . $numRow, (isset($array_result[27]) ? $array_result[27] : 0));
        $sheet->setCellValue('AD' . $numRow, (isset($array_result[30]) ? $array_result[30] : 0));
        $sheet->setCellValue('AE' . $numRow, (isset($array_result[29]) ? $array_result[29] : 0));
        $sheet->setCellValue('AF' . $numRow, (isset($array_result[32]) ? $array_result[32] : 0));
        $sheet->setCellValue('AG' . $numRow, (isset($array_result[31]) ? $array_result[31] : 0));
        $sheet->setCellValue('AH' . $numRow, (isset($array_result[33]) ? $array_result[33] : 0));
        $sheet->setCellValue('AI' . $numRow, (isset($array_result[34]) ? $array_result[34] : 0));
        $sheet->setCellValue('AJ' . $numRow, (isset($array_result[35]) ? $array_result[35] : 0));
        $sheet->setCellValue('AK' . $numRow, (isset($array_result[36]) ? $array_result[36] : 0));
        $sheet->setCellValue('AL' . $numRow, (isset($array_result[37]) ? $array_result[37] : 0));
        $sheet->setCellValue('AM' . $numRow, (isset($array_result[38]) ? $array_result[38] : 0));
        $sheet->setCellValue('AN' . $numRow, (isset($array_result[39]) ? $array_result[39] : 0));
        $sheet->setCellValue('AO' . $numRow, (isset($array_result[40]) ? $array_result[40] : 0));
        $sheet->setCellValue('AP' . $numRow, (isset($array_result[41]) ? $array_result[41] : 0));
        $sheet->setCellValue('AQ' . $numRow, (isset($array_result[42]) ? $array_result[42] : 0));
        $sheet->getStyle($numRow)->applyFromArray($style_itog);
        $numRow++;
        $summa = $array_result[4] + $array_result[3];
        $sheet->setCellValue('A' . $numRow, "Итого в % ");
        $sheet->setCellValue('D' . $numRow,  (isset($array_result[4]) ? (($array_result[4]*100)/$summa) : 0));
        $sheet->setCellValue('E' . $numRow,  (isset($array_result[3]) ? (($array_result[3]*100)/$summa) : 0));
        $sheet->setCellValue('F' . $numRow,  (isset($array_result[6]) ? (($array_result[6]*100)/$summa) : 0));
        $sheet->setCellValue('G' . $numRow,  (isset($array_result[5]) ? (($array_result[5]*100)/$summa) : 0));
        $sheet->setCellValue('H' . $numRow,  (isset($array_result[8]) ? (($array_result[8]*100)/$summa) : 0));
        $sheet->setCellValue('I' . $numRow,  (isset($array_result[7]) ? (($array_result[7]*100)/$summa) : 0));
        $sheet->setCellValue('J' . $numRow,  (isset($array_result[10]) ? (($array_result[10]*100)/$summa) : 0));
        $sheet->setCellValue('K' . $numRow,  (isset($array_result[9]) ? (($array_result[9]*100)/$summa) : 0));
        $sheet->setCellValue('L' . $numRow,  (isset($array_result[12]) ? (($array_result[12]*100)/$summa) : 0));
        $sheet->setCellValue('M' . $numRow,  (isset($array_result[11]) ? (($array_result[11]*100)/$summa) : 0));
        $sheet->setCellValue('N' . $numRow,  (isset($array_result[14]) ? (($array_result[14]*100)/$summa) : 0));
        $sheet->setCellValue('O' . $numRow,  (isset($array_result[13]) ? (($array_result[13]*100)/$summa) : 0));
        $sheet->setCellValue('P' . $numRow,  (isset($array_result[16]) ? (($array_result[16]*100)/$summa) : 0));
        $sheet->setCellValue('Q' . $numRow,  (isset($array_result[15]) ? (($array_result[15]*100)/$summa) : 0));
        $sheet->setCellValue('R' . $numRow,  (isset($array_result[18]) ?(($array_result[18]*100)/$summa) : 0));
        $sheet->setCellValue('S' . $numRow,  (isset($array_result[17]) ?(($array_result[17]*100)/$summa) : 0));
        $sheet->setCellValue('T' . $numRow,  (isset($array_result[20]) ?(($array_result[20]*100)/$summa) : 0));
        $sheet->setCellValue('U' . $numRow,  (isset($array_result[19]) ?(($array_result[19]*100)/$summa) : 0));
        $sheet->setCellValue('V' . $numRow,  (isset($array_result[22]) ?(($array_result[22]*100)/$summa) : 0));
        $sheet->setCellValue('W' . $numRow,  (isset($array_result[21]) ?(($array_result[21]*100)/$summa) : 0));
        $sheet->setCellValue('X' . $numRow,  (isset($array_result[24]) ?(($array_result[24]*100)/$summa) : 0));
        $sheet->setCellValue('Y' . $numRow,  (isset($array_result[23]) ?(($array_result[23]*100)/$summa) : 0));
        $sheet->setCellValue('Z' . $numRow,  (isset($array_result[26]) ?(($array_result[26]*100)/$summa) : 0));
        $sheet->setCellValue('AA' . $numRow, (isset($array_result[25]) ?(($array_result[25]*100)/$summa) : 0));
        $sheet->setCellValue('AB' . $numRow, (isset($array_result[28]) ?(($array_result[28]*100)/$summa) : 0));
        $sheet->setCellValue('AC' . $numRow, (isset($array_result[27]) ?(($array_result[27]*100)/$summa) : 0));
        $sheet->setCellValue('AD' . $numRow, (isset($array_result[30]) ?(($array_result[30]*100)/$summa) : 0));
        $sheet->setCellValue('AE' . $numRow, (isset($array_result[29]) ?(($array_result[29]*100)/$summa) : 0));
        $sheet->setCellValue('AF' . $numRow, (isset($array_result[32]) ?(($array_result[32]*100)/$summa) : 0));
        $sheet->setCellValue('AG' . $numRow, (isset($array_result[31]) ?(($array_result[31]*100)/$summa) : 0));
        $sheet->setCellValue('AH' . $numRow, (isset($array_result[33]) ?(($array_result[33]*100)/$summa) : 0));
        $sheet->setCellValue('AI' . $numRow, (isset($array_result[34]) ?(($array_result[34]*100)/$summa) : 0));
        $sheet->setCellValue('AJ' . $numRow, (isset($array_result[35]) ?(($array_result[35]*100)/$summa) : 0));
        $sheet->setCellValue('AK' . $numRow, (isset($array_result[36]) ?(($array_result[36]*100)/$summa) : 0));
        $sheet->setCellValue('AL' . $numRow, (isset($array_result[37]) ?(($array_result[37]*100)/$summa) : 0));
        $sheet->setCellValue('AM' . $numRow, (isset($array_result[38]) ?(($array_result[38]*100)/$summa) : 0));
        $sheet->setCellValue('AN' . $numRow, (isset($array_result[39]) ?(($array_result[39]*100)/$summa) : 0));
        $sheet->setCellValue('AO' . $numRow, (isset($array_result[40]) ?(($array_result[40]*100)/$summa) : 0));
        $sheet->setCellValue('AP' . $numRow, (isset($array_result[41]) ?(($array_result[41]*100)/$summa) : 0));
        $sheet->setCellValue('AQ' . $numRow, (isset($array_result[42]) ?(($array_result[42]*100)/$summa) : 0));
        $sheet->getStyle($numRow)->applyFromArray($style_itog);
        //$sheet->getStyle("A1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        //$sheet->getStyle("A1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //$sheet->setTitle('Market');
        $filename = 'Данные по анк учит_' . date('Y_m_d', time()) . '.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $objWriter = \PHPExcel_IOFactory::createWriter($document, 'Excel2007');
        $objWriter->save('php://output');
        //$json = 1;
        //return $json;
        exit;
        //return $model-

    }
}
