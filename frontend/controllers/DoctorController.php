<?php

namespace frontend\controllers;

use common\models\User;
use frontend\models\Diagnosis;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\Doctor;
use frontend\models\Schedule;
use backend\models\DoctorLanguage;
use frontend\models\Consultation;

/**
 * DoctorController handles functions of a doctor on frontend.
 */
class DoctorController extends Controller
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
     * Lists all Doctor models.
     * @return mixed
     */
    public function actionMyConsultations()
    {
        $user = Yii::$app->user->id;
        $appointments = Consultation::find()->where(['status' => 'Completed'])->andWhere(['doctor_id' => $user])->asArray()->all();
        return $this->render('myconsultations', [
            'appointments' => $appointments,
        ]);
    }
    /**
     * Lists all Doctor models.
     * @return mixed
     */
    public function actionPendingConsultations()
    {
        $user = Yii::$app->user->id;
        $appointments = Consultation::find()->where(['status' => 'Approved'])->andWhere(['doctor_id' => $user])->asArray()->all();
        return $this->render('pendingconsultations', [
            'appointments' => $appointments,
        ]);
    }

    public function actionDiagnose($id)
    {
        $consultation = Consultation::findOne($id);
        $model = new Diagnosis();
        $patient = User::findOne($consultation->patient_id);
        if ($model->load(Yii::$app->request->post())) {
            $model->consultation_id = $id;
            $model->save();

            $consultation->status = 'Completed';
            $consultation->save();

            $this->redirect(['doctor/my-consultations']);
        } else {
            return $this->render('diagnose',[
                'model' => $model,
                'patient' => $patient
            ]);
        }

    }

    public function actionDetails($id)
    {
        $consultation = Consultation::findOne($id);
        $diagnosis = Diagnosis::find()->where(['consultation_id'=>$id])->one();
        $patient = User::findOne($consultation->patient_id);

        return $this->render('details',[
            'diagnosis' => $diagnosis,
            'patient' => $patient
        ]);
    }

    public function actionSchedule()
    {
        $id = Yii::$app->user->id;
        $schedules = Schedule::find(['doctor_id'=>$id])->asArray()->all();

        return $this->render('schedule',[
            'schedules' => $schedules,
        ]);
    }

    public function actionProfile()
    {
        return $this->render('profile');
    }

    public function actionNewschedule()
    {
        $model = new Schedule();
        if ($model->load(Yii::$app->request->post())) {
            $model->doctor_id = Yii::$app->user->id;
            $model->start_time = strtotime($model->start_time_holder);
            $model->break_start_time = strtotime($model->break_start_time_holder);
            $model->break_end_time = strtotime($model->break_end_time_holder);
            $model->end_time = strtotime($model->end_time_holder);

            $model->save();

            $this->redirect(['doctor/schedule']);
        } else {
            return $this->render('newschedule',[
                'model' => $model
            ]);
        }

    }

    public function actionEditSchedule($id)
    {
        $model = Schedule::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->start_time = strtotime($model->start_time_holder);
            $model->break_start_time = strtotime($model->break_start_time_holder);
            $model->break_end_time = strtotime($model->break_end_time_holder);
            $model->end_time = strtotime($model->end_time_holder);

            $model->save();
            $this->redirect(['doctor/schedule']);
        } else {
            $model->start_time_holder = date('h:i A', $model->start_time);
            $model->break_start_time_holder = date('h:i A', $model->break_start_time);
            $model->break_end_time_holder = date('h:i A', $model->break_end_time);
            $model->end_time_holder = date('h:i A', $model->end_time);

            return $this->render('editschedule',[
                'model' => $model
            ]);
        }
    }
}
