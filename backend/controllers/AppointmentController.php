<?php

namespace backend\controllers;

use backend\models\SpecialitySymptom;
use backend\models\Symptom;
use common\models\User;
use Yii;
use backend\models\Speciality;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\HelperMethods;
use frontend\models\Consultation;
use yii\filters\AccessControl;

/**
 * SpecialityController implements the CRUD actions for Speciality model.
 */
class AppointmentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Appointments
     * @return mixed
     */
    public function actionAll()
    {
        $appointments = Consultation::find()->where(['status' => 'Pending'])->asArray()->all();
        return $this->render('../appointment/index', [
            'appointments' => $appointments,
        ]);
    }

    /**
     * Displays a single Speciality model.
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
     * Creates a new Speciality model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Consultation();

        if ($model->load(Yii::$app->request->post())) {
            $model->status = 'Pending';
            $model->date_time = time();
            $model->save(false);

            return $this->redirect(['all']);
        } else {
            $patients = User::find()->where(['role' => 'patient'])->asArray()->all();

            return $this->render('create', [
                'model' => $model,
                'patients' => $patients,
            ]);
        }
    }

    /**
     * Updates an existing Speciality model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            SpecialitySymptom::deleteAll(['speciality_id' => $model->speciality_id]);
            $this->saveSpecialitySymptom($model);

            return $this->redirect(['all']);
        } else {
            $array = SpecialitySymptom::find()
                ->select('symptom_id')
                ->where(['speciality_id' => $id])
                ->asArray()->all();

            $model->symptoms = HelperMethods::formatArray($array,'symptom_id');
            $symptoms = Symptom::find()->asArray()->all();

            return $this->render('update', [
                'model' => $model,
                'symptoms' => $symptoms,
            ]);
        }
    }

    /**
     * Deletes an existing Speciality model.
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
     * Finds the Speciality model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Speciality the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Speciality::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function saveSpecialitySymptom($model){
        foreach($model->symptoms as $value){
            $specialitySymptom = new SpecialitySymptom();
            $specialitySymptom->speciality_id = $model->speciality_id;
            $specialitySymptom->symptom_id = $value;
            $specialitySymptom->save();
        }
    }
}
