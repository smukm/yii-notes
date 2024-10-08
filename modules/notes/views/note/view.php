<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var modules\notes\models\Note $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('notes', 'Notes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="note-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Edit'), ['edit', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'content:ntext',
            [
                'attribute' => 'tags',
                'label' => Yii::t('notes', 'Tags'),
                'value' => function () use ($model) {
                    $ret = [];
                    foreach($model->tags as $tag) {
                        $ret[] = $tag->title;
                    }
                    return implode(', ', $ret);
                }
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
