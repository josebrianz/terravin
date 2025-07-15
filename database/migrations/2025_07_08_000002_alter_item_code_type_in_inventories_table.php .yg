<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE inventories MODIFY item_code VARCHAR(255)');
    }

    public function down()
    {
        DB::statement('ALTER TABLE inventories MODIFY item_code INT'); // Change INT to the original type if needed
    }
}; 