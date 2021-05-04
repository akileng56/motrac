<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use backend\models\UserModule;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $password;
    public $phonenumber;
    public $email;
    public $fullname;
    public $role;
    public $dob;
    public $gender;

	
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['phonenumber'], 'trim'],
            [['password', 'phonenumber','fullname'], 'required'],
            [['phonenumber', 'password'], 'string', 'min' => 2, 'max' => 255],
            [['phonenumber'], 'string', 'min' => 10, 'max' => 25],
            ['email', 'email'],
            [['email'], 'string', 'max' => 255],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup($role) {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->setAttribute('email', $this->email);
        $user->setAttribute('phonenumber', $this->phonenumber);
        $user->setAttribute('fullname', $this->fullname);
        $user->setAttribute('role', $role);
        $user->setAttribute('created_at', time());
        $user->setAttribute('dob', $this->dob);
        $user->setAttribute('gender',$this->gender);
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->password_reset_token = '';


        if ($user->validate() && $user->save(false)) {
            return $user;
        } else {
            Yii::warning("loaded.." . print_r($user->getErrors(), true));
            return null;
        }
    }

}
