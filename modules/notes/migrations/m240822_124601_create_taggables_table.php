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
        ]);

        $this->addForeignKey(
            'fk_taggables_tag_id',
            '{{%taggables}}',
            'tag_id',
            '{{%tags}}',
            'id',
            'cascade',
            'cascade'
        );

        $this->addForeignKey(
            'fk_taggables_taggable_id',
            '{{%taggables}}',
            'taggable_id',
            '{{%notes}}',
            'id',
            'cascade',
            'cascade'
        );
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
