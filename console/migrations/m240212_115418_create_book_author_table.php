<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_author}}`.
 */
class m240212_115418_create_book_author_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book_author}}', [
            'id' => $this->primaryKey(),
            'book' => $this->integer(10)->notNull(),
            'author' => $this->integer(10)->notNull()
        ]);
        $this->addForeignKey('fk_book_ba', '{{%book_author}}','book', '{{%book}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_author_ba', '{{%book_author}}', 'author', '{{%author}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%book_author}}');
    }
}
