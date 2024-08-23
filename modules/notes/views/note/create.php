<?php

use modules\notes\forms\NoteForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var NoteForm $noteForm
 */

$this->title = Yii::t('notes', 'New Note');
$this->params['breadcrumbs'][] = ['label' => Yii::t('notes', 'Notes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('form/_form_create', [
        'noteForm' => $noteForm,
    ]) ?>

</div>
