<?php

use Illuminate\Database\Migrations\Migration;

class CreateUserAuthView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW user_auth AS
                SELECT u.id, u.name, u.email, a.password
                FROM users u
                JOIN admins a ON a.user_id = u.id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW user_auth");
    }
}
