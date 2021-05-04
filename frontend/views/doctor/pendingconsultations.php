<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>

<section class="speciality-index qwikmed-header-text">
    <h1>Pending</h1>
    <small>Appointments</small>
</section>

<div class="box box-success">
    <div style="margin: 20px">
        <table class="table table-striped qwikmed-table" id="records">
            <thead>
            <tr>
                <th>Patient Name</th>
                <th>Appointment Day</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($appointments AS $appointment) { ?>
                <tr>
                    <td> <?= \common\models\User::find()->where(['id' =>$appointment['patient_id']])->one()->fullname; ?>  </td>
                    <td> <?= date('l, j M, Y',$appointment['date_time']); ?> </td>
                    <td>
                        <a href='<?= Url::to(['doctor/diagnose', 'id' => $appointment['consultation_id']]); ?>' class='btn btn-success'>
                            <i class='fa fa-eye'></i> View Details
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>