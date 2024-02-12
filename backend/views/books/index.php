<?php

use common\models\Book;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'linkContainerOptions' => [
                'class' => 'page-item'
            ],
            'linkOptions' => [
                'class' => 'page-link'
            ],
            'disabledListItemSubTagOptions' => [
                'class' => 'page-link'
            ]
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'isbn' => [
                'attribute' => 'isbn'
            ],
            'title',
            'published_date' => [
                'attribute' => 'published_date',
                'filter' => false
            ],
            'page_count' => [
                'attribute' => 'page_count',
                'filter' => false
            ],
            'authors' => [
                'attribute' => 'authors',
                'value' => function ($model) {
                    return $model['authors'];
                }
            ],
            'categories' => [
                'attribute' => 'categories',
            ],
            //'thumbnail_url:url',
            //'short_description',
            //'long_description',
            'status' => [
                'attribute' => 'status',
                'filter' => \common\models\Status::getStatusListWithId(),
                'value' => function ($model) {
                    return $model['statusLabel'];
                }
            ],
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Book $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
