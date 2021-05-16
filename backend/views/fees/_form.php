<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Symptom */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fees-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'amount')->input('int') ?>

    <?= $form->field($model, 'specialty_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map($specialities, 'speciality_id', 'name'),
        'options' => ['multiple' => false,'placeholder' => 'Select a Speciality...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Speciality');
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
