<?php

namespace modules\notes\controllers;

use modules\notes\forms\NoteForm;
use modules\notes\models\NoteSearch;
use modules\notes\services\NoteService;
use Throwable;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * NoteController implements the CRUD actions for Note model.
 */
class NoteController extends Controller
{
    protected NoteService $noteService;

    public function __construct(
        $id,
        $module,
        NoteService $noteService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);

        $this->noteService = $noteService;
    }

    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'actions' => [
                            'create' => ['GET'],
                            'edit' => ['GET'],
                            'store' => ['POST'],
                            'update' => ['PUT'],
                            'delete' => ['POST'],
                        ],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }

    public function actionIndex(): string
    {
        $searchModel = new NoteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionView($id): string
    {
        return $this->render('view', [
            'model' => $this->noteService->findNote($id),
        ]);
    }

    public function actionCreate(): string
    {
        return $this->render('create', [
            'noteForm' => new NoteForm(),
        ]);
    }

    public function actionStore(): Response|string|array
    {
        $noteForm = new NoteForm();

        // form ajax validation
        if (Yii::$app->request->isAjax && $noteForm->load(Yii::$app->request->post())) {
            return $this->formAjaxValidate($noteForm);
        }

        try {
            if($noteForm->load($this->request->post()) && $noteForm->validate()) {

                $note = $this->noteService->createNote($noteForm);

                return $this->redirect(['view', 'id' => $note->id]);
            }

        } catch(Throwable $ex) {
            Yii::$app->session->setFlash('error', $ex->getMessage());
        }

        return $this->render('create', [
            'noteForm' => $noteForm,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionEdit(int $id): string
    {
        $note = $this->noteService->findNote($id);

        $noteForm = new NoteForm($id);
        $noteForm->setAttributes($note->attributes);
        $noteForm->tags = $this->noteService->getTags($note);

        return $this->render('update', [
            'note' => $note,
            'noteForm' => $noteForm,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id): Response|string|array
    {
        $noteForm = new NoteForm($id);

        // form ajax validation
        if (Yii::$app->request->isAjax && $noteForm->load(Yii::$app->request->post())) {
            return $this->formAjaxValidate($noteForm);
        }

        try {
            if($noteForm->load($this->request->post()) && $noteForm->validate()) {

                $note = $this->noteService->editNote($noteForm, $id);

                return $this->redirect(['view', 'id' => $note->id]);
            }

        } catch(Throwable $ex) {
            Yii::$app->session->setFlash('error', $ex->getMessage());
        }

        return $this->render('update', [
            'noteForm' => $noteForm,
            'note' => $this->noteService->findNote($id)
        ]);
    }

    public function actionDelete($id): Response
    {
        try {
            $this->noteService->deleteNote($id);
        } catch (Throwable $ex) {
            Yii::$app->session->setFlash('error', $ex->getMessage());
        }

        return $this->redirect(['index']);
    }

    private function formAjaxValidate(NoteForm $noteForm): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($noteForm);
    }
}
