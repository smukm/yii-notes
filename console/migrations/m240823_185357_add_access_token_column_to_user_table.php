<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m240823_185357_add_access_token_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn(
            '{{%user}}',
            'access_token',
            $this->string()->defaultValue(null)
        );
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'access_token');
    }
}
