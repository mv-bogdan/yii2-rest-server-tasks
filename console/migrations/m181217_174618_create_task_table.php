<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task`.
 */
class m181217_174618_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'title' => $this->string(),
            'content' => $this->text(),
            'date_complete' => $this->string(),
            'date_of_completion' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx-task-user_id', '{{%task}}', 'user_id');

        $this->addForeignKey('fk-task-user_id', '{{%task}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%task}}');
    }
}
