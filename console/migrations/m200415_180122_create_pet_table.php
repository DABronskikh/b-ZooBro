<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pet}}`.
 */
class m200415_180122_create_pet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pet}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'gender' => $this->string()->notNull(),
            'type' => $this->string()->notNull(),
            'size' => $this->string()->notNull(),
            'breed' => $this->string()->null(),
            'birthday_date' => $this->date()->null(),
            'birthday_years' => $this->string()->null(),
            'food_exceptions' => $this->integer()->defaultValue('0'),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pet}}');
    }
}
