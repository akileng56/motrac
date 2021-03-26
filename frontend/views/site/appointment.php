<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
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

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Book Now' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
