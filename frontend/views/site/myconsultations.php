<?php
/**
 * Created by PhpStorm.
 * User: AKILENG
 * Date: 5/22/2020
 * Time: 3:02 AM
 */
use yii\helpers\Url;
?>

<div class="row page-titles">
    <div class="col-md-6 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">My Consultations</h3>
        <span class="qwikmed-subheading">All your consultations in the system</span>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-block">
                <div class="table-responsive m-t-40">
                    <table class="table stylish-table">
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
                                    <td><h6 class="text-capitalize">
                                            <?= date('l, j M, Y',$consultation['date_time']); ?>
                                        </h6></td>
                                    <td><?= $consultation['status']; ?> </td>

                                    <td>
                                        <?php if($consultation['status'] != 'Pending') { ?>
                                        <a href='<?= Url::to(['site/view-consultation', 'id' => $consultation['consultation_id']]); ?>' class='btn btn-warning'>
                                            <i class='fa fa-eye'></i> View Details
                                        </a>
                                        <?php } else if($consultation['status']== 'Pending') { ?>
                                            <a href='<?= Url::to(['site/edit', 'id' => $consultation['consultation_id']]); ?>' class='btn btn-default'>
                                                <i class='fa fa-pencil'></i> Edit Details
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
    </div>
</div>

