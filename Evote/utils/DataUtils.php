<?php


class DataUtils {

    // functions to verify dates
    public function isToday($time) { // midnight second

        return (strtotime($time) === strtotime('today'));
    }

    public function isPast($time) {
        return (strtotime($time) < time());
    }

    public function isFuture($time) {
        return (strtotime($time) > time());
    }

    // verify event end date
    public function verifyEndDateEvent($time) {
        if ($this->isFuture($time) || $this->isToday($time)){
            return true;
        }else {
            return false;
        }
    }

    // verify event start date
    public function verifyStartDateEvent($time) {
        if ($this->isPast($time) || $this->isToday($time)){
            return true;
        }else {
            return false;
        }
    }


}