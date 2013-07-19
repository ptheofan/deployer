<?php
/**
 * User: Paris Theofanidis
 * Date: 8/19/12
 * Time: 2:09 PM
 */
class DateTimeEx extends DateEx
{
    const FORMAT_SQL = 'sql';
    const FORMAT_HUMAN = 'human';
    const FORMAT_SYSTEM = 'system';


    public $min;
    public $hour;
    public $sec;


    /**
     * @static
     * @param null $datetime
     * @param $format
     * @return DateTimeEx
     */
    public static function nu($datetime = null, $format = self::FORMAT_HUMAN) {
        return new DateTimeEx($datetime, $format);
    }


    /**
     * @param $value
     * @param $format
     * @return ParserSQLDateTime
     */
    protected function parse($value, $format) {
        if ($format == self::FORMAT_SQL)
            return new ParserSQLDateTime($value);
        else
            return parent::parse($value, $format);
    }


    /**
     * @param $dateObj
     */
    public function copyFrom($dateObj) {
        parent::copyFrom($dateObj);

        if ($dateObj instanceof DateTimeEx) {
            $this->min = $dateObj->min;
            $this->hour = $dateObj->hour;
            $this->sec = $dateObj->sec;
        }
    }


    /**
     * @param $data
     * @return DateTimeEx
     */
    public function setComponents($data) {
        if (!isset($data[Calendar::MINUTES])){
            CVarDumper::dump($data,2,true);die;
        }
        $this->min = $data[Calendar::MINUTES];
        $this->hour = $data[Calendar::HOURS];
        $this->sec = $data[Calendar::SECONDS];
        return parent::setComponents($data);
    }


    /**
     * @return DateTimeEx
     */
    public function refreshData() {
        $timestamp = CTimestamp::getTimestamp($this->hour, $this->min, $this->sec, $this->month, $this->day, $this->year);
        $data = getdate($timestamp);
        $this->setComponents($data);
        return $this;
    }

    /**
     * @param $h
     * @param $m
     * @param $s
     * @return DateTimeEx
     */
    public function setTime($h, $m, $s) {
        $this->hour = $h;
        $this->min = $m;
        $this->sec = $s;
        $this->refreshData();
        return $this;
    }


    /**
     * @param $hour
     * @return DateTimeEx ($this for chaining)
     */
    public function setHour($hour)
    {
        $this->hour = $hour;
        return $this;
    }


    /**
     * @param $min
     * @return DateTimeEx ($this for chaining)
     */
    public function setMin($min)
    {
        $this->min = $min;
        return $this;
    }


    /**
     * @param $sec
     * @return DateTimeEx ($this for chaining)
     */
    public function setSec($sec)
    {
        $this->sec = $sec;
        return $this;
    }


    /**
     * Reset time to 12:00:00
     * @return DateTimeEx ($this for chaining)
     */
    public function time12() {
        $this->setTime(12, 0, 0);
        return $this;
    }


    /**
     * Reset time to 11:59:59
     * @return DateTimeEx ($this for chaining)
     */
    public function time11() {
        $this->setTime(11, 59, 59);
        return $this;
    }


    /**
     * @return bool
     */
    public function isEmpty() {
        return parent::isEmpty() && $this->min == 0 && $this->hour == 0 && $this->sec == 0;
    }


    /**
     * @return string
     */
    protected function valueSqlDate() {
        return sprintf("%04d-%02d-%02d %02d:%02d:%02d", $this->year, $this->month, $this->day, $this->hour, $this->min, $this->sec);
    }


    /**
     * @return string
     */
    protected function valueSystemDate() {
        return sprintf("%04d-%02d-%02d--%02d-%02d-%02d", $this->year, $this->month, $this->day, $this->hour, $this->min, $this->sec);
    }
}