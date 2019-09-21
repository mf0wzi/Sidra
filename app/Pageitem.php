<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use App\Noonenew\Marker\Marker;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Traits\Translatable;
use Composer\Cache;

class Pageitem extends Model
{

    use Translatable;

    protected $translatorMethods = [
        'link' => 'translatorLink',
    ];

    protected $guarded = [];

    protected $translatable = ['title'];
    protected $casts = [
        'labels' => 'string',
        'dataset' => 'string',
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->projectpage->removeMenuFromCache();
        });

        static::saved(function ($model) {
            $model->projectpage->removeMenuFromCache();
        });

        static::deleted(function ($model) {
            $model->projectpage->removeMenuFromCache();
        });
    }

    public function children()
    {
        return $this->hasMany(Marker::modelClass('PageItem'), 'parent_id')
            ->with('children');
//            ->orderBy('order');
    }

    public function projectpage()
    {
        return $this->belongsTo(Marker::modelClass('ProjectPage'));
    }

    public function link($absolute = false)
    {
        return $this->prepareLink($absolute, $this->route, $this->parameters, $this->url);
    }

    public function translatorLink($translator, $absolute = false)
    {
        return $this->prepareLink($absolute, $translator->route, $translator->parameters, $translator->url);
    }

    public function prepareJSON($json)
    {
        if (is_null($json)) {
            $json = [];
        }

        if (is_string($json)) {
            $json = json_decode($json, true);
        } elseif (is_array($json)) {
            $json = $json;
        } elseif (is_object($json)) {
            $json = json_decode(json_encode($json), true);
        }

        return serialize($json);
    }

    protected function prepareLink($absolute, $route, $parameters, $url)
    {
        if (is_null($parameters)) {
            $parameters = [];
        }

        if (is_string($parameters)) {
            $parameters = json_decode($parameters, true);
        } elseif (is_array($parameters)) {
            $parameters = $parameters;
        } elseif (is_object($parameters)) {
            $parameters = json_decode(json_encode($parameters), true);
        }

        if (!is_null($route)) {
            if (!Route::has($route)) {
                return '#';
            }

            return route($route, $parameters, $absolute);
        }

        if ($absolute) {
            return url($url);
        }

        return $url;
    }

    public function getParametersAttribute()
    {
        return json_decode($this->attributes['parameters']);
    }

    public function setParametersAttribute($value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }

        $this->attributes['parameters'] = $value;
    }

    public function setUrlAttribute($value)
    {
        if (is_null($value)) {
            $value = '';
        }

        $this->attributes['url'] = $value;
    }

    /**
     * Return the Highest Order Menu Item.
     *
     * @param number $parent (Optional) Parent id. Default null
     *
     * @return number Order number
     */
    public function highestOrderMenuItem($parent = null)
    {
        $order = 1;

        $item = $this->where('parent_id', '=', $parent)
            ->orderBy('order', 'DESC')
            ->first();

        if (!is_null($item)) {
            $order = intval($item->order) + 1;
        }

        return $order;
    }

    //
}
