<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>

<section class="symptom-index qwikmed-header-text">
    <h1>Consultation Fees</h1>
    <small>Charge for consultations based on speciality</small>
</section>

<p>
    <?= Html::a('Create Fee', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<div class="box box-success">
    <div style="margin: 20px">
        <table class="table table-striped qwikmed-table" id="records">
            <thead>
            <tr>
                <th>Fee No</th>
                <th>
                    Name
                </th>
                <th>Speciality</th>
                <th>Amount</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($fees AS $fee) { ?>
                <tr>
                    <td> <?= $fee['fees_id']; ?>  </td>
                    <td> <?= $fee['name']; ?>  </td>
                    <td> <?= \backend\models\Speciality::findOne($fee['specialty_id'])->name ?>  </td>
                    <td> <?= $fee['amount']; ?>  </td>
                    <td>
                        <a href='<?= Url::to(['fees/update', 'id' => $fee['fees_id']]); ?>' class='btn btn-default'>
                            <i class='fa fa-pencil'></i> Edit Details
                        </a>
                    </td>
                    <td>
                        <a href='<?= Url::to(['fees/view', 'id' => $fee['fees_id']]); ?>' class='btn btn-warning'>
                            <i class='fa fa-view'></i> View Details
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>