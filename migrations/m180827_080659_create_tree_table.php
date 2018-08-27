<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tree`.
 */
class m180827_080659_create_tree_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tree', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'link' => $this->string()->notNull(),
            'parent_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tree');
    }
}
