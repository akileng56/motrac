<?php

namespace frontend\controllers;

use backend\models\Doctor;
use backend\models\Fees;
use backend\models\Speciality;
use frontend\models\Consultation;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;

use common\models\LoginForm;
use common\models\User;

use frontend\models\SearchForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use yii\httpclient\Client;


/**
 * Site controller
 */
class SiteController extends Controller
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
                        'actions' => ['index', 'login', 'home','signin', 'signup', 'logout','register','newmembership','view-consultation',
                            'specialities','edit','my-consultations','partners','about','appointment','blog','contact','cancel',
                            'doctors','search','error','request-password-reset',
                            'reset-password' ],
                        'allow' => true
                    ],
                    [
                        'actions' => ['orders','cancel','logout','payment' ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function filters()
    {
        return [
            [
                'COutputCache',
                'duration' => 60,
                'varyByParam' => ['id'],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            $this->layout = "front";
            return $this->render('home');
        } else {
            $type = Yii::$app->user->identity['role'];
            $page = "";
            switch ($type) {
                case "doctor":
                    $page = Url::to(['doctor/pending-consultations']);
                    break;
                default:
                    $page = Url::to(['my-consultations']);
                    break;
            }
            return $this->redirect($page);
        }
    }


    /**
     * Loads home page
     *
     * @return mixed
     */
    public function actionHome()
    {
        $this->layout = "front";
        return $this->render('home');
    }

    /**
     * Loads home page
     *
     * @return mixed
     */
    public function actionContact()
    {
        $location = Configs::find()->where(['name' => 'location'])->one();
        return $this->render('contact',[
            'location' => $location
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout = "main_signup";
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(Url::to(['site/index']));
        }

        return $this->goHome();
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->redirect(Url::to(['site/signin']));
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
                return $this->render('response');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
//            throw new BadRequestHttpException($e->getMessage());
            Yii::$app->session->setFlash('error', "Invalid token. Please request a new one.");
            return $this->actionRequestPasswordReset();
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');
            return $this->redirect(Url::to(['site/signin']));
        }


        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionRegister()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->dob = time();
            if ($user = $model->signup('patient')) {
                Yii::$app->session->setFlash('success', 'Account created successfully...');
                $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Registration Failed... Please try again');
                $this->goHome();
            }
        } else {
            $this->goHome();
        }
    }

    public function actionNewmembership()
    {
        $model = new Membership();
        $model->membership_status = 'Pending';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Application created successfully.. 
            You will recieve an email once the application is approved ');
            return $this->redirect(Url::to(['site/membership']));
        } else {
            return $this->render('membership_form', [
                'model' => $model,
            ]);
        }

    }

    public function actionViewConsultation($id)
    {
        $model = Consultation::findOne($id);
        return $this->render('view-consultation', [
            'model' => $model,
        ]);
    }

    public function actionSignin() {
        $model = new LoginForm();

        //Check if a form has been submitted
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $phonenumber = $model->phonenumber;
            $user = User::findByPhoneNumber($phonenumber);
            if ($user) {
                if($model->login()){
                    return $this->redirect(Url::to(['site/index']));
                } else {
                    Yii::$app->session->setFlash('failure', "Incorrect Email or Password");
                }
            } else {
                Yii::$app->session->setFlash('failure', "You have not yet registered to use this system.");
            }
            return $this->goHome();
        }else {
            return $this->redirect(Url::to(['site/home#signin']));
        }
    }

    public function actionSpecialities()
    {
        $specialities = Speciality::find()->asArray()->all();

        return $this->render('specialities',[
            'specialities' => $specialities
        ]);
    }

    public function actionEdit($id)
    {
        $model = Consultation::findOne($id);
        return $this->render('edit',[
            'model' => $model
        ]);
    }

    public function actionMyConsultations()
    {
        $user = Yii::$app->user->id;
        $consultations = Consultation::find()->where(['patient_id' => $user])->asArray()->all();
        return $this->render('myconsultations',[
            'consultations' => $consultations
        ]);
    }

    public function actionAppointment()
    {
        $model = new Consultation();

        if($model->load(Yii::$app->request->post())){
            $model->patient_id = Yii::$app->user->id;
            $model->status = 'Pending';
            $model->date_time = strtotime($model->day);
            $model->save();

            return $this->redirect(Url::to(['my-consultations']));
        } else {
            $specialities = Speciality::find()->asArray()->all();
            $fees = Fees::find()->asArray()->all();

            return $this->render('appointment', [
                'model' => $model,
                'specialities' => $specialities,
                'fees' => $fees
            ]);
        }
    }

    public function actionSearch()
    {
        $model = new SearchForm();
        if($model->load(Yii::$app->request->post())){
            $search = $model->searchValue;
            $products = Product::find()->where(['like','name', '%'.$search. '%', false])
                ->orWhere(['like','description', '%'.$search. '%', false])->orderBy('created_at DESC')->asArray()->all();

            return $this->render('products',[
                'products' => $products,
            ]);
        }
    }


    public function actionPayment(){
        $token = $this->getToken();
        $referenceId = $this->GetReferenceID();
        $response = $this->RequestPayment($token,$referenceId);


        if($response->isOk){
            $newToken = $this->getToken();
            $this->paymentCallback($referenceId,$newToken);

            sleep(60);
            $newResponse = $this->paymentCallback($referenceId,$newToken);

            if($newResponse->isOk){
                $status = $newResponse->getData()['status'];
                if ($status == 'PENDING'){
                    //Retry checking the paying or maybe use a scheduled event
                    return $this->returnPage('PENDING',$newResponse,$referenceId);
                } else if ($status == 'SUCCESSFUL'){
                    //Go a head & send the order
                    return $this->returnPage('SUCCESSFUL',$newResponse,$referenceId);
                } else {
                    //Tell the customer to try again
                    return $this->returnPage($status,$newResponse,$referenceId);
                }

            } else { // Handle the callback for checking the token
                return $this->returnPage('Not Okay R2',$newResponse,$referenceId);
            }

        } else { // Check for other statuses when request to pay fails, tell customer to reply
            return $this->returnPage('notOkay',$response,$referenceId);
        }
    }

    public function getToken(){
        $accessToken = '';
        $client = new Client(['baseUrl' => 'https://sandbox.momodeveloper.mtn.com/collection/token/']);
        $response = $client->createRequest()
            ->setMethod('POST')
            ->addHeaders([
                'Ocp-Apim-Subscription-Key' => Yii::$app->params['Ocp-Apim-Subscription-Key'],
                'Authorization' => Yii::$app->params['Authorization'],
                'Content-Length' => 0
            ])
            ->send();

        if($response->isOk) {
            $responseData = $response->getData();
            $accessToken = $responseData['access_token'];

            return $accessToken;
        }

        return $accessToken;
    }


    public function RequestPayment($token,$referenceId){
        $client = new Client(['baseUrl' => 'https://sandbox.momodeveloper.mtn.com/collection/v1_0/requesttopay']);
        $response = $client->createRequest()
            ->setMethod('POST')
            ->addHeaders([
                'Authorization' => 'Bearer '.$token,
                'X-Reference-Id' => $referenceId,
                'X-Target-Environment' => Yii::$app->params['X-Target-Environment'],
                'Content-Type' => 'application/json',
                'Ocp-Apim-Subscription-Key' => Yii::$app->params['Ocp-Apim-Subscription-Key'],
            ])
            ->setFormat(Client::FORMAT_JSON)
            ->setData([
                'amount' => '20',
                'currency' => 'EUR',
                'externalId' => 'NOGAMU_'.$referenceId,
                'payer' => [
                    'partyIdType' => 'MSISDN',
                    'partyId' => Yii::$app->params['partyId']
                ],
                'payerMessage' => 'NOGOMU_PAYMENT',
                'payeeNote' => 'NOGOMU_PAYMENT',
            ])
            ->send();

        return $response;
    }

    public function GetReferenceID() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public function paymentCallback($referenceId,$token){
        $client = new Client(['baseUrl' => 'https://sandbox.momodeveloper.mtn.com/collection/v1_0/requesttopay/']);
        $response = $client->createRequest()
            ->setUrl($referenceId)
            ->setMethod('GET')
            ->addHeaders([
                'Ocp-Apim-Subscription-Key' => Yii::$app->params['Ocp-Apim-Subscription-Key'],
                'Authorization' => 'Bearer '.$token,
                'X-Target-Environment' => Yii::$app->params['X-Target-Environment'],
                'Content-Length' => 0
            ])
            ->send();

        return $response;
    }

    public function returnPage($responseType,$response,$referenceId){
        return $this->render('mobilemoney',[
            'responseType' => $responseType,
            'response' => $response->getData(),
            'referenceId' => $referenceId
        ]);
    }
}
