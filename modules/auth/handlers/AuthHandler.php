<?php

declare(strict_types=1);

namespace modules\auth\handlers;

use common\models\User;
use Exception;
use modules\auth\exceptions\BadAttributesException;
use modules\auth\exceptions\DoubleUserException;
use modules\auth\models\Auth;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

class AuthHandler
{
    /**
     * @var ClientInterface
     */
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws DoubleUserException
     * @throws Exception
     * @throws \yii\base\Exception
     * @throws BadAttributesException
     */
    public function handle(): void
    {
        $attributes = $this->client->getUserAttributes();
        $email = ArrayHelper::getValue($attributes, 'email');
        $id = ArrayHelper::getValue($attributes, 'id');
        $nickname = ArrayHelper::getValue($attributes, 'login', $email);

        if(is_null($email) || is_null($id)) {
            throw BadAttributesException::unableToAuthorize();
        }

        $auth = Auth::find()->where([
            'source' => $this->client->getId(),
            'source_id' => $id,
        ])->one();

        if (Yii::$app->user->isGuest) {

            if($auth) {
                // just login user
                $this->login($auth->user);
            } else {
                // create the user and link it
                $user = $this->signUp(email: $email, nickname: $nickname, source_id: $id);
                $this->login($user);
            }
        } else { // user already logged in

            if($auth) {
                throw new DoubleUserException(Yii::t('app',
                    'Unable to link {client} account. There is another user using it.',
                    ['client' => $this->client->getTitle()])
                );
            }

            // try to link user
            if(!$this->createAuth(Yii::$app->user->id, $this->client->getId(), (string)$attributes['id'])) {
                throw new Exception(
                    Yii::t('app', 'Unable to link {client} account: {errors}', [
                        'client' => $this->client->getTitle(),
                        'errors' => json_encode($auth->getErrors()),
                    ]),
                );
            }
        }
    }

    /**
     * Sign up a new user and link it to social network
     * @throws Exception
     * @throws \yii\base\Exception
     */
    private function signUp(string $email, string $nickname, string $source_id): User
    {
        if (User::find()->where(['email' => $email])->exists()) {
            throw new DoubleUserException(
                Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $this->client->getTitle()])
            );
        }

        $user = new User([
            'username' => $nickname,
            'email' => $email,
            'password' => Yii::$app->security->generateRandomString(6),
            'status' => User::STATUS_ACTIVE
        ]);

        $user->generateAuthKey();
        $user->generatePasswordResetToken();

        $transaction = User::getDb()->beginTransaction();

        if(!$user->save() || !$this->createAuth($user->id, $this->client->getId(), $source_id)) {

            $transaction->rollBack();

            throw new Exception(
                Yii::t('app', 'Unable to save user: {errors}', [
                    'client' => $this->client->getTitle(),
                    'errors' => json_encode($user->getErrors()),
                ])
            );
        }

        $transaction->commit();

        return $user;
    }

    private function login(User $user): void
    {
        Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
    }

    /**
     * @throws \yii\db\Exception
     */
    private function createAuth(int $user_id, string $client_id, string $source_id): bool
    {
        $auth = new Auth([
            'user_id' => $user_id,
            'source' => $client_id,
            'source_id' => $source_id,
        ]);

        return $auth->save();
    }
}