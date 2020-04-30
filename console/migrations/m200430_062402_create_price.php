<?php

use yii\db\Migration;

/**
 * Class m200430_062402_create_price
 */
class m200430_062402_create_price extends Migration
{
    public function up()
    {
        $this->createTable('{{%price}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'cost' => $this->float(),
        ]);

    }
}
