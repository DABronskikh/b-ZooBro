<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m200415_180141_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'pet_id' => $this->integer(11)->notNull(),
            'price_id' => $this->integer(11)->notNull(),
            'size' => $this->string(255),
            'status_id' => $this->integer(11)->defaultValue('0'),
            'address' => $this->string(255)->null(),
            'date_create' => $this->timestamp(),
            'date_delivery' => $this->date(),
            'time_delivery' => $this->time(),
            'user_id' => $this->string(11),
            'cost' => $this->float(),
            'comment' => $this->string(1500)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}
