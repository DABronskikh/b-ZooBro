<?php

use yii\db\Migration;

/**
 * Class m200430_062600_create_order_status
 */
class m200430_062600_create_order_status extends Migration
{
    public function up()
    {
        $this->createTable('{{%order_status}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50),
        ]);
    }
}
