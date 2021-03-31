<?php
use common\models\HelpToolDropdowns;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Url;

$this->title = 'Register a new User';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-signup">
    <div class="row">
        <?php
        $form = ActiveForm::begin(['action'=>Url::to(['user/register']),'id' => 'form-signup']);
        ?>
        <table class="table">
            <tr>
                <td>
                    <?= $form->field($model, 'fullname')->label('FullName'); ?>
                </td>
                <td>
                    <?= $form->field($model, 'role')->dropDownList([
                            'patient' => 'Patient',
                            'admin' => 'Administrator',
                            'doctor' => 'Doctor'

                    ])->label('User Role'); ?>
                </td>

            </tr>
            <tr>
                <td>
                    <?= $form->field($model, 'gender')->dropDownList([
                        'Male' => 'Male',
                        'Female' => 'Female'

                    ])->label('Gender'); ?>
                </td>
                <td>
                    <?= $form->field($model, 'password_reset_token')->widget(\yii\jui\DatePicker::classname(), [
                        //'language' => 'ru',
                        //'dateFormat' => 'yyyy-MM-dd',
                    ]) ?>

                </td>


            </tr>
            <tr>
                <td> <?= $form->field($model, 'email') ?> </td>
                <td> <?= $form->field($model, 'phonenumber')->label('Telephone No.'); ?></td>
            </tr>
            <tr>
                <td>
                    <?= Html::submitButton('Register New User', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </td>
            </tr>
        </table>
        <?php ActiveForm::end(); ?>
    </div>
</div>
