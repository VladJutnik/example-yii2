<?php

namespace backend\controllers;

use common\models\Municipality;
use common\models\Region;
use Mpdf\Mpdf;
use Yii;
use common\models\AnketSchoolChildrenKaz;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AnketSchoolChildrenKazController implements the CRUD actions for AnketSchoolChildrenKaz model.
 */
class AnketSchoolChildrenKazController extends Controller
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

    public function actionCreate()
    {
        $model = new AnketSchoolChildrenKaz();
        $contents = '';
        $post = '';

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            $post = $model->id;
            //print_r($post);
            Yii::$app->session->setFlash('success',
                "Благодарим за успешное внесение информации!"
            );
            $model2 = new AnketSchoolChildrenKaz();
            return $this->render('create',[
                'model' => $model2,
                'post' => $post,
            ]);
        }

        return $this->render('create', [
            'model' => $model,
            'post' => $post,
        ]);
    }

    public function actionReportAdminKaz()
    {
        $model = new AnketSchoolChildrenKaz();
        $contents = '';
        $post = '';
        $anket = '';

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post()['AnketSchoolChildrenKaz']['field103'];

            $anket = \common\models\AnketSchoolChildrenKaz::find()
                ->select(['class'])
                ->where(['federal_district_id' => 2])
                ->andWhere(['region_id' => 20])
                ->andWhere(['municipality_id' => 2217])
                ->andWhere(['field103' => $post])
                ->orderBy("class ASC")
                ->groupBy("class")->all();

            return $this->render('report-admin-kaz', [
                'model' => $model,
                'post' => $post,
                'anket' => $anket,
            ]);
        }

        return $this->render('report-admin-kaz', [
            'model' => $model,
            'post' => $post,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = AnketSchoolChildrenKaz::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /*Подставляет регионы в выпадающий список*/
    public function actionSubjectslist($id){

        $groups = Region::find()->where(['district_id'=>$id])->orderby(['name' => SORT_ASC])->all();

        if($id == 1){

        }
        echo '<option value=" ">Выберите регион...</option>';
        if(!empty($groups)){
            foreach ($groups as $key => $group) {
                echo '<option value="'.$group->id.'">'.$group->name.'</option>';
            }
        }
    }
    /*Подставляет муниципальные образования в выпадающий список*/
    public function actionMunicipalitylist($id){

        $groups = Municipality::find()->where(['region_id'=>$id])->orderby(['name' => SORT_ASC])->all();

        echo '<option value=" ">Выберите муниципальное образование...</option>';
        if(!empty($groups)){
            foreach ($groups as $key => $group) {
                echo '<option value="'.$group->id.'">'.$group->name.'</option>';
            }
        }
    }

    public function actionPrinting($id)
    {
        require_once __DIR__ . '/../../vendor/autoload.php';
        $model = new AnketSchoolChildrenKaz();
        $post = \common\models\AnketSchoolChildrenKaz::find()->where(['id' => $id])->one();
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
        $date_v = date('d.m.Y', strtotime($post->creat_at));
        $str = '
                <div class="container">
                     <h3 align="center">Отчет о результатах анкетирования (Дата анкетирования: '.$date_v.')</h3>
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
        //$mpdf = new Mpdf();
        $mpdf = new Mpdf(['format' => 'A4']);
        $mpdf->WriteHTML($str);
        //$mpdf->WriteHTML('Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...Some text...');
        //$mpdf->defaultfooterline = 1;
        //$mpdf->setFooter(' < div>Разработчик: "ФБУН Новосибирский НИИ гигиены Роспотребнадзора" </div > '); //номер страницы {PAGENO}
        $mpdf->Output('Результаты анкетирования.pdf', 'D'); //D - скачает файл!
        //$mpdf->Output('MyPDF . pdf', 'I'); //I - откроет в томже окне файл!
        //$mpdf->Output('MyPDF123123 . pdf', 'F'); //F - гененирует ссылку на файл и сохранить его на сервере путь сохр backend\web!

    }
}
