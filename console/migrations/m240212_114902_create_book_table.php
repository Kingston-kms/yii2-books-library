<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m240212_114902_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'isbn' => $this->string(50)->defaultValue(''),
            'title' => $this->string(255)->defaultValue(''),
            'published_date' => $this->timestamp(),
            'page_count' => $this->smallInteger(5)->unsigned()->defaultValue(0),
            'thumbnail_url' => $this->string(255)->defaultValue(''),
            'short_description' => $this->string(2000)->defaultValue(''),
            'long_description' => $this->string(5000)->defaultValue(''),
            'status' => $this->integer(10)->notNull()
        ]);
        $this->createIndex("idx_book_isbn", '{{%book}}', 'isbn');
        $this->addForeignKey("fk_book_status",'{{%book}}', 'status', '{{%status}}','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%book}}');
    }
}
