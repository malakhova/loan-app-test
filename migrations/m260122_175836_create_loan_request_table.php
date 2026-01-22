<?php

use yii\db\Migration;

/**
 * Handles the creation of table `loan_request`.
 */
class m260122_175836_create_loan_request_table extends Migration
{
    /**
     * @inheritDoc
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE loan_request_status AS ENUM ('pending', 'approved', 'declined')");
        $this->createTable('loan_request', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'amount' => $this->integer()->notNull()->comment('Сумма займа'),
            'term' => $this->integer()->notNull()->comment('Срок займа в днях'),
            'status' => 'loan_request_status NOT NULL DEFAULT \'pending\'',
            'created_at' => $this->integer()->notNull(),
            'processed_at' => $this->integer()->null(),
        ]);

        $this->createIndex('idx-loan_request-user_id', 'loan_request', 'user_id');
        $this->createIndex('idx-loan_request-status', 'loan_request', 'status');
        $this->createIndex(
            'idx-loan_request-user_id_status',
            'loan_request',
            ['user_id', 'status']
        );
    }

    /**
     * @inheritDoc
     */
    public function safeDown()
    {
        $this->dropIndex('idx-loan_request-user_id_status', 'loan_request');
        $this->dropIndex('idx-loan_request-status', 'loan_request');
        $this->dropIndex('idx-loan_request-user_id', 'loan_request');
        $this->dropTable('loan_request');
        $this->execute("DROP TYPE loan_request_status");
    }
}
