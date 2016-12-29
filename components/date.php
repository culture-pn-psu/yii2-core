<?php

namespace culturePnPsu\core\components;

use Yii;
use yii\base\Component;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author Madone
 */
class date extends Component {

    public $times=[];
    /**
     * 
     * @param type $start
     * @param type $end
     * @return type
     */
    public function difference($start, $end) {
        
        $diff = abs(strtotime($start) - strtotime($end));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $days += ($years||$months)?0:1;
        $this->times = ['year' => $years, 'month' => $months, 'day' => $days];
        return $this;
    }
    
    public function toString(){
        $times = $this->times;
//        print_r($times);
//        exit();
        $str_times = '';
        if (array_filter($times)) {
            $str_times = '<small class="text-muted"><br/>เป็นเวลา ';
            $str_times .= ($times['year'] ? $times['year'] . ' ปี ' : '');
            $str_times .= ($times['month'] ? $times['month'] . ' เดือน ' : '');
            $str_times .= ($times['day'] ? $times['day'] . ' วัน' : '');
            $str_times .= '</small>';
        }
        return $str_times;
    }

}
