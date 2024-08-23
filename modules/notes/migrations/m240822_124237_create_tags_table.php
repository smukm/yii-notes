<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tags}}`.
 */
class m240822_124237_create_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%tags}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(150)
                ->notNull(),
            'slug' => $this->string(150)
                ->notNull(),
        ]);

        $this->createIndex('idx_tags_title', '{{%tags}}', 'title', true);
        $this->createIndex('idx_tags_slug', '{{%tags}}', 'slug', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        if(YII_ENV === 'dev') {
            $this->dropTable('{{%tags}}');
        }
    }
}
