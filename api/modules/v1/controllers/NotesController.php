<?php

namespace api\modules\v1\controllers;

use api\modules\exceptions\NotValidException;
use api\modules\v1\BaseController;
use api\modules\v1\resources\Note;
use modules\notes\forms\NoteForm;
use modules\notes\services\NoteService;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\rest\IndexAction;
use yii\rest\OptionsAction;
use yii\rest\ViewAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class NotesController extends BaseController
{

    public $modelClass = Note::class;

    private NoteService $noteService;

    public function __construct(
        $id,
        $module,
        NoteService $noteService,
        $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->noteService = $noteService;
    }

    public function actions(): array
    {
        return [
            'index' => [
                'class' => IndexAction::class,
                'modelClass' => $this->modelClass,
                'prepareDataProvider' => [$this, 'prepareDataProvider']
            ],
            'view' => [
                'class' => ViewAction::class,
                'modelClass' => $this->modelClass,
                'findModel' => [$this->noteService, 'findNote']
            ],
            'options' => [
                'class' => OptionsAction::class,
            ],
        ];
    }

    public function actionCreate(): Response
    {
        try {
            $body = Yii::$app->request->getBodyParams();

            $noteForm = new NoteForm();
            $noteForm->title = $body['title'] ?? '';
            $noteForm->content = $body['content'] ?? '';

            if(!$noteForm->validate()) {
                throw new NotValidException($noteForm->getFirstErr());
            }

            $note = $this->noteService->createNote($noteForm);

            return $this->asJson($note);

        } catch (Throwable $ex) {
            return $this->handleError($ex);
        }
    }

    public function actionUpdate(int $id): Response
    {
        try {
            $body = Yii::$app->request->getBodyParams();

            $noteForm = new NoteForm();
            $noteForm->title = $body['title'] ?? '';
            $noteForm->content = $body['content'] ?? '';

            if(!$noteForm->validate()) {
                throw new NotValidException($noteForm->getFirstErr());
            }

            $note = $this->noteService->editNote($noteForm, $id);

            return $this->asJson($note);
        } catch (Throwable $ex) {
            return $this->handleError($ex);
        }
    }

    public function actionDelete(int $id)
    {
        try {
            $this->noteService->deleteNote($id);
        } catch (Throwable $ex) {
            return $this->handleError($ex);
        }
    }

    public function prepareDataProvider(): ActiveDataProvider
    {
        return new ActiveDataProvider(array(
            'query' => Note::find()->with('tags'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ));
    }

    private function handleError(Throwable $ex): Response
    {
        if($ex instanceof NotValidException) {
            $this->response->setStatusCode(400);
        } else {
            Yii::error($ex->getMessage());
            $this->response->setStatusCode(500);
        }

        return $this->asJson([
                'error' => $ex->getMessage(),
                'code' => $ex->getCode()]
        );
    }
}
