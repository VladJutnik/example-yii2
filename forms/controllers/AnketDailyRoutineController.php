<?php

namespace backend\controllers;

use common\models\Municipality;
use common\models\Region;
use Yii;
use common\models\AnketDailyRoutine;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AnketDailyRoutineController implements the CRUD actions for AnketDailyRoutine model.
 */
class AnketDailyRoutineController extends Controller
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
     * Creates a new AnketDailyRoutine model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AnketDailyRoutine();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Благодарим за предоставленную информацию!");
            return $this->redirect(['create', 'model' => $model,]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the AnketDailyRoutine model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AnketDailyRoutine the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AnketDailyRoutine::findOne($id)) !== null) {
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
}
