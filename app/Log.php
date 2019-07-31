<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    static function desc($log)
    {
        DB::table('logs')->insert(
            ['user_id' => Auth::user()->id, 'description' => $log, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
        );
    }
    public function user()
    {
        return $this->BelongsTo("App\User");
    }
}
