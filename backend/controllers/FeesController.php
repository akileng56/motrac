<?php

namespace backend\controllers;

use backend\models\Fees;
use backend\models\Speciality;
use Yii;
use backend\models\Symptom;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SymptomController implements the CRUD actions for Symptom model.
 */
class FeesController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Fees models.
     * @return mixed
     */
    public function actionAll()
    {
        $fees = Fees::find()->asArray()->all();

        return $this->render('index', [
            'fees' => $fees,
        ]);
    }

    /**
     * Displays a single Symptom model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Symptom model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Fees();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['all']);
        } else {
            $specialities = Speciality::find()->asArray()->all();
            return $this->render('create', [
                'model' => $model,
                'specialities' => $specialities
            ]);
        }
    }

    /**
     * Updates an existing Symptom model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['all']);
        } else {
            $specialities = Speciality::find()->asArray()->all();
            return $this->render('update', [
                'model' => $model,
                'specialities' => $specialities
            ]);
        }
    }

    /**
     * Deletes an existing Symptom model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['all']);
    }

    /**
     * Finds the Symptom model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Symptom the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fees::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
