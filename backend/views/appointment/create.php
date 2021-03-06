<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Speciality */

$this->title = 'Create Appointment';
$this->params['breadcrumbs'][] = ['label' => 'Appointments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appointment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'patients' => $patients
    ]) ?>

</div>
