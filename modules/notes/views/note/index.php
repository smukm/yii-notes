<?php

declare(strict_types = 1);

use modules\notes\models\Note;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/**
 * @var yii\web\View $this
 * @var modules\notes\models\NoteSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('notes', 'Notes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-index">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a(Yii::t('notes', 'Create Note'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'content:ntext',
            'created_at',
            [
              'header' => Yii::t('notes', 'Tags'),
              'value' => static function ($data) {
                  $ret = [];
                  foreach ($data->tags as $tag) {
                      $ret[] = $tag->title;
                  }

                  return implode(' ', $ret);
              }
            ],
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Note $model) {
                    if($action === 'update') {
                        $action = 'edit';
                    }
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
