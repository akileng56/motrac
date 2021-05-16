<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "consultation".
 *
 * @property integer $consultation_id
 * @property integer $doctor_id
 * @property integer $patient_id
 * @property string $status
 * @property integer $date_time
 * @property integer $speciality_id
 * @property integer $fees_id
 * @property string $day
 */
class Consultation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'consultation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['patient_id', 'status', 'date_time','fees_id', 'doctor_id'], 'required'],
            [['doctor_id', 'patient_id', 'date_time', 'speciality_id','fees_id'], 'integer'],
            [['status'], 'string', 'max' => 60],
            [['day'], 'string', 'max' => 200],
            [[ 'date_time'], 'default', 'value' => time()],
            [[ 'status'], 'default', 'value' => 'Pending']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'consultation_id' => 'Consultation ID',
            'doctor_id' => 'Doctor',
            'patient_id' => 'Patient',
            'status' => 'Status',
            'date_time' => 'Date Time',
            'speciality_id' => 'Speciality',
            'day' => 'Day',
            'fees_id' => 'Consultation Fees'
        ];
    }
}
