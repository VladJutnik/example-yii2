<?php

namespace backend\controllers;

use common\models\AmbulatoryCartCamp;
use common\models\FactInfCamp;
use common\models\IsolatorCartCamp;
use common\models\MedicalDiseases;
use common\models\MedicalForm;
use common\models\Medicals;
use common\models\Months;
use common\models\Organization;
use common\models\Region;
use common\models\ThermometryCamp;
use Yii;
use common\models\Kids;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class KidsController extends Controller
{

    public function actionChoiceListKidsCamp()
    {
        $model2 = new Kids();

        Yii::$app->session['test'] = 'Тест сессии';

        $organization_id = Yii::$app->user->identity->organization_id;
        if(Yii::$app->user->can('rospotrebnadzor_camp') || Yii::$app->user->can('rospotrebnadzor_nutrition') || Yii::$app->user->can('subject_minobr') || Yii::$app->user->can('minobr')){
            if(empty(Yii::$app->session['organization_id'])){
                Yii::$app->session->setFlash('error', "Чтобы посмотреть информацию об организации, необходимо ее выбрать из списка");
                return $this->redirect(['site/index']);
            }
            $organization_id = Yii::$app->session['organization_id'];
        }
        $my_organization = Organization::findOne($organization_id);
        if(empty($my_organization)){
            Yii::$app->session->setFlash('error', "Прозишла проблема при регистрации. У вас отсутствует организация");
            return $this->redirect(['site/index']);
        }
        if (Yii::$app->request->post())
        {
            $_SESSION['year'] = Yii::$app->request->post()['Kids']['year'];
            $_SESSION['season'] = Yii::$app->request->post()['Kids']['season'];
            $_SESSION['change_camp'] = Yii::$app->request->post()['Kids']['change_camp'];
            $_SESSION['group_camp'] = Yii::$app->request->post()['Kids']['group_camp'];
            $year = Yii::$app->request->post()['Kids']['year'];
            $season = Yii::$app->request->post()['Kids']['season'];
            $change_camp = Yii::$app->request->post()['Kids']['change_camp'];
            $group_camp = Yii::$app->request->post()['Kids']['group_camp'];

            $dataProvider = new ActiveDataProvider([
                'query' => Kids::find()->where([
                    'organization_id' => $organization_id,
                    'year' => $year,
                    'season' => $season,
                    'change_camp' => $change_camp,
                    'group_camp' => $group_camp,
                ])->orderBy('change_camp ASC, group_camp ASC, lastname ASC'),
            ]);
            return $this->render('choice-list-kids-camp', [
                'dataProvider' => $dataProvider,
                'year' => $year,
                'season' => $season,
                'change_camp' => $change_camp,
                'group_camp' => $group_camp,
                'model2' => $model2,
            ]);
        }

        return $this->render('choice-list-kids-camp', [
            'model2' => $model2,
        ]);
    }

    public function actionChoiceListKidsTerCamp()
    {
        $model2 = new Kids();
        $organization_id = Yii::$app->user->identity->organization_id;
        if(Yii::$app->user->can('rospotrebnadzor_camp') || Yii::$app->user->can('rospotrebnadzor_nutrition') || Yii::$app->user->can('subject_minobr') || Yii::$app->user->can('minobr')){
            if(empty(Yii::$app->session['organization_id'])){
                Yii::$app->session->setFlash('error', "Чтобы посмотреть информацию об организации, необходимо ее выбрать из списка");
                return $this->redirect(['site/index']);
            }
            $organization_id = Yii::$app->session['organization_id'];
        }
        $my_organization = Organization::findOne($organization_id);
        if(empty($my_organization)){
            Yii::$app->session->setFlash('error', "Прозишла проблема при регистрации. У вас отсутствует организация");
            return $this->redirect(['site/index']);
        }
        $status = 0;
        if (Yii::$app->request->post())
        {
            $status = 1;
            $post = Yii::$app->request->post()['Kids'];
            $year = $post['year'];
            $season = $post['season'];
            $change_camp = $post['change_camp'];
            $group_camp = $post['group_camp'];
            $_SESSION['year'] = $post['year'];
            $_SESSION['season'] = $post['season'];
            $_SESSION['change_camp'] = $post['change_camp'];
            $_SESSION['group_camp'] = $post['group_camp'];

            $kidss = Kids::find()->where([
                'organization_id' => $organization_id,
                'year' => $year,
                'season' => $season,
                'change_camp' => $change_camp,
                'group_camp' => $group_camp,
            ])->orderBy('change_camp ASC, group_camp ASC, lastname ASC')->all();

            $fact_camp = FactInfCamp::find()->where([
                'organization_id' => $organization_id,
                'year' => $year,
                'season' =>$season,
                'change' => $change_camp])
                ->asArray()->one();

            return $this->render('choice-list-kids-ter-camp', [
                'kidss' => $kidss,
                'fact_camp' => $fact_camp,
                'year' => $year,
                'season' => $season,
                'change_camp' => $change_camp,
                'group_camp' => $group_camp,
                'model2' => $model2,
                'status' => $status,
                'post' => $post,
            ]);
        }

        return $this->render('choice-list-kids-ter-camp', [
            'model2' => $model2,
            'status' => $status,
        ]);
    }
    //выставить одному выбраному ребенку из отряда нормальную темпиратуру
    public function actionAutomaticTemperatureOne($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        //$id - номер ребенка
        $kids = kids::findOne($id);
        //проверяем приходящий id он из тойже организации или нет
        if($kids->organization_id == Yii::$app->user->identity->organization_id){
            //Фактические данные по смене
            $fact_camp = FactInfCamp::find()->where([
                'organization_id' => $kids->organization_id,
                'year' => $kids->year,
                'season' => $kids->season,
                'change' =>  $kids->change_camp])
                ->asArray()->one();
            if (!empty($fact_camp)){
                //определяем деньки которые будем проверять выставлять темпиратуру
                $begin = $fact_camp['start_date']; //Начальная дата из БД
                $end = $fact_camp['expiry_date']; //Конечная дата из БД
                $datetime1 = date_create($begin);//что то как то с датами играем и делаем
                $datetime2 = date_create($end);
                $interval = date_diff($datetime1, $datetime2);
                $diff = $interval->format('%d');
                $date_fact_camp = array();
                for($i = 0; $i <= $diff; $i++){
                    $date_fact_camp[] = date("d.m.Y", strtotime("$begin +$i day"));
                }//вот до сюда что то как то с датами играем и делаем
                $model_save_id = [];//это если ошибка будем откытить должны id записей (!но это не точно!)
                foreach ($date_fact_camp as $date):
                    //проверяем есть ли запис в базе по дате или нет
                    $date_sql = date("Y-m-d", strtotime($date));
                    $model_date = ThermometryCamp::find()->where(['kids_id' => $id])->andwhere(['=', 'STR_TO_DATE(`date_surveys`, \'%d.%m.%Y\')', $date_sql])->one();
                    if (empty($model_date)){
                        //если пусто то добавляем запись о нормальной темпиратуры
                        $model_save = new ThermometryCamp();
                        $model_save->kids_id = $id;
                        $model_save->organization_id = Yii::$app->user->identity->organization_id;
                        $model_save->date_surveys = $date;
                        $model_save->normal_temperature_morning = 1;
                        $model_save->no_normal_temperature_morning = '';
                        $model_save->normal_temperature_evening = 1;
                        $model_save->no_normal_evening = '';
                        if ($model_save->save(false))
                        {
                            $model_save_id[] = $model_save->id;
                        }else
                        {
                            ThermometryCamp::deleteall(['in', 'id', $model_save_id]); //удаляем всех загрузившихся пациентов если ошибка
                            Yii::$app->session->setFlash('error', "Что то пошло не так, данные не сохранены!");//дропаем запись если ошибка
                            return $this->redirect(['view-camp', 'id' => $id]);
                        }
                    }
                endforeach;
                Yii::$app->session->setFlash('success', "Данные успешно сохранены!");
                return $this->redirect(['view-camp', 'id' => $id]);

            }else{
                Yii::$app->session->setFlash('error', "У Вас не добавлены фактические данные по заезду!");
                return $this->redirect(['view-camp', 'id' => $id]);
            }
        }else{
            Yii::$app->session->setFlash('error', "Как Вы сюда попали? У Вас нет прав на это действие!");
            return $this->redirect(['view-camp', 'id' => $id]);
        }

    }
    //выставить всем детям из отряда нормальную темпиратуру
    public function actionAutomaticTemperatureAll($post)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $post = explode("|",$post);
        /* $year = $post['year'];
        $season = $post['season'];
        $change_camp = $post['change_camp'];
        $group_camp = $post['group_camp'];*/
        $organization_id = Yii::$app->user->identity->organization_id;
        //Определяем факт данные по выбранным параметрам если их то отправляем их заполнять
        $fact_camp = FactInfCamp::find()->where([
            'organization_id' => $organization_id,
            'year' => $post[0],
            'season' => $post[1],
            'change' => $post[2]
        ])->asArray()->one();
        if (!empty($fact_camp)){
            //Определяем детей в организации
            $kidss = Kids::find()->where([
                'organization_id' => $organization_id,
                'year' => $post[0],
                'season' => $post[1],
                'change_camp' => $post[2],
                'group_camp' => $post[3],
            ])->orderBy('change_camp ASC, group_camp ASC, lastname ASC')->all();
            if (!empty($kidss)){
                foreach ($kidss as $kids):
                    //определяем деньки которые будем проверять выставлять темпиратуру
                    $begin = $fact_camp['start_date']; //Начальная дата из БД
                    $end = $fact_camp['expiry_date']; //Конечная дата из БД
                    $datetime1 = date_create($begin);//что то как то с датами играем и делаем
                    $datetime2 = date_create($end);
                    $interval = date_diff($datetime1, $datetime2);
                    $diff = $interval->format('%d');
                    $date_fact_camp = array();
                    for($i = 0; $i <= $diff; $i++){
                        $date_fact_camp[] = date("d.m.Y", strtotime("$begin +$i day"));
                    }//вот до сюда что то как то с датами играем и делаем
                    $model_save_id = [];//это если ошибка будем откытить должны id записей (!но это не точно!)
                    foreach ($date_fact_camp as $date):
                        //проверяем есть ли запис в базе по дате или нет
                        $date_sql = date("Y-m-d", strtotime($date));
                        $model_date = ThermometryCamp::find()->where(['kids_id' => $kids->id])->andwhere(['=', 'STR_TO_DATE(`date_surveys`, \'%d.%m.%Y\')', $date_sql])->one();
                        if (empty($model_date)){
                            //если пусто то добавляем запись о нормальной темпиратуры
                            $model_save = new ThermometryCamp();
                            $model_save->kids_id = $kids->id;
                            $model_save->organization_id = Yii::$app->user->identity->organization_id;
                            $model_save->date_surveys = $date;
                            $model_save->normal_temperature_morning = 1;
                            $model_save->no_normal_temperature_morning = '';
                            $model_save->normal_temperature_evening = 1;
                            $model_save->no_normal_evening = '';
                            if ($model_save->save(false))
                            {
                                $model_save_id[] = $model_save->id;
                            }else
                            {
                                ThermometryCamp::deleteall(['in', 'id', $model_save_id]); //удаляем всех загрузившихся пациентов если ошибка
                                Yii::$app->session->setFlash('success', "Что то пошло не так, данные не сохранены!");//дропаем запись если ошибка
                                return $this->redirect(['choice-list-kids-ter-camp']);
                            }
                        }
                    endforeach;
                endforeach;
                Yii::$app->session->setFlash('success', "Данные успешно сохранены!");
                return $this->redirect(['choice-list-kids-ter-camp']);
            }else{
                Yii::$app->session->setFlash('error', "Детей не найдено по выбранным Вами параметрам!");
                return $this->redirect(['choice-list-kids-ter-camp']);
            }
        }else{
            Yii::$app->session->setFlash('error', "У Вас не заполнены фактические данные по выбранным Вами параметрам!");
            return $this->redirect(['choice-list-kids-ter-camp']);
        }
    }
    //добавление информации
    public function actionListKidsCamp()
    {
        $organization_id = Yii::$app->user->identity->organization_id;

        $dataProvider = new ActiveDataProvider([
            'query' => Kids::find()->where([
                'organization_id' => $organization_id,
                'year' => 2021,
            ])->orderBy('change_camp ASC, group_camp ASC, lastname ASC'),
        ]);
        return $this->render('list-kids-camp', [
            'dataProvider' => $dataProvider,
        ]);
    }
    //СОХРАНЕНИЕ ajax азпросом
    public function actionUpdating()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        Yii::$app->controller->enableCsrfValidation = false;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();

        $model_save = ThermometryCamp::find()->where(['kids_id' => $post['kids_id']])->andwhere(['STR_TO_DATE(`date_surveys`, \'%d.%m.%Y\')'=>date('Y-m-d',strtotime($post['date_surveys']))])->one();
        if(empty($model_save)){
            $model_save = new ThermometryCamp();
        }
        $model_save->kids_id = $post['kids_id'];
        $model_save->organization_id = Yii::$app->user->identity->organization_id;
        $model_save->date_surveys = date('d.m.Y',strtotime($post['date_surveys']));
        if ($post['normal_temperature_morning'] == 1){
            $model_save->normal_temperature_morning = 1;
            $model_save->no_normal_temperature_morning = '';
        }else{
            $model_save->normal_temperature_morning = 0;
            if(is_numeric($post['no_normal_temperature_morning'])){
                if($post['no_normal_temperature_morning'] >= 37.2 && $post['no_normal_temperature_morning']<= 42){
                    $model_save->no_normal_temperature_morning = $post['no_normal_temperature_morning'];
                }else{
                    $model_save->no_normal_temperature_morning = '37.2';
                }
            }else{
                $model_save->no_normal_temperature_morning = '37.2';
            }
        }
        if ($post['normal_temperature_evening'] == 1){
            $model_save->normal_temperature_evening = 1;
            $model_save->no_normal_evening = '';
        }else{
            $model_save->normal_temperature_evening = 0;
            if(is_numeric($post['no_normal_evening'])){
                if($post['no_normal_evening'] >= 37.2 && $post['no_normal_evening']<= 42){
                    $model_save->no_normal_evening = $post['no_normal_evening'];
                }else{
                    $model_save->no_normal_evening = '37.2';
                }
            }else{
                $model_save->no_normal_evening = '37.2';
            }
        }
        $model_save->save(false);

        return $model_save;
    }

}