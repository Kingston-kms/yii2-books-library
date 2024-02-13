<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Book $model */
/** @var yii\widgets\ActiveForm $form */

use backend\assets\MultiSelectAsset;
MultiSelectAsset::register($this);
$this->registerJs("$('#categories-select').multiSelect();");
$this->registerJs("$('#author-select').multiSelect();");
?>

<style>
    .fileinput-cancel-button {
        display: none;
    }
</style>
<div class="book-form">
    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>

    <div class="row">
        <div class="col-sm-6">

            <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'published_date')->widget(\kartik\datetime\DateTimePicker::class, [
                'options' => [
                    'placeholder' => 'Enter published date'
                ],
                'pluginOptions' => [
                    'autoclose' => true
                ]
            ]); ?>

            <?= $form->field($model, 'page_count')->textInput() ?>

            <?= $form->field($model, 'short_description')->textarea(['maxlength' => true]) ?>

            <?= $form->field($model, 'long_description')->textarea(['maxlength' => true]) ?>
            <div class="form-group">
                <?php echo Html::label("Category")?>
                <select id='categories-select' multiple='multiple' name="Book[_categories][]">
                    <?php
                    $bookCategories = \yii\helpers\ArrayHelper::map($model->bookCategories, 'id', 'category');
                    foreach (\common\models\Category::getCategoryListWithId() as $id => $name) {
                        echo Html::tag('option', $name, ['value' => $id, 'selected' => in_array($id, array_values($bookCategories))]);
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <?php echo Html::label("Author")?>
                <select id='author-select' multiple='multiple' name="Book[_authors][]">
                    <?php
                    $bookAuthors = \yii\helpers\ArrayHelper::map($model->bookAuthors, 'id', 'author');
                    foreach (\common\models\Author::getAuthorListWithId() as $id => $name) {
                        echo Html::tag('option', $name, ['value' => $id, 'selected' => in_array($id, array_values($bookAuthors))]);
                    }
                    ?>
                </select>
            </div>

            <?= $form->field($model, 'status')->dropDownList(\common\models\Status::getStatusListWithId()) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'imageFile')->widget(\kartik\file\FileInput::class, [
                'pluginOptions' => [
                    'showCaption' => false,
                    'showRemove' => false,
                    'showUpload' => false,
                    'browseClass' => 'btn btn-primary btn-block',
                    'browseIcon' => '<i class="fas fa-camera"></i> ',
                    'browseLabel' => 'Select image',
                    'initialPreview' => [
                        $model->imageFile
                    ],
                    'initialPreviewAsData' => true,
                ],
                'options' => [
                    'accept' => 'image/*'
                ]
            ]) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
