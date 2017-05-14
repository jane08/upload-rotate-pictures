<?php

use yii\db\Schema;
use yii\db\Migration;

class m150817_065029_create_files_table extends Migration
{
    
        public function up()
    {
        $this->createTable('files', array(
			'id' 					=> $this->integer(),
            'path'                  =>  $this->string(255),
            'filemime'              =>  $this->string(255),
            'filesize'              =>  $this->float(),
            'status'                =>  $this->integer(),
			'entity_type'           => $this->string(255)->notNull(),
            'entity_id'             => $this->integer(11)->notNull(),
            'status'                => $this->integer(2),
            'alt'                   => $this->string(255),
            'created_at' 			=> $this->integer(),
            'updated_at' 			=> $this->integer(),
			'PRIMARY KEY (`id`, `entity_type`,`entity_id`)'
        ));
    }
    

    public function down()
    {
         $this->dropTable('files');
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
