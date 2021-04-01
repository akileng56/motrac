<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Speciality */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="appointment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'day')->dropDownList([
        'monday' => 'Monday',
        'tuesday' => 'Tuesday',
        'wednesday' => 'Wednesday',
        'thursday' => 'Thursday',
        'friday' => 'Friday'
    ])->label('Select An Appointment Day') ?>

    <?= $form->field($model, 'patient_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map($patients, 'id', 'fullname'),
        'options' => ['multiple' => false,'placeholder' => 'Select a patient...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Patient Name');
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
