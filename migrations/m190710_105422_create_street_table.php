<?php

use yii\db\Migration;

/**
 * Handles the creation of table `street`.
 */
class m190710_105422_create_street_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('street', [
            'ref' => $this->string(36),
            'name' => $this->string()->notNull(),
            'city_ref' => $this->string(36)->notNull()
        ]);

        $this->addPrimaryKey('pk-street', 'street', 'ref');

        $this->createIndex(
            'idx-street-city_ref',
            'street',
            'city_ref'
        );

        $this->addForeignKey(
            'fk-street-city_ref',
            'street',
            'city_ref',
            'city',
            'ref',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-street-city_ref',
            'street'
        );

        $this->dropIndex(
            'idx-street-city_ref',
            'street'
        );

        $this->dropTable('street');
    }
}
