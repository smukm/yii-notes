<?php

declare(strict_types=1);

namespace modules\notes\tests\support;

use common\models\User;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


class DummyUser extends User implements IdentityInterface
{
    public $id = 'Foo';
    public $email = '';
    public string $name = '';

    public static function findIdentity($id): User|IdentityInterface|null
    {
        return new static ([
            'id' => 'Dummy',
            'email' => 'dummy@dummy',
            'name' => 'Dummy User'

        ]);
    }

    public function getId(): int
    {
        return 1;
    }

    public static function findIdentityByAccessToken($token, $type = null): array|ActiveRecord|IdentityInterface|null
    {
        return null;
    }

    public function getAuthKey(): ?string
    {
        return 'dummy';
    }

    public function validateAuthKey($authKey): ?bool
    {
        return true;
    }
}