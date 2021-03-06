<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Patient */

$this->title = 'Patient Details';
$this->params['breadcrumbs'][] = ['label' => 'Patients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patient-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fullname',
            'dob:date',
            'gender',
            'email:email',
            'phonenumber'
        ],
    ]) ?>

    <div class="box box-success">
        <div style="margin: 20px">
            <table class="table table-striped qwikmed-table" id="records">
                <thead>
                <tr>
                    <th>Appointment Day</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($consultations AS $consultation) { ?>
                    <tr>
                        <td> <?= date('l, j M, Y',$consultation['date_time']); ?> </td>
                        <td> <?= $consultation['status']; ?>  </td>
                        <td>
                            <?php if($consultation['status'] == 'Completed') {?>
                            <a href='<?= Url::to(['appointment/details', 'id' => $consultation['consultation_id']]); ?>' class='btn btn-default'>
                                <i class='fa fa-eye'></i> View Details
                            </a>
                            <?php }?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
