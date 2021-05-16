<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Speciality */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Approve Appointment';

?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="appointment-form col-8">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($patient, 'fullname')->textInput(['class' => 'form-control', 'disabled' => true])->label('Patient\'s Name') ?>
    <?= $form->field($speciality, 'name')->textInput(['class' => 'form-control', 'disabled' => true])->label('Doctor To See') ?>
    <?= $form->field($model, 'doctor_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map($doctors, 'id', 'fullname'),
        'options' => ['multiple' => false, 'placeholder' => 'Select a doctor....'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Doctor\'s Name');
    ?>
    <?= $form->field($model, 'fees_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map($fees, 'fees_id',function($fees){
            return $fees['name'] .' - '. $fees['amount'];
        } ),
        'options' => ['multiple' => false, 'placeholder' => 'Select consultation fee....'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Consultation Fees');
    ?>
    <div class="form-group">
        <?= Html::submitButton('Approve', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
