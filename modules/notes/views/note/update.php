<?php

use modules\notes\forms\NoteForm;
use modules\notes\models\Note;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var NoteForm $noteForm
 * @var Note $note
 */

$this->title = Yii::t('notes', 'Update Note: {title}', [
    'title' => $noteForm->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('notes', 'Notes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $noteForm->title, 'url' => ['view', 'id' => $noteForm->id]];
$this->params['breadcrumbs'][] = Yii::t('notes', 'Update Note');
?>
<div class="note-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('form/_form_update', [
        'noteForm' => $noteForm,
        'note' => $note,
    ]) ?>

</div>
