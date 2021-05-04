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
    <?= DetailView::widget([
        'model' => $diagnosis,
        'attributes' => [
            'diagnosis',
            'advise'
        ],
    ]) ?>

    <a href='<?= Url::to(['appointment/print', 'id' => $consultation['consultation_id']]); ?>' class='btn btn-warning'>
        <i class='fa fa-eye'></i> Print Diagnosis
    </a>
</div>
