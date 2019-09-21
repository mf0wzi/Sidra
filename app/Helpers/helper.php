<?php

use App\Projectpage;

if (!function_exists('pageitem')) {
    function pageitem($menuName, $type = null, array $options = [])
    {
        //dd($menuName);
        $projectitem = new Projectpage();
        return $projectitem->display($menuName, $type, $options);
    }
}
