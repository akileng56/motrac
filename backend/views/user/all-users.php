<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<section class="user-index qwikmed-header-text">
    <h1>Users</h1>
    <small>All the registered Users in the system</small>
</section>
<p>
    <?= Html::a('<i class="mdi mdi-plus-circle"></i> Create New User', ['user/register'], ['class' => 'btn btn-success']) ?>
</p>
<div class="box box-success">
    <div style="margin: 20px">
        <table class="table table-striped qwikmed-table" id="records">
            <thead>
            <tr>
                <th> FullName </th>
                <th> Phone Number </th>
                <th> Email </th>
                <th> User Role </th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users AS $user) { ?>
                <tr>
                    <td> <?= $user['fullname']; ?>  </td>
                    <td> <?= $user['phonenumber']; ?>  </td>
                    <td> <?= $user['email']; ?>  </td>
                    <td> <?= $user['role']; ?>  </td>
                    <td>
                        <a href='<?= Url::to(['user/update', 'id' => $user['id']]); ?>' class='btn btn-default'>
                            <i class='fa fa-pencil'></i> Edit
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>