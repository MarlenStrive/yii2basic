<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `presentation`.
 */
class m180118_155727_create_presentation_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('category', [
            'id' => Schema::TYPE_PK,
            'category' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
        $this->insert('category', [
            'category' => 'Common',
        ]);
        
        $this->createTable('presentation', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_TEXT . ' NULL',
            'is_public' => Schema::TYPE_BOOLEAN . ' NOT NULL',
            'image_preview' => Schema::TYPE_STRING . ' NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'publication_date' => Schema::TYPE_DATE . ' NULL DEFAULT NULL',
            'expiration_date' => Schema::TYPE_DATE . ' NULL DEFAULT NULL',
            'public_url' => Schema::TYPE_STRING . ' NOT NULL',
            'rating' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'category_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
        $this->addForeignKey('fk_presentation_user_id', 'presentation', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_presentation_category_id', 'presentation', 'category_id', 'category', 'id', 'CASCADE', 'CASCADE');
        
        $this->createTable('presentation_page', [
            'id' => Schema::TYPE_PK,
            'presentation_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'number' => Schema::TYPE_INTEGER . ' NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'note' => Schema::TYPE_TEXT . ' NULL',
        ]);
        $this->addForeignKey('fk_presentation_page_presentation_id', 'presentation_page', 'presentation_id', 'presentation', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('indx_presentation_number', 'presentation_page', ['presentation_id', 'number'], true); // unique index
        
        $this->createTable('presentation_editor', [
            'presentation_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
        $this->addForeignKey('fk_presentation_editor_presentation_id', 'presentation_editor', 'presentation_id', 'presentation', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_presentation_editor_user_id', 'presentation_editor', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        
        $this->createTable('presentation_viewer', [
            'presentation_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
        $this->addForeignKey('fk_presentation_viewer_presentation_id', 'presentation_viewer', 'presentation_id', 'presentation', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_presentation_viewer_user_id', 'presentation_viewer', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        
        $this->createTable('tag', [
            'id' => Schema::TYPE_PK,
            'tag' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
        
        $this->createTable('presentation_tag', [
            'presentation_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'tag_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
        $this->addForeignKey('fk_presentation_tag_presentation_id', 'presentation_tag', 'presentation_id', 'presentation', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_presentation_tag_tag_id', 'presentation_tag', 'tag_id', 'tag', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('presentation_tag');
        $this->dropTable('tag');
        
        $this->dropTable('presentation_viewer');
        $this->dropTable('presentation_editor');
        
        $this->dropTable('presentation_page');
        $this->dropTable('presentation');
        
        $this->dropTable('category');
    }
}
