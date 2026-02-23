<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class NormalizeCategoryContents extends Migration
{
    public function up()
    {
        DB::table('categories')
            ->where('content', 'like', 'id)>%')
            ->update([
                'content' => DB::raw("TRIM(REPLACE(content, 'id)>', ''))"),
            ]);
    }

    public function down()
    {
        //
    }
}

