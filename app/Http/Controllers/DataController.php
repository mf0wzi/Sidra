<?php

namespace App\Http\Controllers;

class DataController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public static $id,$title,$template,$tile,$sub_type,$iconClass,$class,$color,$labels,
        $connection,$dataset,$marker,$tooltip,$popup,$chart_options,$map_options,$custom_function,$sql,$description,$url;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function getData(array $arguments)
    {
        self::processData($arguments);

        try {
            $dashlets = lcfirst(str_replace("-","",ucwords(self::$template, "-")));
            return DataElementsController::$dashlets();
        } catch (\Error $e) {
            return self::noDashlet($e->getMessage());
        }

        /*$templateFunction = self::$template == 'box' ? DataElementsController::box():
            (self::$template == 'callout' ? DataElementsController::callout():
            (self::$template == 'small-box' ? DataElementsController::smallBox():
            (self::$template == 'small-box-two' ? DataElementsController::smallBoxTwo():
            (self::$template == 'small-box-detail' ? DataElementsController::smallBoxDetail():
            (self::$template == 'info-box' ? DataElementsController::infoBox():
            (self::$template == 'info-box-two' ? DataElementsController::infoBoxTwo():
            (self::$template == 'info-box-detail' ? DataElementsController::infoBoxDetail():
            (self::$template == 'widget-user' ? DataElementsController::widgetUser():
            (self::$template == 'chart' ? DataElementsController::chart():
            (self::$template == 'chart-statistics' ? DataElementsController::chartStatistics():
            (self::$template == 'chart-in-box' ? DataElementsController::chartInBox():
            (self::$template == 'chart-in-box-statistics' ? DataElementsController::chartInBoxStatistics(): self::noDashlet()
            ))))))))))));

        return $templateFunction;*/

    }

    protected static function processData(array $arguments)
    {

        $items[] = (object)$arguments;
        $object = (object)$arguments;

        foreach ($items as $argument) {
            if (property_exists($object, 'item_id')) {
                self::$id = $argument->item_id ?: null;
            } else {
                self::$id = null;
            }
            if (property_exists($object, 'title')) {
                self::$title = $argument->title ?: null;
            } else {
                self::$title = null;
            }
            if (property_exists($object, 'template')) {
                self::$template = $argument->template ?: null;
            } else {
                self::$template = null;
            }
            if (property_exists($object, 'tile')) {
                self::$tile = $argument->tile ?: null;
            } else {
                self::$tile = null;
            }
            if (property_exists($object, 'sub_type')) {
                self::$sub_type = $argument->sub_type ?: null;
            } else {
                self::$sub_type = null;
            }
            if (property_exists($object, 'iconClass')) {
                self::$iconClass = $argument->iconClass ?: null;
            } else {
                self::$iconClass = null;
            }
            if (property_exists($object, 'class')) {
                self::$class = $argument->class ?: null;
            } else {
                self::$class = null;
            }
            if (property_exists($object, 'color')) {
                self::$color = $argument->color ?: null;
            } else {
                self::$color = null;
            }
            if (property_exists($object, 'labels')) {
                self::$labels = $argument->labels ?: null;
            } else {
                self::$labels = null;
            }
            if (property_exists($object, 'connection_type')) {
                self::$connection = $argument->connection_type ?: null;
            } else {
                self::$connection = null;
            }
            if (property_exists($object, 'dataset')) {
                self::$dataset = $argument->dataset ?: null;
            } else {
                self::$dataset = null;
            }
            if (property_exists($object, 'marker')) {
                self::$marker = $argument->marker ?: null;
            } else {
                self::$marker = null;
            }
            if (property_exists($object, 'tooltip')) {
                self::$tooltip = $argument->tooltip ?: null;
            } else {
                self::$tooltip = null;
            }
            if (property_exists($object, 'popup')) {
                self::$popup = $argument->popup ?: null;
            } else {
                self::$popup = null;
            }
            if (property_exists($object, 'chart_options')) {
                self::$chart_options = $argument->chart_options ?: null;
            } else {
                self::$chart_options = null;
            }
            if (property_exists($object, 'map_options')) {
                self::$map_options = $argument->map_options ?: null;
            } else {
                self::$map_options = null;
            }
            if (property_exists($object, 'map_options')) {
                self::$map_options = $argument->map_options ?: null;
            } else {
                self::$map_options = null;
            }
            if (property_exists($object, 'custom_function')) {
                self::$custom_function = $argument->custom_function ?: null;
            } else {
                self::$custom_function = null;
            }
            if (property_exists($object, 'sql')) {
                self::$sql = $argument->sql ?: null;
            } else {
                self::$sql = null;
            }
            if (property_exists($object, 'description')) {
                self::$description = $argument->description ?: null;
            } else {
                self::$description = null;
            }
            if (property_exists($object, 'url')) {
                self::$url = $argument->url ?: null;
            } else {
                self::$url = null;
            }
        }
    }

    protected static function noDashlet($e){
        $data = 'No Such';
        $title = 'Dashlet';
        $error = $e;

        $view = 'errors.errorbox.error';
        return view($view)->with('data',$data)->with('title',$title)->with('error',$error);
    }

    public static function abortCustom($error,$errorMessage){
        $view = 'errors.'.$error;
        return view($view)->with('errorMessage',$errorMessage);
    }

}
