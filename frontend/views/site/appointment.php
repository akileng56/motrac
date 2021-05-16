<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

?>

<div class="appointment-form">

    <div class="box col-8">
        <div class="box-header">
            <h3 class="box-title">
                CONSULTATION FEES
            </h3>
        </div>
        <div class="box-body no-padding">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Speciality</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($fees AS $fee) { ?>
                    <tr>
                        <td> <?= \backend\models\Speciality::findOne($fee['specialty_id'])->name . ' - ' . $fee['name'] ?>  </td>
                        <td> <?= $fee['amount']; ?>  </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>


    <div class="col-8">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'day')->widget(\yii\jui\DatePicker::classname(), [
            //'dateFormat' => 'MM/dd/yyyy',
            'options' => [
                'class' => 'form-control'
            ],
            'clientOptions' => [
                // 'format' => 'DD,j M, Y'
                'minDate' => \Yii::$app->formatter->asDate(time()),
                'maxDate' => \Yii::$app->formatter->asDate('+7 day')
            ],
        ])->label('Select An Appointment Day') ?>

        <?= $form->field($model, 'speciality_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map($specialities, 'speciality_id', 'name'),
            'options' => ['multiple' => false, 'placeholder' => 'Select the Doctor...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Choose the doctor');
        ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Book Now' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
