<?php

use yii\helpers\Url;

$formatter = \Yii::$app->formatter;
?>

<section class="doctor-index qwikmed-header-text">
    <h1>Patients</h1>
    <small>All patients registered in the system</small>
</section>

<div class="box box-success">
    <div style="margin: 20px">
        <table class="table table-striped qwikmed-table" id="records">
            <thead>
            <tr>
                <th>FullName</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>PhoneNumber</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($patients AS $patient) { ?>
                <tr>
                    <td> <?= $patient['fullname']; ?>  </td>
                    <td> <?= date('m/d/Y', $patient['dob']); ?>  </td>
                    <td> <?= $patient['gender']; ?>  </td>
                    <td> <?= $patient['phonenumber']; ?>  </td>
                    <td>
                        <a href='<?= Url::to(['patient/view', 'id' => $patient['id']]); ?>' class='btn btn-default'>
                            <i class='fa fa-eye'></i> view
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>