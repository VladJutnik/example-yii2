<?php

namespace backend\controllers;

use common\models\AnketEmploymentChildrenJune;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AnketEmploymentChildrenJuneController implements the CRUD actions for AnketEmploymentChildrenJune model.
 */
class AnketEmploymentChildrenJuneController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Creates a new AnketEmploymentChildrenJune model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AnketEmploymentChildrenJune();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success',
                "Благодарим за успешное внесение информации!"
            );
            return $this->redirect(['create']);
        }


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the AnketEmploymentChildrenJune model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AnketEmploymentChildrenJune the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AnketEmploymentChildrenJune::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
