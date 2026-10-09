<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BackfillIsActiveForExistingVendors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Vendor accounts were auto-active until now (nothing ever checked
        // is_active). Grandfather in anyone who signed up before this
        // migration - the new pending-approval gate should only apply to
        // vendors registering from here on, not lock out everyone who was
        // already functionally active.
        DB::table('users')
            ->whereIn('user_type', ['V', 'CH', 'R'])
            ->whereNull('is_active')
            ->update(['is_active' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
