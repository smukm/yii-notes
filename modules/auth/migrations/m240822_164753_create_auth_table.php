<?php

declare(strict_types = 1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auth}}`.
 */
class m240822_164753_create_auth_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%auth}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-auth-user_id-user-id',
            '{{%auth}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        if(YII_ENV === 'dev') {
            $this->dropTable('{{%auth}}');
        }
    }
}
