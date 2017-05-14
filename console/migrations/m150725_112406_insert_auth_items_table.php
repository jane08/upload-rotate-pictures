<?php

use yii\db\Schema;
use yii\db\Migration;

class m150725_112406_insert_auth_items_table extends Migration
{
    public function up()
    {
			$this->insert('auth_item', [
                   'name' => 'picture',
                   'type' => '1',
				   'description' => 'pictures',
		]);
			$this->insert('auth_item', [
                   'name' => 'picture.create',
                   'type' => '2',
				   'description' => 'picture.create',
		]);
		$this->insert('auth_item', [
                   'name' => 'picture.update',
                   'type' => '2',
				   'description' => 'picture.update',
		]);
		
		$this->insert('auth_item', [
                   'name' => 'picture.delete',
                   'type' => '2',
				   'description' => 'picture.delete',
		]);
		
		
		$this->insert('auth_item', [
                   'name' => 'picture.view',
                   'type' => '2',
				   'description' => 'picture.view',
		]);
		
		
		
		
		
    }

    public function down()
    {
        echo "m150725_112406_insert_auth_items_table cannot be reverted.\n";

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
