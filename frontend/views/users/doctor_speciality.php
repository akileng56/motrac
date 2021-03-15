<?php
/**
 * Created by PhpStorm.
 * User: AKILENG
 * Date: 6/13/2020
 * Time: 3:43 AM
 */
?>

<div class="doctor_speciality">
    <div class="row">
        <?php foreach ($doctors As $doctor) {
            $languages = '';
            
            ?>
            <div class="col-lg-6 col-xlg-6 col-md-6">
                <div class="card">
                    <div class="parent-cont card-body">
                        <div class="col-lg-4 col-xlg-3 col-md-5">
                            <img class="img-responsive" src="<?= HELP_BASE_PATH.'backend/images/'.$doctor['photo'] ?>" alt="Card">
                        </div>
                        <div class="col-lg-8 col-xlg-9 col-md-7">
                            <h4><?= 'Dr. '.$doctor['fullname'] ?></h4>
                            <button class="btn-card btn btn-qwikmed"><?= $doctor['years_of_exp'].'+ Yrs Exp' ?></button>
                            <label><?= 'DR. '.$doctor['qualification'] ?></label>
                            <label><strong><?= $speciality ?></strong></label><br>
                            <label class="qwikmed-color"><strong>Speaks:</strong></label> <br>
                            <div class="btn-div">
                                <a class="col-lg-6 btn btn-default know-more text-info">Know More</a>
                                <a class="col-lg-6 btn btn-danger text-white">Consult Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
