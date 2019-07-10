<?php

use yii\db\Migration;

/**
 * Handles the creation of table `city`.
 */
class m190710_105347_create_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('city', [
            'ref' => $this->string(36),
            'name' => $this->string()->notNull()
        ]);

        $this->addPrimaryKey('pk-city', 'city', 'ref');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('city');
    }
}
