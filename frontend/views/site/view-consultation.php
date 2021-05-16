<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Patient */

$this->title = 'Appointment Details';
?>
<div class="patient-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'date_time:date',
            'status'
        ],
    ]) ?>


</div>
