<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class option extends Model
{
	use Traits\HasCompositePrimaryKey;
    protected $table = 'option';
    protected $connection = 'mysql';
    protected $primaryKey = ('opt_id','opt_value','workspace_id');

    public function option()
    {
        return $this->belongsTo('App\workspac');
    }
}
