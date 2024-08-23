<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%taggables}}`.
 */
class m240822_124601_create_taggables_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%taggables}}', [
            'id' => $this->primaryKey(),
            'tag_id' => $this->integer()
                ->notNull(),
            'taggable_id' => $this->integer()
                ->notNull(),
            'taggable_type' => $this->string(255)
                ->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        if(YII_ENV === 'dev') {
            $this->dropTable('{{%taggables}}');
        }
    }
}
