<?php

declare(strict_types=1);

use modules\notes\forms\NoteForm;
use modules\notes\models\Note;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var NoteForm $noteForm
 * @var Note $note
 * @var yii\widgets\ActiveForm $form
 */
?>
<div class="note-form">

    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'action' => ['update', 'id' => $noteForm->id],
        'options' => [
            'id' => 'note-form',
        ],
    ]); ?>
    <?= $this->render('_form', [
        'form' => $form,
        'noteForm' => $noteForm,
        'note' => $note,
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('notes', 'Save Note'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>