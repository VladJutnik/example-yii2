<?php

namespace backend\controllers;

use common\models\AnketPreschoolers;
use common\models\Diseases;
use common\models\FederalDistrict;
use common\models\Kids;
use common\models\MedicalDiseases;
use common\models\MedicalForm;
use common\models\Municipality;
use common\models\Organization;
use common\models\Region;
use Yii;
use common\models\Medicals;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\models\ThermometryCamp;

/**
 * MedicalsController implements the CRUD actions for Medicals model.
 */
class MedicalsController extends Controller
{
    public function actionThermometryCamp($id, $data)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = ThermometryCamp::find()->where(['kids_id' => $id])->andwhere(['STR_TO_DATE(`date_surveys`, \'%d.%m.%Y\')'=>date('Y-m-d',strtotime($data))])->one();
        if(empty($model))
        {
            $model = new ThermometryCamp();
        }

        $organization_id = Yii::$app->user->identity->organization_id;

        $this->layout = false;

        if (Yii::$app->request->post())
        {
            $post = Yii::$app->request->post()['ThermometryCamp'];
            $model_save = ThermometryCamp::find()->where(['kids_id' => $id])->andwhere(['STR_TO_DATE(`date_surveys`, \'%d.%m.%Y\')'=>date('Y-m-d',strtotime($post['date_surveys']))])->one();
            if(empty($model_save)){
                $model_save = new ThermometryCamp();
            }
            $model_save->kids_id = $id;
            $model_save->organization_id = Yii::$app->user->identity->organization_id;
            $model_save->date_surveys = $post['date_surveys'];
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

            if($model_save->save(false))
            {
                //ПРОВЕРИТЬ ВНЕСЕНЫ ЛИ ДАННЫЕ ЗА ДЕНЬ ПЕРЕДАННЫЙ ПОСТОМ
                Yii::$app->session->setFlash('success', "Добавлено успешно!");
                return $this->redirect('/kids/view-camp?id='.$id);
            }
            else{
                Yii::$app->session->setFlash('error', "Что то пошло не так!");
                return $this->render('thermometry-camp',
                    [
                        'model' => $model,
                        'id' => $id,
                        'data' => $data,
                        'organization_id' => $organization_id,
                    ]);
            }
        }

        return $this->render('thermometry-camp',
            [
                'model' => $model,
                'id' => $id,
                'data' => $data,
                'organization_id' => $organization_id,
            ]);
    }
}
