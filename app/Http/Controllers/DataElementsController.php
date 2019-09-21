<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Pagination\LengthAwarePaginator;

abstract class DataElementsController extends DataController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    protected static function singleData($sql,$connection = null)
    {
        try {
            if($connection == 'all') {
                $result = reset(DB::select(DB::raw($sql))[0]);
            } else {
                $result = reset(DB::connection($connection)->select(DB::raw($sql))[0]);
            }
        } catch (\Exception $e) {
            $data = 'SQL';
            $title = 'ERROR';
            $error = $e->getMessage();
            $view = 'errors.errorbox.error';
            return view($view)->with('data',$data)->with('title',$title)->with('error',$error);
        }
        return $result;
    }

    protected static function multiData($sql,$connection = null)
    {
//        try {
            if($connection == 'all') {
                $result = DB::select(DB::raw($sql));
            } else {
                $result = DB::connection($connection)->select(DB::raw($sql));
            }
//        } catch (\Exception $e) {
//            $data = 'SQL';
//            $title = 'ERROR';
//            $error = $e->getMessage();
//            $view = 'errors.errorbox.error';
//            return view($view)->with('data',$data)->with('title',$title)->with('error',$error);
//        }
        return $result;
    }

    protected static function mapData($sql,$connection = null)
    {
        try {
            if($connection == 'all') {
                $result = DB::select(DB::raw($sql));
            } else {
                $result = DB::connection($connection)->select(DB::raw($sql));
            }
        } catch (\Exception $e) {
            $data = 'SQL';
            $title = 'ERROR';
            $error = $e->getMessage();
            $view = 'errors.errorbox.error';
            return view($view)->with('data',$data)->with('title',$title)->with('error',$error);
        }
        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE)->getData();
    }

    protected static function dataType($dataType,$data)
    {
        if(is_numeric($data)){
            if($dataType == 'number') {
                $result = number_format($data);
            } else if($dataType == 'numberfloat'){
                $result = number_format($data,2);
            } else if($dataType == 'numberplain'){
                $result = number_format($data,2, '.', '');
            } else if(strpos($dataType, 'currencyshort') !== false) {
                // Setup default $divisors if not provided

                $divisors = null;
                $precision_number = substr($dataType, strpos($dataType, "_") + 1);
                if (is_numeric($precision_number) == true) {
                    $precision = $precision_number;
                } else {
                    $precision = 3;
                }

                if (!isset($divisors)) {
                    $divisors = array(
                        pow(1000, 0) => '', // 1000^0 == 1
                        pow(1000, 1) => 'K', // Thousand
                        pow(1000, 2) => 'M', // Million
                        pow(1000, 3) => 'B', // Billion
                        pow(1000, 4) => 'T', // Trillion
                        pow(1000, 5) => 'Qa', // Quadrillion
                        pow(1000, 6) => 'Qi', // Quintillion
                    );
                }

                // Loop through each $divisor and find the
                // lowest amount that matches
                foreach ($divisors as $divisor => $shorthand) {
                    if (abs($data) < ($divisor * 1000)) {
                        // We found a match!
                        break;
                    }
                }

                // We found our match, or there were no matches.
                // Either way, use the last defined value for $divisor.
                $result = number_format($data / $divisor, $precision) . $shorthand;
            } else {
                $result = $data;
            }
        } else {
            $result = $data;
        }
        return $result;
    }

    protected static function checkArrayDataType(array $array)
    {
        foreach($array as $row){
            if($row != null){
                $arrayType = gettype($row);
                break;
            }
        }

        return $arrayType;
    }

    public static function box(){
        try {
            $view = 'layouts.dashboard.items.widgets.box.box';
            $items[] = json_decode(self::$labels);
            foreach ($items as $label) {
                $hclass = $label->HeaderClass != 'NULL' ? $label->HeaderClass : null;
                $bclass = $label->BodyClass != 'NULL' ? $label->BodyClass : null;
            }

            if (self::$sql == null || self::$sql == "" || self::$sql == " ") {
                $data = 'NULL';
            } else if (self::$sql != null || self::$sql != '' || self::$sql != ' ') {
                $data = self::multiData(self::$sql);
            } else {
                $data = 'No Data';
            }

            return view($view)
                ->with('id', self::$id)
                ->with('title', self::$title)
                ->with('icon', self::$iconClass)
                ->with('class', self::$class)
                ->with('hclass', $hclass)
                ->with('bclass', $bclass)
                ->with('description', self::$description);
        } catch (\Exception $e) {
            $data = 'PHP';
            $title = 'ERROR';
            $error = $e->getMessage();

            $view = 'errors.errorbox.error';
            return view($view)->with('data',$data)->with('title',$title)->with('error',$error);

        }
    }

    public static function callout(){
        try {
            $view = 'layouts.dashboard.items.widgets.callout.callout';

            if (self::$sql == null || self::$sql == "" || self::$sql == " ") {
                $data = 'NULL';
            } else if (self::$sql != null || self::$sql != '' || self::$sql != ' ') {
                $data = self::multiData(self::$sql);
            } else {
                $data = 'No Data';
            }

            return view($view)
                ->with('id', self::$id)
                ->with('title', self::$title)
                ->with('icon', self::$iconClass)
                ->with('class', self::$class)
                ->with('description', self::$description);
        } catch (\Exception $e) {
            $data = 'PHP';
            $title = 'ERROR';
            $error = $e->getMessage();

            $view = 'errors.errorbox.error';
            return view($view)->with('data',$data)->with('title',$title)->with('error',$error);

        }
    }

    public static function smallBox(){
        try {
            $view = 'layouts.dashboard.items.widgets.small-box.small-box';
            $items[] = json_decode(self::$labels);
            foreach ($items as $label) {
                $value = $label->Value != 'NULL' ? $label->Value : null;
                $bsymbol = $label->BeforeSymbol != 'NULL' ? $label->BeforeSymbol : null;
                $asymbol = $label->AfterSymbol != 'NULL' ? $label->AfterSymbol : null;
                $flabel = $label->FooterLabel != 'NULL' ? $label->FooterLabel : null;
                $ficon = $label->FooterIcon != 'NULL' ? $label->FooterIcon : null;
                $dtype = $label->DataType_number != 'NULL' ? $label->DataType_number : 'NULL';
                $dcolor = $label->DataColor != 'NULL' ? $label->DataColor : null;
            }

            if ($value != 'NULL' && $value != null && is_numeric($value)) {
                $data = self::dataType($dtype, $value);
            } else if (self::$sql != null && self::$sql != '' && self::$sql != ' ') {
                $data = self::dataType($dtype, self::singleData(self::$sql, self::$connection));
            } else {
                $data = 'No Data';
            }

            return view($view)
                ->with('id', self::$id)
                ->with('title', self::$title)
                ->with('icon', self::$iconClass)
                ->with('class', self::$class)
                ->with('bsymbol', $bsymbol)
                ->with('asymbol', $asymbol)
                ->with('flabel', $flabel)
                ->with('ficon', $ficon)
                ->with('data', $data)
                ->with('dcolor', $dcolor)
                ->with('url', self::$url);
        } catch (\Exception $e) {
            $data = 'PHP';
            $title = 'ERROR';
            $error = $e->getMessage();
            $view = 'errors.errorbox.error';
            return view($view)->with('data',$data)->with('title',$title)->with('error',$error);
        }
    }

    public static function smallBoxTwo(){
        try {
            $view = 'layouts.dashboard.items.widgets.small-box.small-box-two';

            $items[] = json_decode(self::$labels);
            foreach ($items as $label) {
                $value = $label->Value != 'NULL' ? $label->Value : null;
                $value1 = $label->Value1 != 'NULL' ? $label->Value1 : null;
                $value2 = $label->Value2 != 'NULL' ? $label->Value2 : null;
                $bsymbol = $label->BeforeSymbol != 'NULL' ? $label->BeforeSymbol : null;
                $bsymbol1 = $label->BeforeSymbol1 != 'NULL' ? $label->BeforeSymbol1 : null;
                $bsymbol2 = $label->BeforeSymbol2 != 'NULL' ? $label->BeforeSymbol2 : null;
                $asymbol = $label->AfterSymbol != 'NULL' ? $label->AfterSymbol : null;
                $asymbol1 = $label->AfterSymbol1 != 'NULL' ? $label->AfterSymbol1 : null;
                $asymbol2 = $label->AfterSymbol2 != 'NULL' ? $label->AfterSymbol2 : null;
                $flabel = $label->FirstLabel != 'NULL' ? $label->FirstLabel : null;
                $slabel = $label->SecondLabel != 'NULL' ? $label->SecondLabel : null;
                $ficon = $label->FooterIcon != 'NULL' ? $label->FooterIcon : null;
                $dtype = $label->DataType_number != 'NULL' ? $label->DataType_number : 'NULL';
                $dtype1 = $label->DataType1_number != 'NULL' ? $label->DataType1_number : 'NULL';
                $dtype2 = $label->DataType2_number != 'NULL' ? $label->DataType2_number : 'NULL';
                $dcolor = $label->DataColor != 'NULL' ? $label->DataColor : null;
                $dcolor1 = $label->DataColor1 != 'NULL' ? $label->DataColor1 : null;
                $dcolor2 = $label->DataColor2 != 'NULL' ? $label->DataColor2 : null;
            }

            if ($value != 'NULL' && $value != null && is_numeric($value)) {
                $data1 = self::dataType($dtype, $value);
                $data2 = self::dataType($dtype1, $value1);
                $data3 = self::dataType($dtype2, $value2);
            } else if (self::$sql != null && self::$sql != '' && self::$sql != ' ') {
                $data = self::multiData(self::$sql, self::$connection);
                $array_result = get_object_vars($data[0]);
                $array_result_object_name_keys = array_keys($array_result);
                $array_result_object_name_value = array_values($array_result);
                list($data_label, $data_label1, $data_label2) = $array_result_object_name_keys;
                list($value, $value1, $value2) = $array_result_object_name_value;
                $data1 = self::dataType($dtype, $value);
                $data2 = self::dataType($dtype1, $value1);
                $data3 = self::dataType($dtype2, $value2);
            } else {
                $data1 = 'No Data';
                $data2 = '';
                $data3 = '';
            }

            if ($flabel != 'NULL' && $flabel != null) {
                $flabel = $flabel;
            } else {
                $flabel = ucfirst(str_replace('_', ' ', $data_label1));
            }

            if ($slabel != 'NULL' && $slabel != null) {
                $slabel = $slabel;
            } else {
                $slabel = ucfirst(str_replace('_', ' ', $data_label2));
            }

            $data2 = $bsymbol1 . $data2 . $asymbol1;
            $data3 = $bsymbol2 . $data3 . $asymbol2;

            return view($view)
                ->with('id', self::$id)
                ->with('title', self::$title)
                ->with('icon', self::$iconClass)
                ->with('class', self::$class)
                ->with('bsymbol', $bsymbol)
                ->with('asymbol', $asymbol)
                ->with('flabel', $flabel)
                ->with('slabel', $slabel)
                ->with('ficon', $ficon)
                ->with('data1', $data1)
                ->with('data2', $data2)
                ->with('data3', $data3)
                ->with('dcolor', $dcolor)
                ->with('dcolor1', $dcolor1)
                ->with('dcolor2', $dcolor2)
                ->with('url', self::$url);

        } catch (\Exception $e) {
            $data = 'PHP';
            $title = 'ERROR';
            $error = $e->getMessage();
            $view = 'errors.errorbox.error';
            return view($view)->with('data',$data)->with('title',$title)->with('error',$error);
        }
    }

    public static function smallBoxDetail(){
        try {
            $view = 'layouts.dashboard.items.widgets.small-box.small-box-detail';
            $items[] = json_decode(self::$labels);

            foreach ($items as $label) {
                $value = $label->Value != 'NULL' ? $label->Value : null;
                $value1 = $label->Value1 != 'NULL' ? $label->Value1 : null;
                $value2 = $label->Value2 != 'NULL' ? $label->Value2 : null;
                $tsize = $label->TargetSize != 'NULL' ? $label->TargetSize : null;
                $tname = $label->TargetName != 'NULL' ? $label->TargetName : null;
                $tcolor = $label->TargetColor != 'NULL' ? $label->TargetColor : null;
                $icon1 = $label->Icon1 != 'NULL' ? $label->Icon1 : null;
                $icon2 = $label->Icon2 != 'NULL' ? $label->Icon2 : null;
                $icon3 = $label->Icon2 != 'NULL' ? $label->Icon3 : null;
                $bsymbol = $label->BeforeSymbol != 'NULL' ? $label->BeforeSymbol : null;
                $bsymbol1 = $label->BeforeSymbol1 != 'NULL' ? $label->BeforeSymbol1 : null;
                $bsymbol2 = $label->BeforeSymbol2 != 'NULL' ? $label->BeforeSymbol2 : null;
                $asymbol = $label->AfterSymbol != 'NULL' ? $label->AfterSymbol : null;
                $ficon = $label->FooterIcon != 'NULL' ? $label->FooterIcon : null;
                $dtype = $label->DataType_number != 'NULL' ? $label->DataType_number : 'NULL';
                $dtype1 = $label->DataType1_number != 'NULL' ? $label->DataType1_number : 'NULL';
                $dtype2 = $label->DataType2_number != 'NULL' ? $label->DataType2_number : 'NULL';
                $dcolor = $label->DataColor != 'NULL' ? $label->DataColor : null;
                $dcolor1 = $label->DataColor1 != 'NULL' ? $label->DataColor1 : null;
                $dcolor2 = $label->DataColor2 != 'NULL' ? $label->DataColor2 : null;
                $dcolor3 = $label->DataColor2 != 'NULL' ? $label->DataColor2 : null;
                $label2 = $label->Label2 != 'NULL' ? $label->Label2 : null;
                $label1 = $label->Label1 != 'NULL' ? $label->Label1 : null;
                $label = $label->Label != 'NULL' ? $label->Label : null;
            }

            if ($value != 'NULL' && $value != null && is_numeric($value)) {
                $data1 = $bsymbol . self::dataType($dtype, $value) . $asymbol;
                $data2 = $label1 . ' (' . $bsymbol1 . self::dataType($dtype1, $value1) . ')';
                $data3 = $label2 . ' (' . $bsymbol2 . self::dataType($dtype2, $value2) . ')';
                if ($tsize != 'NULL' && $tsize != null) {
                    $targetLabel = '/(' . $tsize . ' ' . $tname . ')';
                    $targetPer = number_format((($value / $tsize) * 100), 2). '%';
                    $value1Per = number_format((($value1 / $tsize) * 100),2) . '%';
                    $value2Per = number_format((($value2 / $tsize) * 100),2) . '%';
                } else {
                    $targetLabel = null;
                    $targetPer = null;
                    $value1Per = number_format((($value1 / $value) * 100),2) . '%';
                    $value2Per = number_format((($value2 / $value) * 100),2) . '%';
                }
            } else if (self::$sql != null && self::$sql != '' && self::$sql != ' ') {

                $data = self::multiData(self::$sql, self::$connection);
                $array_result = get_object_vars($data[0]);
                $array_result_object_name_keys = array_keys($array_result);
                $array_result_object_name_value = array_values($array_result);

                $combine = array();
                foreach ($data as $row) {
                    for ($i = 0; $i < count($array_result_object_name_keys); $i++) {
                        $combine[] = ucfirst($array_result_object_name_keys[$i]);
                        $values[] = $row->{$array_result_object_name_keys[$i]};
                    }
                }

                list($data_label, $data_label1, $data_label2) = $combine ?: null;
                list($data_value, $data_value1, $data_value2) = $values ?: null;

                $data1 = $bsymbol . self::dataType($dtype, $data_value) . $asymbol;
                $data2 = $data_label1 . ' (' . $bsymbol1 . self::dataType($dtype1, $data_value1) . ')';
                $data3 = $data_label2 . ' (' . $bsymbol2 . self::dataType($dtype2, $data_value2) . ')';

                if ($tsize != 'NULL' && $tsize != null) {
                    $targetLabel = '/(' . $tsize . ' ' . $tname . ')';
                    $targetPer = number_format((($data_value / $tsize) * 100),2) . '%';
                    $value1Per = number_format((($data_value1 / $tsize) * 100),2) . '%';
                    $value2Per = number_format((($data_value2 / $tsize) * 100),2) . '%';
                } else {
                    $targetLabel = null;
                    $targetPer = null;
                    $value1Per = number_format((($data_value1 / $data_value) * 100),2) . '%';
                    $value2Per = number_format((($data_value2 / $data_value) * 100),2) . '%';
                }

            } else {
                $data1 = 'No Data';
                $data2 = '';
                $data3 = '';
                $targetLabel = null;
                $targetPer = null;
                $value1Per = null;
                $value2Per = null;

            }


            return view($view)
                ->with('id', self::$id)
                ->with('class', self::$class)
                ->with('data1', $data1)
                ->with('data2', $data2)
                ->with('data3', $data3)
                ->with('dcolor', $dcolor)
                ->with('dcolor1', $dcolor1)
                ->with('dcolor2', $dcolor2)
                ->with('dcolor3', $dcolor3)
                ->with('targetLabel', $targetLabel)
                ->with('tcolor', $tcolor)
                ->with('icon1', $icon1)
                ->with('icon2', $icon2)
                ->with('icon3', $icon3)
                ->with('label', $label)
                ->with('per1', $targetPer)
                ->with('per2', $value1Per)
                ->with('per3', $value2Per)
                ->with('titleIcon', self::$iconClass)
                ->with('title', self::$title)
                ->with('url', self::$url)
                ->with('ficon', $ficon);
        } catch (\Exception $e) {
            $data = 'PHP';
            $title = 'ERROR';
            $error = $e->getMessage();

            $view = 'errors.errorbox.error';
            return view($view)->with('data',$data)->with('title',$title)->with('error',$error);

        }
    }

    public static function infoBox(){
        try {
            $view = 'layouts.dashboard.items.widgets.info-box.info-box';
            $items[] = json_decode(self::$labels);
            foreach ($items as $label) {
                $value = $label->Value != 'NULL' ? $label->Value : null;
                $bsymbol = $label->BeforeSymbol != 'NULL' ? $label->BeforeSymbol : null;
                $asymbol = $label->AfterSymbol != 'NULL' ? $label->AfterSymbol : null;
                $dtype = $label->DataType_number != 'NULL' ? $label->DataType_number : 'NULL';
                $dcolor = $label->DataColor != 'NULL' ? $label->DataColor : null;
                $dcolor1 = $label->DataColor1 != 'NULL' ? $label->DataColor1 : null;
            }

            if ($value != 'NULL' && $value != null && is_numeric($value)) {
                $data = self::dataType($dtype, $value);
            } else if (self::$sql != null && self::$sql != '' && self::$sql != ' ') {
                $data = self::dataType($dtype, self::singleData(self::$sql, self::$connection));
            } else {
                $data = 'No Data';
            }

            return view($view)
                ->with('id', self::$id)
                ->with('title', self::$title)
                ->with('icon', self::$iconClass)
                ->with('class', self::$class)
                ->with('color', self::$color)
                ->with('bsymbol', $bsymbol)
                ->with('asymbol', $asymbol)
                ->with('data', $data)
                ->with('dcolor', $dcolor)
                ->with('dcolor1', $dcolor1);
        } catch (\Exception $e) {
            $data = 'PHP';
            $title = 'ERROR';
            $error = $e->getMessage();
            $view = 'errors.errorbox.error';
            return view($view)->with('data',$data)->with('title',$title)->with('error',$error);
        }
    }

    public static function infoBoxTwo(){
        try {
            $view = 'layouts.dashboard.items.widgets.info-box.info-box-two';
            $items[] = json_decode(self::$labels);
            foreach ($items as $label) {
                $value = $label->Value != 'NULL' ? $label->Value : null;
                $value1 = $label->Value1 != 'NULL' ? $label->Value1 : null;
                $percentage = $label->Per != 'NULL' ? $label->Per : null;
                $bsymbol = $label->BeforeSymbol != 'NULL' ? $label->BeforeSymbol : null;
                $asymbol = $label->AfterSymbol != 'NULL' ? $label->AfterSymbol : null;
                $dtype = $label->DataType_number != 'NULL' ? $label->DataType_number : 'NULL';
                $dtype1 = $label->DataType1_number != 'NULL' ? $label->DataType1_number : 'NULL';
                $dcolor = $label->DataColor != 'NULL' ? $label->DataColor : null;
                $dcolor1 = $label->DataColor1 != 'NULL' ? $label->DataColor1 : null;
            }

            if ($value != 'NULL' && $value != null && is_numeric($value)) {
                $data1 = self::dataType($dtype, $value);
                $data2 = self::dataType($dtype, $value1);
                $per = $percentage;
            } else if (self::$sql != null && self::$sql != '' && self::$sql != ' ') {
                $data = self::dataType($dtype, self::multiData(self::$sql, self::$connection));
                $array_result = get_object_vars($data[0]);
                $array_result_object_name_keys = array_keys($array_result);
                $array_result_object_name_value = array_values($array_result);

                $values = array();
                foreach ($data as $row) {
                    for ($i = 0; $i < count($array_result_object_name_keys); $i++) {
                        $values[] = $row->{$array_result_object_name_keys[$i]};
                    }
                }


                list($data_value, $data_value1, $data_value2) = $values ?: null;

                $data1 = self::dataType($dtype, $data_value);
                $data2 = self::dataType($dtype1, $data_value1);

                if($percentage != 'NULL' && $percentage != null) {
                    $per = $percentage;
                } else {
                    $per = $data_value2;
                }
            } else {
                $data1 = 'No Data';
                $data2 = '';
                $per = 0;
            }

            return view($view)
                ->with('id', self::$id)
                ->with('title', self::$title)
                ->with('icon', self::$iconClass)
                ->with('class', self::$class)
                ->with('color', self::$color)
                ->with('bsymbol', $bsymbol)
                ->with('asymbol', $asymbol)
                ->with('data', $data1)
                ->with('labels', $data2)
                ->with('per', $per)
                ->with('dcolor', $dcolor)
                ->with('dcolor1', $dcolor1);
        } catch (\Exception $e) {
            $data = 'PHP';
            $title = 'ERROR';
            $error = $e->getMessage();
            $view = 'errors.errorbox.error';
            return view($view)->with('data',$data)->with('title',$title)->with('error',$error);
        }
    }

    public static function infoBoxDetail(){
        try {
            $view = 'layouts.dashboard.items.widgets.info-box.info-box-detail';
            $items[] = json_decode(self::$labels);
            foreach ($items as $label) {
                $value = $label->Value != 'NULL' ? $label->Value : null;
                $value1 = $label->Value1 != 'NULL' ? $label->Value1 : null;
                $value2 = $label->Value2 != 'NULL' ? $label->Value2 : null;
                $bsymbol = $label->BeforeSymbol != 'NULL' ? $label->BeforeSymbol : null;
                $bsymbol1 = $label->BeforeSymbol1 != 'NULL' ? $label->BeforeSymbol1 : null;
                $bsymbol2 = $label->BeforeSymbol2 != 'NULL' ? $label->BeforeSymbol2 : null;
                $asymbol = $label->AfterSymbol != 'NULL' ? $label->AfterSymbol : null;
                $asymbol1 = $label->AfterSymbol1 != 'NULL' ? $label->AfterSymbol1 : null;
                $asymbol2 = $label->AfterSymbol != 'NULL' ? $label->AfterSymbol2 : null;
                $label1 = $label->Label1 != 'NULL' ? $label->Label1 : null;
                $label2 = $label->Label2 != 'NULL' ? $label->Label2 : null;
                $dtype = $label->DataType_number != 'NULL' ? $label->DataType_number : 'NULL';
                $dtype1 = $label->DataType1_number != 'NULL' ? $label->DataType1_number : 'NULL';
                $dtype2 = $label->DataType2_number != 'NULL' ? $label->DataType2_number : 'NULL';
                $dcolor = $label->DataColor != 'NULL' ? $label->DataColor : null;
                $dcolor1 = $label->DataColor1 != 'NULL' ? $label->DataColor1 : null;
            }

            if(self::$color == 'bg-aqua'){
                $dotcolor = 'text-aque';
            } else if (self::$color == 'bg-green'){
                $dotcolor = 'text-green';
            } else if (self::$color == 'bg-yellow'){
                $dotcolor = 'text-yellow';
            } else if (self::$color == 'bg-red'){
                $dotcolor = 'text-red';
            }

            if ($value != 'NULL' && $value != null && is_numeric($value)) {
                $data1 = $bsymbol . self::dataType($dtype, $value);
                $data2 = $bsymbol1 . self::dataType($dtype1, $value1);
                $data3 = $bsymbol2 . self::dataType($dtype2, $value2);
            } else if (self::$sql != null && self::$sql != '' && self::$sql != ' ') {
                $data = self::dataType($dtype, self::multiData(self::$sql, self::$connection));
                $array_result = get_object_vars($data[0]);
                $array_result_object_name_keys = array_keys($array_result);
                $array_result_object_name_value = array_values($array_result);

                $combine = array();
                foreach ($data as $row) {
                    for ($i = 0; $i < count($array_result_object_name_keys); $i++) {
                        $combine[] = ucfirst($array_result_object_name_keys[$i]);
                        $values[] = $row->{$array_result_object_name_keys[$i]};
                    }
                }

                list($data_label, $data_label1, $data_label2) = $combine ?: null;
                list($data_value, $data_value1, $data_value2) = $values ?: null;

                if($label1 != 'NULL' && $label1 != null){
                    $label1 = $label1;
                } else {
                    $label1 = $data_label1;
                }

                if($label2 != 'NULL' && $label2 != null){
                    $label2 = $label2;
                } else {
                    $label2 = $data_label2;
                }

                $data1 = $bsymbol . self::dataType($dtype, $data_value);
                $data2 = $bsymbol1 . self::dataType($dtype1, $data_value1);
                $data3 = $bsymbol2 . self::dataType($dtype2, $data_value2);
            } else {
                $data1 = 'No Data';
                $data2 = '';
                $data3 = '';
            }

            return view($view)
                ->with('id', self::$id)
                ->with('title', self::$title)
                ->with('icon', self::$iconClass)
                ->with('class', self::$class)
                ->with('color', self::$color)
                ->with('asymbol', $asymbol)
                ->with('asymbol1', $asymbol1)
                ->with('asymbol2', $asymbol2)
                ->with('label1', $label1)
                ->with('label2', $label2)
                ->with('data1', $data1)
                ->with('data2', $data2)
                ->with('data3', $data3)
                ->with('dotcolor', $dotcolor)
                ->with('dcolor', $dcolor)
                ->with('dcolor1', $dcolor1);
        } catch (\Exception $e) {
            $data = 'PHP';
            $title = 'ERROR';
            $error = $e->getMessage();
            $view = 'errors.errorbox.error';
            return view($view)->with('data',$data)->with('title',$title)->with('error',$error);
        }
    }

    public static function widgetUser(){
        try {
            $view = 'layouts.dashboard.items.widgets.widget-user.widget-user';
            $items[] = json_decode(self::$labels);
            $valueColor = array();
            foreach ($items as $label) {
                $value = $label->Value != 'NULL' ? $label->Value : null;
                $value1 = $label->Value1 != 'NULL' ? $label->Value1 : null;
                $value2 = $label->Value2 != 'NULL' ? $label->Value2 : null;
                $valueColor = $label->ValueColor != 'NULL' ? $label->ValueColor : null;
                $label1 = $label->Label1 != 'NULL' ? $label->Label1 : null;
                $label2 = $label->Label2 != 'NULL' ? $label->Label2 : null;
                //$label3 = $label->Label3 != 'NULL' ? $label->Label3 : null;
                $dtype = $label->DataType_number != 'NULL' ? $label->DataType_number : 'NULL';
                $dtype1 = $label->DataType1_number != 'NULL' ? $label->DataType1_number : 'NULL';
                $dtype2 = $label->DataType2_number != 'NULL' ? $label->DataType2_number : 'NULL';
            }

            $bdrColor = str_replace('bg', 'bdr', self::$color);

            if ($value != 'NULL' && $value != null) {
                $data1 = self::dataType($dtype, $value);
                $data2 = self::dataType($dtype, $value1);
                $data3 = self::dataType($dtype, $value2);
                $values = array();
                $values = $value2;
                if(empty($values) || $values == null){
                    $values = ['NULL'];
                } else {
                    $values = $values;
                }
                $description = $data1.' '.$label1.' '.$data2;
                $valuesLabel = $label2;
                for ($i = 0; $i < count($valueColor); $i++) {
                    if (count($valueColor) >= 1) {
                        $valuesLabelColor[] = $valueColor[$i];
                    } else {
                        $valuesLabelColor[] = 'bg-default';
                    }
                }
            } else if (self::$sql != null && self::$sql != '' && self::$sql != ' ') {
                $data = self::dataType($dtype, self::multiData(self::$sql, self::$connection));
                $array_result = get_object_vars($data[0]);
                $array_result_object_name_keys = array_keys($array_result);
                $array_result_object_name_value = array_values($array_result);

                $values = array();
                foreach ($data as $row) {
                    for ($i = 0; $i < count($array_result_object_name_keys); $i++) {
                        if($i == 0){
                            $data1 = self::dataType($dtype, $row->{$array_result_object_name_keys[$i]});
                        } else if($i == 1) {
                            $data2 = self::dataType($dtype, $row->{$array_result_object_name_keys[$i]});
                            $data_label2 = $array_result_object_name_keys[$i];
                        } else {
                            $values[] = $row->{$array_result_object_name_keys[$i]};
                            $valuesLabel[] = $array_result_object_name_keys[$i];
                            if(count($valueColor) >= $i) {
                                $valuesLabelColor[] = $valueColor[$i];
                            } else {
                                $valuesLabelColor[] = 'bg-default';
                            }
                        }
                    }
                }

                if($label1 != 'NULL' && $label1 != null) {
                    $description = $data1 . ' ' . $label2 . ' ' . $data2;
                } else {
                    $description = $data1 . ' ' . $data_label2 . ' ' . $data2;
                }

            } else {
                $description = 'No Data';
                $data2 = '';
                $values = array('NULL');
                $valuesLabel = array('NULL');
                $valuesLabelColor = array('NULL');
            }

            return view($view)
                ->with('id', self::$id)
                ->with('title', self::$title)
                ->with('icon', self::$iconClass)
                ->with('class', self::$class)
                ->with('color', self::$color)
                ->with('bdrColor', $bdrColor)
                ->with('description', $description)
                ->with('values', $values)
                ->with('valuesLabel', $valuesLabel)
                ->with('valueLabelColor', $valuesLabelColor);

        } catch (\Exception $e) {
            $data = 'PHP';
            $title = 'ERROR';
            $error = $e->getMessage();
            $view = 'errors.errorbox.error';
            return view($view)->with('data',$data)->with('title',$title)->with('error',$error);
        }
    }

    public static function chart(){
        try {
            $view = 'layouts.dashboard.items.charts.chart';
            $items[] = json_decode(self::$labels);
            foreach ($items as $label) {
                $value = $label->Value != 'NULL' ? $label->Value : null;
                $valueLabels = $label->ValueLabels != 'NULL' ? $label->ValueLabels : null;
                $chartWidth = $label->ChartWidth != 'NULL' ? $label->ChartWidth : null;
                $chartHeight = $label->ChartHeight != 'NULL' ? $label->ChartHeight : null;
            }

            $titlechart = str_replace(' ', '_', self::$title);
            if ($value != 'NULL' && $value != null && $value == 'manual') {

                $columnLabels = $valueLabels;
                $datasetEncode = json_decode(self::$dataset);

            } else if(self::$sql != null && self::$sql != '' && self::$sql != ' ') {

                $data = self::multiData(self::$sql,self::$connection);

                // Prepare Chart Data
                $object_values = get_object_vars($data[0]);
                $columnName = array_keys($object_values);
                $countColumn = count($object_values);
                foreach ($data as $key => $row) {
                    $array_result[] = get_object_vars($data[$key]);
                    $array_name = get_object_vars($data[$key]);
                    $array_result_object_name[] = array_keys($array_name);
                    $array_result_object_name[] = array_shift($array_result_object_name);
                    $array_result_object_name_keys[] = array_keys($array_name);
                }
                $columnData1 = array_map('ucfirst',array_column($array_result, $columnName[0]));

                // Check if first column have a string
                $arrayType = self::checkArrayDataType($columnData1);
                $i = 0;
                $columnData = array();

                if($valueLabels != 'NULL' && $valueLabels != null){
                    $columnLabels = explode(",",$valueLabels);
                } else if($arrayType == 'string'){
                    $columnLabels = str_replace('_', ' ', $columnData1);
                    $i = 1;
                }

                for ($x = $i; $x < $countColumn; $x++) {
                    $columnData[] = array_map('ucfirst',array_column($array_result, $columnName[$x]));
                }
                if (strpos(self::$dataset, '"$sets"') !== false) {
                    $dataset = self::$dataset;
                }else if(strpos(self::$dataset, '$sets') !== false){
                    $dataset = str_replace('$sets', '"$sets"', self::$dataset);
                } else {
                    $pattern = '/\"$\S+/';
                    if(preg_match('/\"\$\S+\"/', self::$dataset, $matches) == 1){
                        $vartext = str_replace('"','',$matches[0]);
                        $dataset = self::$dataset;
                    } else {
                        preg_match('/\$\S+/', self::$dataset, $matches);
                        $vartext = $matches[0];
                        $dataset = str_replace($vartext, '"'.$vartext.'"', self::$dataset);
                    }

                    $var = str_replace('$', '', $vartext);
                    $varname = $vartext;
                }

                $datasetCount = count(json_decode($dataset));
                $datasetDecode = json_decode($dataset);
                $datasetEncode = array();

                for ($y = 0; $y < $datasetCount; $y++) {
                    $dataText = json_encode($datasetDecode[$y]);
                    if(isset($sets)) {
                        $sets = json_encode((object) $columnData[$y],JSON_NUMERIC_CHECK);
                        $dataText = str_replace('"$sets"', '$sets', $dataText);
                        $datasetEncode[] = json_decode(eval('return "' . addslashes($dataText) . '";'),true);
                    } else{
                        ${$var} = json_encode((object) $columnData[$y],JSON_NUMERIC_CHECK);
                        $dataText = str_replace('"'.$varname.'"', $vartext, $dataText);
                        $datasetEncode[] = json_decode(eval('return "' . addslashes($dataText) . '";'),true);
                    }

                }

            } else {
                $columnLabels = array('No Data');
                $datasetEncode = array('0');
            }

            $chart_labels = $columnLabels;
            $datasets = $datasetEncode;
            if($chartWidth != "NULL" && $chartWidth != null){
                $chartWidth = $chartWidth;
            } else {
                $chartWidth = 696;
            }

            if($chartHeight != "NULL" && $chartHeight != null){
                $chartHeight = $chartHeight;
            } else {
                $chartHeight = 230;
            }

            $chartjs = app()->chartjs
                ->name($titlechart)
                ->type(self::$sub_type)
                ->size(['width' => $chartWidth, 'height' => $chartHeight])
                ->labels($chart_labels)
                ->datasets($datasets)
                ->optionsRaw(self::$chart_options);

            return view($view)
                ->with('id',self::$id)
                ->with('title',ucfirst(self::$title))
                ->with('class',self::$class)
                ->with('icon',self::$iconClass)
                ->with('chartjs',$chartjs);

        } catch (\Exception $e) {
            $data = 'PHP';
            $title = 'ERROR';
            $error = $e->getMessage();
            $view = 'errors.errorbox.error';
            return view($view)->with('data',$data)->with('title',$title)->with('error',$error);

        }
    }

    public static function chartStatistics(){
        try {
            $view = 'layouts.dashboard.items.charts.chart-statistics';
            $items[] = json_decode(self::$labels);
            foreach ($items as $label) {
                $value = $label->Value != 'NULL' ? $label->Value : null;
                $valueColor = $label->ValueColor != 'NULL' ? $label->ValueColor : null;
                $valueLabels = $label->ValueLabels != 'NULL' ? $label->ValueLabels : null;
                $chartWidth = $label->ChartWidth != 'NULL' ? $label->ChartWidth : null;
                $chartHeight = $label->ChartHeight != 'NULL' ? $label->ChartHeight : null;
                $statisticsPosition = $label->StatisticsPosition != 'NULL' ? $label->StatisticsPosition : null;
                $dtype = $label->DataType_number != 'NULL' ? $label->DataType_number : 'NULL';
            }

            $titlechart = str_replace(' ', '_', self::$title);
            if ($value != 'NULL' && $value != null && $value == 'manual') {

                $columnLabels = $valueLabels;
                $datasetEncode = self::$dataset;

            } else if (self::$sql != null && self::$sql != '' && self::$sql != ' ') {
                $chartStatistics[] = explode(";", self::$sql);
                $statisticsCount = count($chartStatistics[0]);
                if ($statisticsCount >= 2) {
                    $sql1 = $chartStatistics[0][0];
                    $data = self::multiData($sql1, self::$connection);

                    // Prepare Chart Data
                    $object_values = get_object_vars($data[0]);
                    $columnName = array_keys($object_values);
                    $countColumn = count($object_values);
                    foreach ($data as $key => $row) {
                        $array_result[] = get_object_vars($data[$key]);
                        $array_name = get_object_vars($data[$key]);
                        $array_result_object_name[] = array_keys($array_name);
                        $array_result_object_name[] = array_shift($array_result_object_name);
                        $array_result_object_name_keys[] = array_keys($array_name);
                    }
                    $columnData1 = array_map('ucfirst', array_column($array_result, $columnName[0]));

                    // Check if first column have a string
                    $arrayType = self::checkArrayDataType($columnData1);
                    $i = 0;
                    $columnData = array();

                    if ($valueLabels != 'NULL' && $valueLabels != null) {
                        $columnLabels = explode(",", $valueLabels);
                    } else if ($arrayType == 'string') {
                        $columnLabels = str_replace('_', ' ', $columnData1);
                        $i = 1;
                    }

                    for ($x = $i; $x < $countColumn; $x++) {
                        $columnData[] = array_map('ucfirst', array_column($array_result, $columnName[$x]));
                    }
                    if (strpos(self::$dataset, '"$sets"') !== false) {
                        $dataset = self::$dataset;
                    } else if (strpos(self::$dataset, '$sets') !== false) {
                        $dataset = str_replace('$sets', '"$sets"', self::$dataset);
                    } else {
                        $pattern = '/\"$\S+\"/';
                        if (preg_match('/\"\$\S+\"/', self::$dataset, $matches) == 1) {
                            $vartext = str_replace('"','',$matches[0]);
                            $dataset = self::$dataset;
                        } else {
                            preg_match('/\$\S+/', self::$dataset, $matches);
                            $vartext = $matches[0];
                            $dataset = str_replace($vartext, '"' . $vartext . '"', self::$dataset);
                        }
                        $var = str_replace('$', '', $vartext);
                        $varname = $vartext;
                    }

                    $datasetCount = count(json_decode($dataset));
                    $datasetDecode = json_decode($dataset);
                    $datasetEncode = array();

                    for ($y = 0; $y < $datasetCount; $y++) {
                        $dataText = json_encode($datasetDecode[$y]);
                        if (isset($sets)) {
                            $sets = json_encode((object)$columnData[$y], JSON_NUMERIC_CHECK);
                            $dataText = str_replace('"$sets"', '$sets', $dataText);
                            $datasetEncode[] = json_decode(eval('return "' . addslashes($dataText) . '";'), true);
                        } else {

                            ${$var} = json_encode((object)$columnData[$y], JSON_NUMERIC_CHECK);
                            $dataText = str_replace('"' . $varname . '"', $vartext, stripslashes($dataText));
                            $datasetEncode[] = json_decode(eval('return "' . addslashes($dataText) . '";'), true);
                        }

                    }

                    //End of Preparing Chart

                    //Preparing Statistics
                    $sql2 = $chartStatistics[0][1];
                    $dataStatistics = self::dataType($dtype, self::multiData($sql2, self::$connection));

                    $array_result = get_object_vars($dataStatistics[0]);
                    $array_result_object_name_keys = array_keys($array_result);
                    $array_result_object_name_value = array_values($array_result);

                    $values = array();
                    foreach ($dataStatistics as $row) {
                        for ($i = 0; $i < count($array_result_object_name_keys); $i++) {
                            $values[] = $row->{$array_result_object_name_keys[$i]};
                            $valuesLabel[] = $array_result_object_name_keys[$i];
                            if (count($valueColor) > 0 && $valueColor != ["NULL"]) {
                                $valuesLabelColor[] = $valueColor[$i];
                            } else {
                                $valuesLabelColor[] = 'bg-default';
                            }
                        }
                    }

                } else if ($statisticsCount <= 1) {

                    $values = [];
                    $valuesLabel = [];
                    $valuesLabelColor = [];
                    $data = self::multiData(self::$sql, self::$connection);
                    // Prepare Chart Data
                    $object_values = get_object_vars($data[0]);
                    $columnName = array_keys($object_values);
                    $countColumn = count($object_values);
                    foreach ($data as $key => $row) {
                        $array_result[] = get_object_vars($data[$key]);
                        $array_name = get_object_vars($data[$key]);
                        $array_result_object_name[] = array_keys($array_name);
                        $array_result_object_name[] = array_shift($array_result_object_name);
                        $array_result_object_name_keys[] = array_keys($array_name);
                    }
                    $columnData1 = array_map('ucfirst', array_column($array_result, $columnName[0]));

                    // Check if first column have a string
                    $arrayType = self::checkArrayDataType($columnData1);
                    $i = 0;
                    $columnData = array();

                    if ($valueLabels != 'NULL' && $valueLabels != null) {
                        $columnLabels = explode(",", $valueLabels);
                    } else if ($arrayType == 'string') {
                        $columnLabels = str_replace('_', ' ', $columnData1);
                        $i = 1;
                    }

                    for ($x = $i; $x < $countColumn; $x++) {
                        $columnData[] = array_map('ucfirst', array_column($array_result, $columnName[$x]));
                    }
                    if (strpos(self::$dataset, '"$sets"') !== false) {
                        $dataset = self::$dataset;
                    } else if (strpos(self::$dataset, '$sets') !== false) {
                        $dataset = str_replace('$sets', '"$sets"', self::$dataset);
                    } else {
                        $pattern = '/\"$\S+/';
                        if (preg_match('/\"\$\S+\"/', self::$dataset, $matches) == 1) {
                            $vartext = str_replace('"','',$matches[0]);
                            $dataset = self::$dataset;
                        } else {
                            preg_match('/\$\S+/', self::$dataset, $matches);
                            $vartext = $matches[0];
                            $dataset = str_replace($vartext, '"' . $vartext . '"', self::$dataset);
                        }

                        $var = str_replace('$', '', $vartext);
                        $varname = $vartext;
                    }

                    $datasetCount = count(json_decode($dataset));
                    $datasetDecode = json_decode($dataset);
                    $datasetEncode = array();

                    for ($y = 0; $y < $datasetCount; $y++) {
                        $dataText = json_encode($datasetDecode[$y]);
                        if (isset($sets)) {
                            $sets = json_encode((object)$columnData[$y], JSON_NUMERIC_CHECK);
                            $dataText = str_replace('"$sets"', '$sets', $dataText);
                            $datasetEncode[] = json_decode(eval('return "' . addslashes($dataText) . '";'), true);
                        } else {
                            ${$var} = json_encode((object)$columnData[$y], JSON_NUMERIC_CHECK);
                            $dataText = str_replace('"' . $varname . '"', $vartext, $dataText);
                            $datasetEncode[] = json_decode(eval('return "' . addslashes($dataText) . '";'), true);
                        }

                    }
                }

            } else {
                $values = [];
                $valuesLabel = null;
                $valuesLabelColor = null;
                $columnLabels = array('No Data');
                $datasetEncode = array('0');
            }

            $chart_labels = $columnLabels;
            $datasets = $datasetEncode;
            if ($chartWidth != "NULL" && $chartWidth != null) {
                $chartWidth = $chartWidth;
            } else {
                $chartWidth = 353;
            }

            if ($chartHeight != "NULL" && $chartHeight != null) {
                $chartHeight = $chartHeight;
            } else {
                $chartHeight = 230;
            }

            $chartjs = app()->chartjs
                ->name($titlechart)
                ->type(self::$sub_type)
                ->size(['width' => $chartWidth, 'height' => $chartHeight])
                ->labels($chart_labels)
                ->datasets($datasets)
                ->optionsRaw(self::$chart_options);

            return view($view)
                ->with('id', self::$id)
                ->with('title', ucfirst(self::$title))
                ->with('class', self::$class)
                ->with('icon', self::$iconClass)
                ->with('chartjs', $chartjs)
                ->with('values', $values)
                ->with('valuesLabel', $valuesLabel)
                ->with('valueLabelColor', $valuesLabelColor)
                ->with('statisticsPosition', $statisticsPosition);
        } catch (\Exception $e) {
            $data = 'PHP';
            $title = 'ERROR';
            $error = $e->getMessage();
            $view = 'errors.errorbox.error';
            return view($view)->with('data',$data)->with('title',$title)->with('error',$error);

        }
    }

    public static function chartInBox(){
        try {
            $view = 'layouts.dashboard.items.charts.chart-in-box';
            $items[] = json_decode(self::$labels);
            foreach ($items as $label) {
                $value = $label->Value != 'NULL' ? $label->Value : null;
                $valueColor = $label->ValueColor != 'NULL' ? $label->ValueColor : null;
                $valueLabels = $label->ValueLabels != 'NULL' ? $label->ValueLabels : null;
                $label1 = $label->Label1 != 'NULL' ? $label->Label1 : null;
                $label2 = $label->Label2 != 'NULL' ? $label->Label2 : null;
                $chartWidth = $label->ChartWidth != 'NULL' ? $label->ChartWidth : null;
                $chartHeight = $label->ChartHeight != 'NULL' ? $label->ChartHeight : null;
                $statisticsPosition = $label->StatisticsPosition != 'NULL' ? $label->StatisticsPosition : null;
                $dtype = $label->DataType_number != 'NULL' ? $label->DataType_number : 'NULL';
            }

            $bdrColor = str_replace('bg', 'bdr', self::$color);

            $titlechart = str_replace(' ', '_', self::$title);
            if ($value != 'NULL' && $value != null && $value == 'manual') {

                $columnLabels = $valueLabels;
                $datasetEncode = self::$dataset;

            } else if (self::$sql != null && self::$sql != '' && self::$sql != ' ') {
                $chartStatistics[] = explode(";", self::$sql);
                $statisticsCount = count($chartStatistics[0]);
                if ($statisticsCount >= 2) {
                    $sql1 = $chartStatistics[0][0];
                    $data = self::multiData($sql1, self::$connection);

                    // Prepare Chart Data
                    $object_values = get_object_vars($data[0]);
                    $columnName = array_keys($object_values);
                    $countColumn = count($object_values);

                    foreach ($data as $key => $row) {
                        $array_result[] = get_object_vars($data[$key]);
                        $array_name = get_object_vars($data[$key]);
                        $array_result_object_name[] = array_keys($array_name);
                        $array_result_object_name[] = array_shift($array_result_object_name);
                        $array_result_object_name_keys[] = array_keys($array_name);
                    }
                    $columnData1 = array_map('ucfirst', array_column($array_result, $columnName[0]));

                    // Check if first column have a string
                    $arrayType = self::checkArrayDataType($columnData1);
                    $i = 0;
                    $columnData = array();

                    if ($valueLabels != 'NULL' && $valueLabels != null) {
                        $columnLabels = explode(",", $valueLabels);
                    } else if ($arrayType == 'string') {
                        $columnLabels = str_replace('_', ' ', $columnData1);
                        $i = 1;
                    }

                    for($x = $i; $x < $countColumn; $x++) {
                        $columnData[] = array_map('ucfirst', array_column($array_result, $columnName[$x]));
                    }
                    if(strpos(self::$dataset, '"$sets"') !== false) {
                        $dataset = self::$dataset;
                    } else if(strpos(self::$dataset, '$sets') !== false) {
                        $dataset = str_replace('$sets', '"$sets"', self::$dataset);
                    } else {
                        $pattern = '/\"$\S+/';
                        if(preg_match('/\"\$\S+\"/', self::$dataset, $matches) == 1) {
                            $vartext = str_replace('"','',$matches[0]);
                            $dataset = self::$dataset;
                        } else {
                            preg_match('/\$\S+/', self::$dataset, $matches);
                            $vartext = $matches[0];
                            $dataset = str_replace($vartext, '"' . $vartext . '"', self::$dataset);
                        }
                        $var = str_replace('$', '', $vartext);
                        $varname = $vartext;
                    }

                    $datasetCount = count(json_decode($dataset));
                    $datasetDecode = json_decode($dataset);
                    $datasetEncode = array();

                    for ($y = 0; $y < $datasetCount; $y++) {
                        $dataText = json_encode($datasetDecode[$y]);
                        if (isset($sets)) {
                            $sets = json_encode((object)$columnData[$y], JSON_NUMERIC_CHECK);
                            $dataText = str_replace('"$sets"', '$sets', $dataText);
                            $datasetEncode[] = json_decode(eval('return "' . addslashes($dataText) . '";'), true);
                        } else {

                            ${$var} = json_encode((object)$columnData[$y], JSON_NUMERIC_CHECK);
                            $dataText = str_replace('"' . $varname . '"', $vartext, stripslashes($dataText));
                            $datasetEncode[] = json_decode(eval('return "' . addslashes($dataText) . '";'), true);
                        }

                    }

                    //End of Preparing Chart

                    //Preparing Statistics
                    $sql2 = $chartStatistics[0][1];
                    $dataStatistics = self::dataType($dtype, self::multiData($sql2, self::$connection));

                    $array_result = get_object_vars($dataStatistics[0]);
                    $array_result_object_name_keys = array_keys($array_result);
                    $array_result_object_name_value = array_values($array_result);

                    foreach ($dataStatistics as $row) {
                        for ($i = 0; $i < count($array_result_object_name_keys); $i++) {
                            if($i == 0){
                                $data1 = self::dataType($dtype, $row->{$array_result_object_name_keys[$i]});
                            } else if($i == 1) {
                                $data2 = self::dataType($dtype, $row->{$array_result_object_name_keys[$i]});
                                $data_label2 = $array_result_object_name_keys[$i];
                            } else if($i == 2) {
                                $data3 = self::dataType($dtype, $row->{$array_result_object_name_keys[$i]});
                                $data_label3 = $array_result_object_name_keys[$i];
                            }
                        }
                    }

                    if($label1 != 'NULL' && $label1 != null) {
                        $description = $data2 . ' ' . $label2 . ' ' . $data3;
                    } else {
                        $description = $data2 . ' ' . $data_label2 . ' ' . $data3;
                    }

                } else if ($statisticsCount <= 1) {

                    $data = self::multiData(self::$sql, self::$connection);

                    // Prepare Chart Data
                    $object_values = get_object_vars($data[0]);
                    $columnName = array_keys($object_values);
                    $countColumn = count($object_values);
                    foreach ($data as $key => $row) {
                        $array_result[] = get_object_vars($data[$key]);
                        $array_name = get_object_vars($data[$key]);
                        $array_result_object_name[] = array_keys($array_name);
                        $array_result_object_name[] = array_shift($array_result_object_name);
                        $array_result_object_name_keys[] = array_keys($array_name);
                    }
                    $columnData1 = array_map('ucfirst', array_column($array_result, $columnName[0]));

                    // Check if first column have a string
                    $arrayType = self::checkArrayDataType($columnData1);
                    $i = 0;
                    $columnData = array();

                    if ($valueLabels != 'NULL' && $valueLabels != null) {
                        $columnLabels = explode(",", $valueLabels);
                    } else if ($arrayType == 'string') {
                        $columnLabels = str_replace('_', ' ', $columnData1);
                        $i = 1;
                    }

                    for ($x = $i; $x < $countColumn; $x++) {
                        $columnData[] = array_map('ucfirst', array_column($array_result, $columnName[$x]));
                    }
                    if (strpos(self::$dataset, '"$sets"') !== false) {
                        $dataset = self::$dataset;
                    } else if (strpos(self::$dataset, '$sets') !== false) {
                        $dataset = str_replace('$sets', '"$sets"', self::$dataset);
                    } else {
                        $pattern = '/\"$\S+/';
                        if (preg_match('/\"\$\S+\"/', self::$dataset, $matches) == 1) {
                            $vartext = $matches[0];
                            $dataset = self::$dataset;
                        } else {
                            preg_match('/\$\S+/', self::$dataset, $matches);
                            $vartext = $matches[0];
                            $dataset = str_replace($vartext, '"' . $vartext . '"', self::$dataset);
                        }

                        $var = str_replace('$', '', $vartext);
                        $varname = $vartext;
                    }

                    $datasetCount = count(json_decode($dataset));
                    $datasetDecode = json_decode($dataset);
                    $datasetEncode = array();

                    for ($y = 0; $y < $datasetCount; $y++) {
                        $dataText = json_encode($datasetDecode[$y]);
                        if (isset($sets)) {
                            $sets = json_encode((object)$columnData[$y], JSON_NUMERIC_CHECK);
                            $dataText = str_replace('"$sets"', '$sets', $dataText);
                            $datasetEncode[] = json_decode(eval('return "' . addslashes($dataText) . '";'), true);
                        } else {
                            ${$var} = json_encode((object)$columnData[$y], JSON_NUMERIC_CHECK);
                            $dataText = str_replace('"' . $varname . '"', $vartext, $dataText);
                            $datasetEncode[] = json_decode(eval('return "' . addslashes($dataText) . '";'), true);
                        }

                    }
                }

            } else {
                $data1 = null;
                $description = 'No Data';
                $columnLabels = array('No Data');
                $datasetEncode = array('0');
            }

            $chart_labels = $columnLabels;
            $datasets = $datasetEncode;
            if ($chartWidth != "NULL" && $chartWidth != null) {
                $chartWidth = $chartWidth;
            } else {
                $chartWidth = 353;
            }

            if ($chartHeight != "NULL" && $chartHeight != null) {
                $chartHeight = $chartHeight;
            } else {
                $chartHeight = 230;
            }

            $chartjs = app()->chartjs
                ->name($titlechart)
                ->type(self::$sub_type)
                ->size(['width' => $chartWidth, 'height' => $chartHeight])
                ->labels($chart_labels)
                ->datasets($datasets)
                ->optionsRaw(self::$chart_options);

            return view($view)
                ->with('id', self::$id)
                ->with('data1', $data1)
                ->with('title', ucfirst(self::$title))
                ->with('description', self::$description)
                ->with('class', self::$class)
                ->with('color', self::$color)
                ->with('bdrColor', $bdrColor)
                ->with('icon', self::$iconClass)
                ->with('chartjs', $chartjs);
        } catch (\Exception $e) {
            $data = 'PHP';
            $title = 'ERROR';
            $error = $e->getMessage();
            $view = 'errors.errorbox.error';
            return view($view)->with('data',$data)->with('title',$title)->with('error',$error);

        }
    }

    public static function chartInBoxStatistics(){
        try {
            $view = 'layouts.dashboard.items.charts.chart-in-box-statistics';
            $items[] = json_decode(self::$labels);
            foreach ($items as $label) {
                $value = $label->Value != 'NULL' ? $label->Value : null;
                $valueColor = $label->ValueColor != 'NULL' ? $label->ValueColor : null;
                $valueLabels = $label->ValueLabels != 'NULL' ? $label->ValueLabels : null;
                $label1 = $label->Label1 != 'NULL' ? $label->Label1 : null;
                $label2 = $label->Label2 != 'NULL' ? $label->Label2 : null;
                $chartWidth = $label->ChartWidth != 'NULL' ? $label->ChartWidth : null;
                $chartHeight = $label->ChartHeight != 'NULL' ? $label->ChartHeight : null;
                $statisticsPosition = $label->StatisticsPosition != 'NULL' ? $label->StatisticsPosition : null;
                $dtype = $label->DataType_number != 'NULL' ? $label->DataType_number : 'NULL';
            }

            $bdrColor = str_replace('bg', 'bdr', self::$color);

            $titlechart = str_replace(' ', '_', self::$title);
            if ($value != 'NULL' && $value != null && $value == 'manual') {

                $columnLabels = $valueLabels;
                $datasetEncode = self::$dataset;

            } else if (self::$sql != null && self::$sql != '' && self::$sql != ' ') {
                $chartStatistics[] = explode(";", self::$sql);
                $statisticsCount = count($chartStatistics[0]);
                if ($statisticsCount >= 2) {
                    $sql1 = $chartStatistics[0][0];
                    $data = self::multiData($sql1, self::$connection);

                    // Prepare Chart Data
                    $object_values = get_object_vars($data[0]);
                    $columnName = array_keys($object_values);
                    $countColumn = count($object_values);
                    foreach ($data as $key => $row) {
                        $array_result[] = get_object_vars($data[$key]);
                        $array_name = get_object_vars($data[$key]);
                        $array_result_object_name[] = array_keys($array_name);
                        $array_result_object_name[] = array_shift($array_result_object_name);
                        $array_result_object_name_keys[] = array_keys($array_name);
                    }
                    $columnData1 = array_map('ucfirst', array_column($array_result, $columnName[0]));

                    // Check if first column have a string
                    $arrayType = self::checkArrayDataType($columnData1);
                    $i = 0;
                    $columnData = array();

                    if ($valueLabels != 'NULL' && $valueLabels != null) {
                        $columnLabels = explode(",", $valueLabels);
                    } else if ($arrayType == 'string') {
                        $columnLabels = str_replace('_', ' ', $columnData1);
                        $i = 1;
                    }

                    for($x = $i; $x < $countColumn; $x++) {
                        $columnData[] = array_map('ucfirst', array_column($array_result, $columnName[$x]));
                    }
                    if(strpos(self::$dataset, '"$sets"') !== false) {
                        $dataset = self::$dataset;
                    } else if(strpos(self::$dataset, '$sets') !== false) {
                        $dataset = str_replace('$sets', '"$sets"', self::$dataset);
                    } else {
                        $pattern = '/\"$\S+/';
                        if(preg_match('/\"\$\S+\"/', self::$dataset, $matches) == 1) {
                            $vartext = str_replace('"','',$matches[0]);
                            $dataset = self::$dataset;
                        } else {
                            preg_match('/\$\S+/', self::$dataset, $matches);
                            $vartext = $matches[0];
                            $dataset = str_replace($vartext, '"' . $vartext . '"', self::$dataset);
                        }
                        $var = str_replace('$', '', $vartext);
                        $varname = $vartext;
                    }

                    $datasetCount = count(json_decode($dataset));
                    $datasetDecode = json_decode($dataset);
                    $datasetEncode = array();

                    for ($y = 0; $y < $datasetCount; $y++) {
                        $dataText = json_encode($datasetDecode[$y]);
                        if (isset($sets)) {
                            $sets = json_encode((object)$columnData[$y], JSON_NUMERIC_CHECK);
                            $dataText = str_replace('"$sets"', '$sets', $dataText);
                            $datasetEncode[] = json_decode(eval('return "' . addslashes($dataText) . '";'), true);
                        } else {

                            ${$var} = json_encode((object)$columnData[$y], JSON_NUMERIC_CHECK);
                            $dataText = str_replace('"' . $varname . '"', $vartext, stripslashes($dataText));
                            $datasetEncode[] = json_decode(eval('return "' . addslashes($dataText) . '";'), true);
                        }

                    }

                    //End of Preparing Chart

                    //Preparing Statistics
                    $sql2 = $chartStatistics[0][1];
                    $dataStatistics = self::dataType($dtype, self::multiData($sql2, self::$connection));

                    $array_result = get_object_vars($dataStatistics[0]);
                    $array_result_object_name_keys = array_keys($array_result);
                    $array_result_object_name_value = array_values($array_result);

                    $values = array();
                    foreach ($dataStatistics as $row) {
                        for ($i = 0; $i < count($array_result_object_name_keys); $i++) {
                            if($i == 0){
                                $data1 = self::dataType($dtype, $row->{$array_result_object_name_keys[$i]});
                            } else if($i == 1) {
                                $data2 = self::dataType($dtype, $row->{$array_result_object_name_keys[$i]});
                                $data_label2 = $array_result_object_name_keys[$i];
                            } else if($i == 2) {
                                $data3 = self::dataType($dtype, $row->{$array_result_object_name_keys[$i]});
                                $data_label3 = $array_result_object_name_keys[$i];
                            } else {
                                $values[] = $row->{$array_result_object_name_keys[$i]};
                                $valuesLabel[] = $array_result_object_name_keys[$i];
                                if(count($valueColor) >= ($i - 3)) {
                                    $c = $i - 3;
                                    $valuesLabelColor[] = $valueColor[$c];
                                } else {
                                    $valuesLabelColor[] = 'bg-default';
                                }
                            }
                        }
                    }

                    if($label1 != 'NULL' && $label1 != null) {
                        $description = $data2 . ' ' . $label2 . ' ' . $data3;
                    } else {
                        $description = $data2 . ' ' . $data_label2 . ' ' . $data3;
                    }

                } else if ($statisticsCount <= 1) {

                    $values = [];
                    $valuesLabel = [];
                    $valuesLabelColor = [];
                    $data = self::multiData(self::$sql, self::$connection);

                    // Prepare Chart Data
                    $object_values = get_object_vars($data[0]);
                    $columnName = array_keys($object_values);
                    $countColumn = count($object_values);
                    foreach ($data as $key => $row) {
                        $array_result[] = get_object_vars($data[$key]);
                        $array_name = get_object_vars($data[$key]);
                        $array_result_object_name[] = array_keys($array_name);
                        $array_result_object_name[] = array_shift($array_result_object_name);
                        $array_result_object_name_keys[] = array_keys($array_name);
                    }
                    $columnData1 = array_map('ucfirst', array_column($array_result, $columnName[0]));

                    // Check if first column have a string
                    $arrayType = self::checkArrayDataType($columnData1);
                    $i = 0;
                    $columnData = array();

                    if ($valueLabels != 'NULL' && $valueLabels != null) {
                        $columnLabels = explode(",", $valueLabels);
                    } else if ($arrayType == 'string') {
                        $columnLabels = str_replace('_', ' ', $columnData1);
                        $i = 1;
                    }

                    for ($x = $i; $x < $countColumn; $x++) {
                        $columnData[] = array_map('ucfirst', array_column($array_result, $columnName[$x]));
                    }
                    if (strpos(self::$dataset, '"$sets"') !== false) {
                        $dataset = self::$dataset;
                    } else if (strpos(self::$dataset, '$sets') !== false) {
                        $dataset = str_replace('$sets', '"$sets"', self::$dataset);
                    } else {
                        $pattern = '/\"$\S+/';
                        if (preg_match('/\"\$\S+\"/', self::$dataset, $matches) == 1) {
                            $vartext = $matches[0];
                            $dataset = self::$dataset;
                        } else {
                            preg_match('/\$\S+/', self::$dataset, $matches);
                            $vartext = $matches[0];
                            $dataset = str_replace($vartext, '"' . $vartext . '"', self::$dataset);
                        }

                        $var = str_replace('$', '', $vartext);
                        $varname = $vartext;
                    }

                    $datasetCount = count(json_decode($dataset));
                    $datasetDecode = json_decode($dataset);
                    $datasetEncode = array();

                    for ($y = 0; $y < $datasetCount; $y++) {
                        $dataText = json_encode($datasetDecode[$y]);
                        if (isset($sets)) {
                            $sets = json_encode((object)$columnData[$y], JSON_NUMERIC_CHECK);
                            $dataText = str_replace('"$sets"', '$sets', $dataText);
                            $datasetEncode[] = json_decode(eval('return "' . addslashes($dataText) . '";'), true);
                        } else {
                            ${$var} = json_encode((object)$columnData[$y], JSON_NUMERIC_CHECK);
                            $dataText = str_replace('"' . $varname . '"', $vartext, $dataText);
                            $datasetEncode[] = json_decode(eval('return "' . addslashes($dataText) . '";'), true);
                        }

                    }
                }

            } else {
                $values = [];
                $valuesLabel = null;
                $valuesLabelColor = null;
                $data1 = null;
                $description = 'No Data';
                $columnLabels = array('No Data');
                $datasetEncode = array('0');
            }

            $chart_labels = $columnLabels;
            $datasets = $datasetEncode;
            if ($chartWidth != "NULL" && $chartWidth != null) {
                $chartWidth = $chartWidth;
            } else {
                $chartWidth = 353;
            }

            if ($chartHeight != "NULL" && $chartHeight != null) {
                $chartHeight = $chartHeight;
            } else {
                $chartHeight = 230;
            }

            $chartjs = app()->chartjs
                ->name($titlechart)
                ->type(self::$sub_type)
                ->size(['width' => $chartWidth, 'height' => $chartHeight])
                ->labels($chart_labels)
                ->datasets($datasets)
                ->optionsRaw(self::$chart_options);

            return view($view)
                ->with('id', self::$id)
                ->with('data1', $data1)
                ->with('title', ucfirst(self::$title))
                ->with('description', self::$description)
                ->with('class', self::$class)
                ->with('color', self::$color)
                ->with('bdrColor', $bdrColor)
                ->with('icon', self::$iconClass)
                ->with('chartjs', $chartjs)
                ->with('values', $values)
                ->with('valuesLabel', $valuesLabel)
                ->with('valueLabelColor', $valuesLabelColor)
                ->with('statisticsPosition', $statisticsPosition);
        } catch (\Exception $e) {
            $data = 'PHP';
            $title = 'ERROR';
            $error = $e->getMessage();
            $view = 'errors.errorbox.error';
            return view($view)->with('data',$data)->with('title',$title)->with('error',$error);

        }
    }

    public static function table(){
        try {
            $view = 'layouts.dashboard.items.widgets.table.table';
            $items[] = json_decode(self::$labels);
            $value = null;
            $tableData = array();
            $tableHeaderFooter = array();
            foreach ($items as $label) {
                $hclass = $label->HeaderClass != 'NULL' ? $label->HeaderClass : null;
                $bclass = $label->BodyClass != 'NULL' ? $label->BodyClass : null;
                $tclass = $label->BodyClass != 'NULL' ? $label->TableClass : null;
                $pagination = $label->Pagination != 'NULL' ? $label->Pagination : null;
            }

            if (self::$sql == null || self::$sql == "" || self::$sql == " ") {
                $data = 'NULL';
            } else if (self::$sql != null || self::$sql != '' || self::$sql != ' ') {
                $data = self::multiData(self::$sql);
                $array_result = get_object_vars($data[0]);
                $array_result_object_name_keys = array_keys($array_result);
                $array_result_object_name_value = array_values($array_result);

                foreach ($array_result_object_name_keys as $key => $row) {
                    $tableHeaderFooter[] = '<th>'.ucfirst(str_replace('_',' ',$row)).'</th>';
                }

                foreach ($data as $key => $row) {
                    $value = null;
                    $startTableRow = '<tr>';
                    $keys = $key + 1;
                    $numbers = '<td>'.$keys.'</td>';
                    for ($i = 0; $i < count($array_result_object_name_keys); $i++) {
                        $value .= '<td>'.$row->{$array_result_object_name_keys[$i]}.'</td>';
                    }
                    $endTableRow = '</tr>';
                    $tableData[] = $startTableRow.$numbers.$value.$endTableRow;
                }
            } else {
                $data = 'No Data';
            }

            return view($view)
                ->with('id', self::$id)
                ->with('title', self::$title)
                ->with('icon', self::$iconClass)
                ->with('class', self::$class)
                ->with('hclass', $hclass)
                ->with('bclass', $bclass)
                ->with('tclass', $tclass)
                ->with('pagination', $pagination)
                ->with('tableheaderfooter', $tableHeaderFooter)
                ->with('tabledata', $tableData);
        } catch (\Exception $e) {
            $data = 'PHP';
            $title = 'ERROR';
            $error = $e->getMessage();

            $view = 'errors.errorbox.error';
            return view($view)->with('data',$data)->with('title',$title)->with('error',$error);

        }
    }

    public static function map(){
        try {
            $view = 'layouts.dashboard.items.maps.map';
            $items[] = json_decode(self::$labels);

            foreach ($items as $label) {
                $value = $label->Value != 'NULL' ? $label->Value : null;
                $valueLabels = $label->ValueLabels != 'NULL' ? $label->ValueLabels : null;
                $mapLong = $label->mapLong != 'NULL' ? $label->mapLong : null;
                $mapLat = $label->mapLat != 'NULL' ? $label->mapLat : null;
                $mapWidth = $label->mapWidth != 'NULL' ? $label->mapWidth : null;
                $mapHeight = $label->mapHeight != 'NULL' ? $label->mapHeight : null;
                $mapMax = $label->mapMax != 'NULL' ? $label->mapMax : null;
                $mapMin = $label->mapMin != 'NULL' ? $label->mapMin : null;
                $mapStart = $label->mapStart != 'NULL' ? $label->mapStart : null;
            }

            /*$titlechart = str_replace(' ', '_', self::$title);
            if ($value != 'NULL' && $value != null && $value == 'manual') {

                $columnLabels = $valueLabels;
                $datasetEncode = json_decode(self::$dataset);

            } else if(self::$sql != null && self::$sql != '' && self::$sql != ' ') {

                $data = self::multiData(self::$sql,self::$connection);

                // Prepare Chart Data
                $object_values = get_object_vars($data[0]);
                $columnName = array_keys($object_values);
                $countColumn = count($object_values);
                foreach ($data as $key => $row) {
                    $array_result[] = get_object_vars($data[$key]);
                    $array_name = get_object_vars($data[$key]);
                    $array_result_object_name[] = array_keys($array_name);
                    $array_result_object_name[] = array_shift($array_result_object_name);
                    $array_result_object_name_keys[] = array_keys($array_name);
                }
                $columnData1 = array_map('ucfirst',array_column($array_result, $columnName[0]));

                // Check if first column have a string
                $arrayType = self::checkArrayDataType($columnData1);
                $i = 0;
                $columnData = array();

                if($valueLabels != 'NULL' && $valueLabels != null){
                    $columnLabels = explode(",",$valueLabels);
                } else if($arrayType == 'string'){
                    $columnLabels = str_replace('_', ' ', $columnData1);
                    $i = 1;
                }

                for ($x = $i; $x < $countColumn; $x++) {
                    $columnData[] = array_map('ucfirst',array_column($array_result, $columnName[$x]));
                }
                if (strpos(self::$dataset, '"$sets"') !== false) {
                    $dataset = self::$dataset;
                }else if(strpos(self::$dataset, '$sets') !== false){
                    $dataset = str_replace('$sets', '"$sets"', self::$dataset);
                } else {
                    $pattern = '/\"$\S+/';
                    if(preg_match('/\"\$\S+\"/', self::$dataset, $matches) == 1){
                        $vartext = str_replace('"','',$matches[0]);
                        $dataset = self::$dataset;
                    } else {
                        preg_match('/\$\S+/', self::$dataset, $matches);
                        $vartext = $matches[0];
                        $dataset = str_replace($vartext, '"'.$vartext.'"', self::$dataset);
                    }

                    $var = str_replace('$', '', $vartext);
                    $varname = $vartext;
                }

                $datasetCount = count(json_decode($dataset));
                $datasetDecode = json_decode($dataset);
                $datasetEncode = array();

                for ($y = 0; $y < $datasetCount; $y++) {
                    $dataText = json_encode($datasetDecode[$y]);
                    if(isset($sets)) {
                        $sets = json_encode((object) $columnData[$y],JSON_NUMERIC_CHECK);
                        $dataText = str_replace('"$sets"', '$sets', $dataText);
                        $datasetEncode[] = json_decode(eval('return "' . addslashes($dataText) . '";'),true);
                    } else{
                        ${$var} = json_encode((object) $columnData[$y],JSON_NUMERIC_CHECK);
                        $dataText = str_replace('"'.$varname.'"', $vartext, $dataText);
                        $datasetEncode[] = json_decode(eval('return "' . addslashes($dataText) . '";'),true);
                    }

                }

            } else {
                $columnLabels = array('No Data');
                $datasetEncode = array('0');
            }

            $chart_labels = $columnLabels;
            $datasets = $datasetEncode;
            */

            if($mapLong != "NULL" && $mapLong != null){
                $mapLong = $mapLong;
            } else {
                $mapLong = 47.190976;
            }

            if($mapLat != "NULL" && $mapLat != null){
                $mapLat = $mapLat;
            } else {
                $mapLat = 15.387664;
            }

            if($mapMax != "NULL" && $mapMax != null){
                $mapMax = $mapMax;
            } else {
                $mapMax = 18;
            }

            if($mapMin != "NULL" && $mapMin != null){
                $mapMin = $mapMin;
            } else {
                $mapMin = null;
            }

            if($mapStart != "NULL" && $mapStart != null){
                $mapStart = $mapStart;
            } else {
                $mapStart = 6.2;
            }

            if($mapWidth != "NULL" && $mapWidth != null){
                $mapWidth = $mapWidth;
            } else {
                $mapWidth = 696;
            }

            if($mapHeight != "NULL" && $mapHeight != null){
                $mapHeight = $mapHeight;
            } else {
                $mapHeight = 230;
            }

            /*
            $mapleaflet = app()->mapleaflet
                ->name($titlechart)
                ->type(self::$sub_type)
                ->size(['width' => $chartWidth, 'height' => $chartHeight])
                ->labels($chart_labels)
                ->datasets($datasets)
                ->optionsRaw(self::$chart_options);
            */

            $data = self::mapData(self::$sql,self::$connection);
            //'[{"longitude":"44.17285156","latitude":"15.35949516"}]'
            $mapleaflet = app()->mapleaflet
                ->name('test')
                ->tile(self::$tile)
                ->type(self::$sub_type)
                ->size(['width' => $mapWidth, 'height' => $mapHeight])
                ->labels([])
                ->zoom(['max' => $mapMax, 'min' => $mapMin, 'start' => $mapStart])
                ->location(['long' => $mapLong, 'lat' => $mapLat])
                ->datajson($data)
                ->marker(self::$marker)
                ->tooltip(self::$tooltip)
                ->popup(self::$popup)
                ->datasets(null)
                ->optionsRaw(null);

            return view($view)
                ->with('id',self::$id)
                ->with('title',ucfirst(self::$title))
                ->with('class',self::$class)
                ->with('icon',self::$iconClass)
                ->with('mapleaflet',$mapleaflet);

        } catch (\Exception $e) {
            $data = 'PHP';
            $title = 'ERROR';
            $error = $e->getMessage();
            $view = 'errors.errorbox.error';
            return view($view)->with('data',$data)->with('title',$title)->with('error',$error);

        }
    }

}
