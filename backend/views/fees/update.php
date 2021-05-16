<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Symptom */

$this->title = 'Update Consultation Fees: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Symptoms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->fees_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="symptom-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'specialities' => $specialities
    ]) ?>

</div>
