<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var common\models\Category $model */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var yii\data\ActiveDataProvider $bookDataProvider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="category-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if ($dataProvider->getTotalCount()) { ?>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item col-sm-6'],
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
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
        },
    ]) ?>
    <?php } ?>

    <?= ListView::widget([
        'dataProvider' => $bookDataProvider,
        'itemOptions' => ['class' => 'item col-sm-6'],
        'layout' => '{summary}<br/><div class="row">{items}</div><br/>{pager}',
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
        'itemView' => function ($model, $key, $index, $widget) {
            $div = Html::tag('div',Html::encode($model->title),['class' => 'book-item']);
            return Html::a($div, ['book/view', 'id' => $model->id]);
        },
    ]) ?>

</div>
