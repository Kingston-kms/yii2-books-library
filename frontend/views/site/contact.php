<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var \frontend\models\ContactForm $model */

use borales\extensions\phoneInput\PhoneInput;
use himiklab\yii2\recaptcha\ReCaptcha3;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
    </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'phone')->widget(PhoneInput::class, [
                    'jsOptions' => [
                        'preferredCountries' => ['ru'],
                    ]
                ]) ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                <?php echo $form->field($model, 'reCaptcha')->widget(
                    \himiklab\yii2\recaptcha\ReCaptcha2::class
                ) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
