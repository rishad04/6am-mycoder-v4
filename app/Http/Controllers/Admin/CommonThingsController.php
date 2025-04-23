<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CommonThingsController extends Controller
{
    public function toggleSwitchStatus(Request $request)
    {
        $table  = $request->table;
        $column = $request->column;
        $id     = $request->id;
        $value  = $request->value;

        DB::table($table)->where('id', $id)->update([
            $column => $request->value
        ]);


        return 1;
    }
}
