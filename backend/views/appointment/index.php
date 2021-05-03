<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>

<section class="speciality-index qwikmed-header-text">
    <h1>Appointments</h1>
    <small>All Pending Appointments</small>
</section>

<p>
    <?= Html::a('Create New Appointment', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<div class="box box-success">
    <div style="margin: 20px">
        <table class="table table-striped qwikmed-table" id="records">
            <thead>
            <tr>
                <th>Patient Name</th>
                <th>Appointment Day</th>
                <th>Status</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($appointments AS $appointment) { ?>
                <tr>
                    <td> <?= \common\models\User::find()->where(['id' =>$appointment['patient_id']])->one()->fullname; ?>  </td>
                    <td> <?= date('l, j M, Y',$appointment['date_time']); ?> </td>
                    <td> <?= $appointment['status']; ?>  </td>
                    <td>
                        <a href='<?= Url::to(['appointment/update', 'id' => $appointment['consultation_id']]); ?>' class='btn btn-default'>
                            <i class='fa fa-pencil'></i> Edit
                        </a>
                    </td>
                    <td>
                        <?php if($appointment['status'] == 'Pending') {?>
                        <a href='<?= Url::to(['appointment/approve', 'id' => $appointment['consultation_id']]); ?>' class='btn btn-warning'>
                            <i class='fa fa-check'></i> Approve
                        </a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>