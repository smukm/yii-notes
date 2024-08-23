<?php

use kartik\select2\Select2;
use modules\notes\forms\NoteForm;
use modules\notes\models\Note;
use modules\notes\models\Tag;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var NoteForm $noteForm
 * @var Note $note
 * @var yii\widgets\ActiveForm $form
 */
?>


<div class="row mb-3">
    <?= $form->field($noteForm, 'title')->textInput(['maxlength' => true]) ?>
</div>
<div class="row mb-3">
    <?= $form->field($noteForm, 'content')->textarea(['rows' => 6]) ?>
</div>
<div class="row mb-3">
    <?= $form->field($noteForm, 'tags')->widget(Select2::class, [
        'data' => Tag::getList(),
        'options' => ['placeholder' => 'Выберите теги ...', 'multiple' => true],
        'theme' => Select2::THEME_BOOTSTRAP,
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 50
        ],
    ]) ?>
</div>




