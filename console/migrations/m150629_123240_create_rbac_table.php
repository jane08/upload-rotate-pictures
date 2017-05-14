<?php

use yii\db\Schema;
use yii\db\Migration;

class m150629_123240_create_rbac_table extends Migration
{
    public function up()
    {
		$this->execute( file_get_contents( Yii::getAlias('@vendor/yiisoft/yii2/rbac/migrations/schema-mysql.sql')));

    }

    public function down()
    {
        echo "m150629_123240_create_rbac_table cannot be reverted.\n";

        return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
