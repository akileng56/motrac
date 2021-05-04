<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Patient */

$this->title = 'Patient Details';
?>
<div class="diagnose">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $patient,
        'attributes' => [
            'fullname',
            'dob:date',
            'gender',
            'email:email',
            'phonenumber'
        ],
    ]) ?>

    <h1><?= Html::encode('Diagnosis Information') ?></h1>

    <div class="diagnose-form">

        <?php $form = ActiveForm::begin(); ?>



        <?= $form->field($model, 'diagnosis')->textarea([
                'rows' => 2
        ])->label('Doctor\'s Diagnosis') ?>

        <?= $form->field($model, 'advise')->textarea([
            'rows' => 5
        ])->label('Recommendations') ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
