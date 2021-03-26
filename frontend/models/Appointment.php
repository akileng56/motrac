<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\Consultation;
use backend\models\UserModule;

/**
 * Appointment form
 */
class Appointment extends Model {

    public $dayofweek;

	
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['$dayofweek'], 'required'],
            [['$dayofweek'], 'string', 'min' => 2, 'max' => 255],
        ];
    }


    public function newAppointment() {
        if (!$this->validate()) {
            return null;
        }

        $user = new Consultation();
        $user->setAttribute('email', $this->email);
        $user->setAttribute('phonenumber', $this->phonenumber);
        $user->setAttribute('fullname', $this->fullname);
        $user->setAttribute('role', $role);
        $user->setAttribute('created_at', time());
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->password_reset_token = '';


        if ($user->validate() && $user->save()) {
            return $user;
        } else {
            Yii::warning("loaded.." . print_r($user->getErrors(), true));
            return null;
        }
    }

}
