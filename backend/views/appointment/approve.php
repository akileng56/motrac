<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Speciality */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Approve Appointment';

?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="appointment-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'doctor_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map($doctors, 'id', 'fullname'),
        'options' => ['multiple' => false,'placeholder' => 'Select a patient...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Doctor\'s Name');
    ?>

    <div class="form-group">
        <?= Html::submitButton('Approve', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
