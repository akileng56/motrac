<?php

use yii\helpers\Url;


/*
 * Vertical Navigation on the left of the page
 */
?>
<!-- START Menu-->


    <nav class="sidebar-nav active">
        <ul id="sidebarnav" class="in">

            <li><a href="<?= Url::to(['user/all-users']); ?>" title="Users">
                    <i class="fa fa-users"></i>
                    <span>USERS</span>
                </a>
            </li>

            <li><a href="<?= Url::to(['appointment/all']); ?>" title="Specialities">
                    <i class="fa fa-object-group"></i>
                    <span>APPOINTMENTS</span>
                </a>
            </li>

            <li><a href="<?= Url::to(['patient/all']); ?>" title="Patients">
                    <i class="fa fa-list"></i>
                    <span>PATIENTS</span>
                </a>
            </li>
            <hr>
            <li><a href="<?= Url::to(['admin/assignment']); ?>" title="Access Management">
                    <i class="fa fa-cog"></i>
                    <span class="sidebar-item-custom">ACCESS MANAGEMENT</span>
                </a>
            </li>
        </ul>
    </nav>


