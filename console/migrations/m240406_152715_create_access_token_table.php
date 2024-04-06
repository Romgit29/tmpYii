<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%access_token}}`.
 */
class m240406_152715_create_access_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%access_token}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'access_token' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk-access_token-user_id',
            'access_token',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%access_token}}');
    }
}