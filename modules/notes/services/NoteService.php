<?php

declare(strict_types=1);

namespace modules\notes\services;

use DomainException;
use modules\notes\forms\NoteForm;
use modules\notes\models\Note;
use Throwable;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

class NoteService
{
    /**
     * @throws NotFoundHttpException
     */
    public function findNote(int $id): array|ActiveRecord|null|Note
    {
        if (($model = Note::find()
                ->forCurrentUser()
                ->where(['id' => $id])
                ->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @throws Exception
     */
    public function createNote(NoteForm $noteForm): Note
    {
        $note = Note::create(
            title: $noteForm->title,
            content: $noteForm->content,
            user_id: $noteForm->user_id
        );

        $note->tagValues = $noteForm->tags;

        if(!$note->save()) {
            throw new DomainException(Yii::t('notes', 'Unable to create a note'));
        }

        return $note;
    }

    public function editNote(NoteForm $noteForm, int $note_id): Note
    {
        $note = $this->findNote($note_id);
        $note->title = $noteForm->title;
        $note->content = $noteForm->content;
        $note->updated_at = date('Y-m-d H:i:s');

        $note->tagValues = $noteForm->tags;

        if (!$note->save()) {
            throw new DomainException('Unable to update book');
        }

        return $note;
    }

    /**
     * @throws Throwable
     * @throws StaleObjectException
     * @throws NotFoundHttpException
     */
    public function deleteNote(int $note_id): bool
    {
        $book = $this->findNote($note_id);

        return (bool) $book->delete();
    }


    public function getTags(Note $note): array
    {
        return ArrayHelper::map($note->getTags()->all(), 'title', 'title');
    }
}