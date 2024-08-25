<?php

declare(strict_types=1);


use modules\notes\forms\NoteForm;
use modules\notes\tests\support\DummyUser;

class TagsValidatorTest extends \Codeception\Test\Unit
{
    protected function _setUp(): void
    {
        $dummyLogin = DummyUser::findIdentity('Dummy');

        Yii::$app->user->login($dummyLogin);
    }

    public function testValid()
    {

        $noteForm = new NoteForm();

        $noteForm->tags = ['tag', 'tag2'];

        $this->assertTrue($noteForm->validate('tags'));

        $noteForm->tags = [];

        $this->assertTrue($noteForm->validate('tags'));
    }

    public function testInvalid()
    {
        $noteForm = new NoteForm();

        $noteForm->tags = ['', 'tag2'];

        $this->assertFalse($noteForm->validate('tags'));
    }
}