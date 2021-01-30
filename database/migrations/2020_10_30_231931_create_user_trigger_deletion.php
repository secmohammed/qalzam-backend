<?php

use Illuminate\Database\Migrations\Migration;

class CreateUserTriggerDeletion extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::unprepared('DROP TRIGGER `trigger_user_deletion_to_delete_its_media_collection`');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::unprepared("
        CREATE TRIGGER trigger_user_deletion_to_delete_its_media_collection AFTER DELETE ON `users` FOR EACH ROW
            BEGIN
                DELETE  FROM media where model_type='App\Domain\User\Entities\User' AND model_id=old.id;
            END
        ");
    }
}
