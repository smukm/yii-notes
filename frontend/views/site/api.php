<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'API';
?>
<div class="site-api mt-5">
    <h4><?= Html::encode($this->title) ?></h4>

    <div class="row">
        <div class="col-md-6">
            <div class="row mb-3">
                <h5>Get all notes:</h5>
                <code>GET: <?=Yii::$app->params['API_HOST']?>/v1/notes</code>
            </div>

            <div class="row mb-3">
                <h5>Get one note:</h5>
                <code>GET: <?=Yii::$app->params['API_HOST']?>/v1/notes/{note_id}</code>
            </div>

            <div class="row mb-3">
                <h5>Create a note:</h5>
                <code>POST: <?=Yii::$app->params['API_HOST']?>/v1/notes</code>
                <pre>
Body json: {
                "title": "The title",
                "content": "Content of the note"
            }
        </pre>
            </div>

            <div class="row mb-3">
                <h5>Edit note:</h5>
                <code>PUT: <?=Yii::$app->params['API_HOST']?>/v1/notes/{note_id}</code>
                <pre>
Body json: {
                "title": "New title",
                "content": "New content of the note"
            }
        </pre>
            </div>

            <div class="row mb-3">
                <h5>Delete note:</h5>
                <code>DELETE: <?=Yii::$app->params['API_HOST']?>/v1/notes/{note_id}</code>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row mb-3">
                <h5>Authorization: Bearer Token:</h5>
                <code>Your token: <?=Yii::$app->user->identity->getAccessToken()?></code>
                <form method="POST" action="<?= Url::to(['site/refresh-token'])?>">
                    <input type="hidden" name="<?=Yii::$app->request->csrfParam?>"
                           value="<?=Yii::$app->request->csrfToken?>"/>
                    <input class="btn btn-warning" type="submit" value="Refresh token">
                </form>
            </div>
        </div>
    </div>



</div>
