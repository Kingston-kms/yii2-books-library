<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\search\BookSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="book-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'isbn') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'published_date') ?>

    <?= $form->field($model, 'page_count') ?>

    <?php // echo $form->field($model, 'thumbnail_url') ?>

    <?php // echo $form->field($model, 'short_description') ?>

    <?php // echo $form->field($model, 'long_description') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
