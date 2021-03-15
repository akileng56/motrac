<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Symptom */

$this->title = 'Create Symptom';
$this->params['breadcrumbs'][] = ['label' => 'Symptoms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="symptom-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
