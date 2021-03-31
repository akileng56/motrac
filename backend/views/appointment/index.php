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
                <th>Status</th>
                <th>Appointment Day</th>
                <th>Created on</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($appointments AS $appointment) { ?>
                <tr>
                    <td> <?= \common\models\User::find()->where(['id' =>$appointment['patient_id']])->one()->fullname; ?>  </td>
                    <td> <?= $appointment['status']; ?>  </td>
                    <td class="text-capitalize"> <?= $appointment['day']; ?>  </td>
                    <td> <?= date('m/d/Y',$appointment['date_time']); ?> </td>
                    <td>
                        <a href='<?= Url::to(['appointment/update', 'id' => $appointment['consultation_id']]); ?>' class='btn btn-default'>
                            <i class='fa fa-pencil'></i> Edit
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>