<?php

namespace backend\controllers;

use backend\models\Fees;
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
use frontend\models\Diagnosis;
use Mpdf\Mpdf;

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
        $appointments = Consultation::find()->asArray()->all();
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
            $model->save();

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
        if (($model = Consultation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionApprove($id){
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->status = 'Approved';
            $model->save();

            return $this->redirect(['all']);
        } else {
            $doctors = User::find()->where(['role' => 'doctor'])->asArray()->all();
            $patient = User::findOne($model->patient_id);
            $speciality = Speciality::findOne($model->speciality_id);
            $fees = Fees::find()->where(['specialty_id'=>$speciality->speciality_id])->asArray()->all();

            return $this->render('approve', [
                'model' => $model,
                'doctors' => $doctors,
                'patient' => $patient,
                'speciality' => $speciality,
                'fees' => $fees
            ]);
        }
    }

    public function actionDetails($id){
        $consultation = Consultation::findOne($id);
        $diagnosis = Diagnosis::find()->where(['consultation_id'=>$id])->one();
        $patient = User::findOne($consultation->patient_id);

        return $this->render('details',[
            'diagnosis' => $diagnosis,
            'patient' => $patient,
            'consultation' => $consultation
        ]);
    }

    public function actionPrint($id){
        $consultation = Consultation::findOne($id);
        $diagnosis = Diagnosis::find()->where(['consultation_id'=>$id])->one();
        $patient = User::findOne($consultation->patient_id);
        $doctor = User::findOne($consultation->doctor_id);

        $report = new Mpdf();
        $report->shrink_tables_to_fit = 1;
        $report->use_kwt = true;

        $html = '
                
        <h3 align="center" >MUTYABA ORTHOPAEDIC & TRAUMA CLINIC</h3>
        <h4 align="center" >NATIONAL INSURANCE BUILDING (NIC)</h4>
        <h4 align="center" >PLOT 3 PILKINGTON ROAD, GROUND FLOOR</h4>
        <h5 align="center">P.O BOX 127 ENTEBBE - UGANDA</h5>
        <h5 align="center">TEL: 0772 405 462</h5>
        <hr class="line"/>
        <br><br>
        Date:  '.date('l, j M, Y',time()).'
        <br><br>
        
        <div>           
            <span class="heading">Name: </span><span>'.$patient->fullname.'</span>
            &emsp;&emsp;&emsp;&emsp;
            <span class="heading">Gender: </span><span>'.$patient->gender.'</span> 
            &emsp;&emsp;&emsp;&emsp;
            <span class="heading">DOB: </span><span>'.date('j M, Y',$patient->dob).'</span>            
        </div>       
                
        <br>
        <div class="heading"> Doctor\'s Diagnosis: </div>      
        <div>'.$diagnosis->diagnosis.'</div>
        
        <br>
        <div class="heading"> Recommendations: </div>      
        <div>'.$diagnosis->advise.'</div>
        
         <br><br><br>
         Consultant Orthopaedic Surgeon <br> <br>
         <span class="doc_bold">'.$doctor->fullname.' </span> <br><br>
         ........................................................
          ';

        $stylesheet2 = file_get_contents('./../html/app/css/bootstrap.min.css');
        $report->WriteHTML($stylesheet2,1);

        $stylesheet = file_get_contents('./../html/app/css/report.css');
        $report->WriteHTML($stylesheet,1);

        $report->WriteHTML($html);
        $report->SetFont('maiandra');

        $fileName = $patient->fullname.'report'.Date('YmdGis').'.pdf';
        $report->Output($fileName,'D');
        $report->Output();

    }
}
