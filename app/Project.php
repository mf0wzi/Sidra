<?php

namespace App;

use App\Noonenew\Marker\Marker;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use TCG\Voyager\Models\DataRow;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public function project_parent()
    {
        return $this->hasMany(Marker::modelClass('ProjectPage'),$foreignKey = 'project_parent_id');
    }
}
