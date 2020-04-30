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
            'user_id' => $this->integer(11)->notNull(),
            'name' => $this->string(255)->notNull(),
            'gender' => $this->string(255)->notNull(),
            'type' => $this->string(255)->notNull(),
            'size' => $this->string(50)->notNull(),
            'breed' => $this->string(100)->null(),
            'birthday_date' => $this->date()->null(),
            'birthday_years' => $this->string(50)->null(),
            'food_exceptions' => $this->integer(255)->defaultValue('0'),

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
