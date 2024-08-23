<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%notes}}`.
 */
class m240822_122200_create_notes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%notes}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)
                ->notNull(),
            'content' => $this->text()
                ->notNull(),
            'user_id' => $this->integer()
                ->notNull(),
            'created_at' => $this->dateTime()
                ->notNull(),
            'updated_at' => $this->dateTime()
                ->notNull(),
        ]);

        $this->addForeignKey(
            'fk_notes_user_id',
            '{{%notes}}',
            'user_id',
            '{{%user}}',
            'id',
            'cascade',
            'cascade'
        );

        $this->execute("ALTER TABLE notes ADD FULLTEXT INDEX ft_content (content)");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        if(YII_ENV === 'dev') {
            $this->dropTable('{{%notes}}');
        }
    }
}
