<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = Yii::t('app', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h4><?= Html::encode($this->title) ?></h4>


    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')
                    ->textInput(['autofocus' => true])
                    ->label(Yii::t('app', 'Username'))
                ?>

                <?= $form->field($model, 'email')
                    ->label(Yii::t('app', 'email'))
                ?>

                <?= $form->field($model, 'password')->passwordInput()
                    ->label(Yii::t('app', 'Password'))
                ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
