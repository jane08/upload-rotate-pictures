<?php

use yii\db\Migration;

/**
 * Handles the creation of table `picture`.
 */
class m170514_090022_create_picture_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('picture', [
            'id' => $this->primaryKey(),
			'user_id' => $this->integer()->notNull(),
			'image_link' => $this->text(),
			'created_at' 		=> $this->integer(),
            'updated_at' 		=> $this->integer(),
        ]);
		
		 // creates index for column `user_id`
        $this->createIndex(
            'idx-picture-user_id',
            'picture',
            'user_id'
        );
		
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
		 // drops index for column `user_id`
        $this->dropIndex(
            'idx-picture-user_id',
            'picture'
        );
        $this->dropTable('picture');
    }
}
