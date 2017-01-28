<?php

use yii\db\Migration;

class m160716_193019_initials_fks extends Migration
{
    public function up()
    {
        $this->addForeignKey('fk_groups_created_by', '{{%groups}}', 'created_by', '{{%users}}', 'id', 'RESTRICT', 'RESTRICT');

        $this->update('{{%groups}}', ['created_by' => 1]);
        $this->update('{{%users}}', ['created_by' => 1]);
    }

    public function down()
    {
        $this->dropForeignKey('fk_groups_created_by', '{{%groups}}');

        $this->update('{{%groups}}', ['created_by' => null]);
        $this->update('{{%users}}', ['created_by' => null]);
    }
}
