<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Speciality */

$this->title = 'Create Speciality';
$this->params['breadcrumbs'][] = ['label' => 'Specialities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="speciality-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
