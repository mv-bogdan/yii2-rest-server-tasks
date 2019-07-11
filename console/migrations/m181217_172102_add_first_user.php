<?php

use yii\db\Migration;

/**
 * Class m181217_172102_add_first_user
 */
class m181217_172102_add_first_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql="INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'demo12', 'msYYcnCvsik9p-xXFh917VQ48fyzhtvR', '$2y$13$4M3N06yd6/sjwcKcal8PceB1nt.x6fJnxEx73iKZZV.tF1KPeILlO', 'mP4czGphDbp3waFgWSRyAPw5uBzgxmiQ_1429844420', 'demo12@gmail.com', 10, 1429844102, 1429846978);
";
        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $sql="DELETE from user where username='demo12'";
        Yii::$app->db->createCommand($sql)->execute();
    }

}
