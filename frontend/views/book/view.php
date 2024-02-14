<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Book $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-sm-3 p-5">
            <img src="<?php echo $model->imageFile; ?>" width="150"/>
        </div>
        <div class="col-sm-9">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'isbn',
                    'title',
                    'published_date',
                    'page_count',
                    //'imageFile:url',
                    'short_description' => [
                        'attribute' => 'short_description',
                        'format' => 'html'
                    ],
                    'long_description' => [
                        'attribute' => 'long_description',
                        'format' => 'raw'
                    ],
                    'status' => [
                        'attribute' => 'status',
                        'value' => $model->status0->name
                    ]


                ],
            ]) ?>
        </div>
    </div>

</div>
