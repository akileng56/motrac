<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="appointment-form">

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

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Book Now' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
