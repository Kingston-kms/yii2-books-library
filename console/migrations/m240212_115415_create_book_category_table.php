<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_category}}`.
 */
class m240212_115415_create_book_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book_category}}', [
            'id' => $this->primaryKey(),
            'book' => $this->integer(10)->notNull(),
            'category' => $this->integer(10)->notNull()
        ]);
        $this->addForeignKey('fk_book_bc', '{{%book_category}}','book', '{{%book}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_category_bc', '{{%book_category}}', 'category', '{{%category}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%book_category}}');
    }
}
