<?php

namespace backend\models;

use Yii;
use backend\models\SpecialitySymptom;

/**
 * This is the model class for table "speciality".
 *
 * @property integer $speciality_id
 * @property string $name
 *
 */
class Speciality extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'speciality';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'speciality_id' => 'Speciality ID',
            'name' => 'Name',
        ];
    }
}
