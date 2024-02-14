<?php

use common\models\Book;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= ListView::widget([
        'dataProvider' => $dataProvider,
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
        'layout' => '{summary}<br/><div class="row">{items}</div><br/>{pager}',
        'itemOptions' => ['class' => 'item col-sm-6'],
        'itemView' => function ($model, $key, $index, $widget) {
            $div = Html::tag('div',Html::encode($model->title),['class' => 'book-item']);
            return Html::a($div, ['book/view', 'id' => $model->id]);
        },
    ]) ?>


</div>
