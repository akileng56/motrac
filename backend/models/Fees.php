<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "fees".
 *
 * @property int $fees_id
 * @property int $specialty_id
 * @property string $name
 * @property int $amount
 */
class Fees extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fees';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['specialty_id', 'name', 'amount'], 'required'],
            [['specialty_id', 'amount'], 'integer'],
            [['name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fees_id' => 'Fees ID',
            'specialty_id' => 'Specialty ID',
            'name' => 'Name',
            'amount' => 'Amount',
        ];
    }
}
