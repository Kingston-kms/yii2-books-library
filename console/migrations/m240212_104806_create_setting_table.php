<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%setting}}`.
 */
class m240212_104806_create_setting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%setting}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string(20)->notNull()->unique(),
            'value' => $this->string(255)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%setting}}');
    }
}
