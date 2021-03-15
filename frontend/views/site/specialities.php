<?php
use yii\helpers\Url;
?>

<div class="row page-titles">
    <div class="col-md-6 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Top Specialities</h3>
        <span class="qwikmed-subheading">Consult doctors Online from the top hospital networks in uganda</span>
    </div>
</div>

<!-- Row -->
<div class="row">
    <!-- Column -->
    <?php foreach ($specialities As $speciality) { ?>
        <div class="col-lg-4">
            <a href="<?= Url::to(['doctors', 'id' => $speciality['speciality_id']]); ?>">
                <div class="card">
                    <img class="card-img-top img-responsive" src="https://dg0qqklufr26k.cloudfront.net/wp-content/uploads/2018/07/Pediatrician-2.png" alt="Card">
                    <div class="card-block">
                        <h3 class="font-normal"><?= $speciality['name'] ?></h3>
                        <ul class="list-inline font-14">
                            <li class="p-l-0">PCOD, Period Issues, UTI, Pregnancy Care, Abdominal Pain</li>
                        </ul>
                    </div>
                </div>
            </a>
        </div>
    <?php } ?>
    <!-- Column -->

</div>
<!-- Row -->