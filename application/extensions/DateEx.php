<?php
/**
 * User: Paris Theofanidis
 * Date: 8/19/12
 * Time: 2:09 PM
 */
class DateEx implements DatabaseValue
{
    // SQL Datetime
    const FORMAT_SQL = 'sql';
    // Human format (in the future might change to use locale for format)
    const FORMAT_HUMAN = 'human';
    // System value, used as id or classes or whatever in elements.
    const FORMAT_SYSTEM = 'system';

    public $wasEmptyOnConstructor;

    public $year;
    public $month;
    public $day;
    public $dayOfWeek;
    public $timestamp;


    /**
     * @param $value
     * @param $format
     * @return ParseHumanDate|ParserSQLDate|ParserSystemDate
     * @throws InvalidArgumentEx
     */
    protected function parse($value, $format) {
        switch($format) {
            case self::FORMAT_SQL: return new ParserSQLDate($value);
            case self::FORMAT_HUMAN: return new ParseHumanDate($value);
            case self::FORMAT_SYSTEM: return new ParserSystemDate($value);
            default:
                throw new InvalidArgumentEx("Unidentified format type", $format);
        }
    }


    /**
     * @static
     * @param null $datetime
     * @param string $format
     * @return DateEx
     */
    public static function nu($date = null, $format = self::FORMAT_HUMAN) {
        return new DateEx($date, $format);
    }


    /**
     * @param string|null|DateEx $datetime null will set it to 'now'
     * @param string $format
     */
    public function __construct($date = null, $format = self::FORMAT_HUMAN) {
        // Empty string? Sure, no prob :)
        if (is_string($date) && empty($date)) {
            $this->wasEmptyOnConstructor = true;
            return;
        }

        $this->wasEmptyOnConstructor = false;
        if ($date === null) {
            $this->setComponents(getdate());
        } elseif ($date instanceof DateEx) {
            $this->copyFrom($date);
        } elseif ($date instanceof DateTime) {
            die('datetime');
        } else {
            $parser = $this->parse($date, $format);
            $this->setComponents($parser->result);
        }
    }


    /**
     * @param $dateObj
     */
    public function copyFrom($dateObj) {
        $this->year = $dateObj->year;
        $this->month = $dateObj->month;
        $this->day = $dateObj->day;
        $this->dayOfWeek = $dateObj->dayOfWeek;
        $this->timestamp = $dateObj->timestamp;
    }


    /**
     * @param $data
     * @return DateTimeEx
     */
    public function setComponents($data) {
        $this->year = $data[Calendar::YEAR];
        $this->month = $data[Calendar::MONTH];
        $this->day = $data[Calendar::DAY];
        $this->dayOfWeek = isset($data[Calendar::DAY_OF_WEEK]) ? $data[Calendar::DAY_OF_WEEK] : false;
        $this->timestamp = isset($data[Calendar::TIMESTAMP]) ? $data[Calendar::TIMESTAMP] : false;
        return $this;
    }


    /**
     * @param DateTimeEx $dateTime
     * @param bool $ignoreTime
     * @return int -1 of less than $dateTime, 0 if equal and 1 if greater than $dateTime
     */
    public function compare(DateTimeEx $dateTime, $ignoreTime = true) {
        if ($this->year < $dateTime->year)
            return -1;

        if ($this->year > $dateTime->year)
            return 1;

        if ($this->month < $dateTime->month)
            return -1;

        if ($this->month > $dateTime->month)
            return 1;

        if ($this->day < $dateTime->day)
            return -1;

        if ($this->day > $dateTime->day)
            return 1;

        return 0;

    }


    /**
     * @return DateTimeEx
     */
    public function refreshData() {
        $timestamp = CTimestamp::getTimestamp(0, 0, 1, $this->month, $this->day, $this->year);
        $data = getdate($timestamp);
        $this->setComponents($data);
        return $this;
    }


    /**
     * @return DateTimeEx
     */
    public function nextMonth() {
        return $this->_nextMonth(false);
    }


    /**
     * @return DateTimeEx
     */
    public function prevMonth() {
        return $this->_prevMonth(false);
    }


    /**
     * @param bool $fast
     * @return DateEx
     */
    private function _nextMonth($fast = false) {
        $this->month++;
        if ($this->month > 12) {
            $this->month = 1;
            $this->year++;
        }

        if ($fast === false)
            $this->refreshData();

        return $this;
    }


    /**
     * @param bool $fast
     * @return DateEx
     */
    private function _prevMonth($fast = false) {
        $this->month--;
        if ($this->month < 1) {
            $this->month = 12;
            $this->year--;
        }

        if ($fast === false)
            $this->refreshData();

        return $this;
    }


    /**
     * @return DateTimeEx
     */
    public function advanceStartOfMonth() {
        if ($this->day != 1) {
            $this->day = 1;
            $this->refreshData();
        }

        return $this;
    }


    /**
     * @return DateEx
     */
    public function advanceLastDayOfMonth() {
        $daysInMonth = $this->daysInMonth();
        if ($this->day != $daysInMonth) {
            $this->day = $daysInMonth;
            $this->refreshData();
        }

        return $this;
    }


    /**
     * @param int|null $month
     * @param int|null $year
     * @return int
     */
    public function daysInMonth($month = null, $year = null) {
        return Calendar::daysInMonth($month === null ? $this->month : $month, $year === null ? $this->year : $year);
    }


    /**
     * @param $daysToAdvance
     * @return DateTimeEx
     * @throws InvalidArgumentEx
     */
    public function advanceDays($daysToAdvance) {
        if ($daysToAdvance == 0) {
            throw new InvalidArgumentEx('\$daysToAdvance cannot be 0', $daysToAdvance);
        }

        if ($daysToAdvance > 0) {
            for($i=0;$i<$daysToAdvance;$i++) {
                $this->nextDay();
            }
        } else {
            for($i=$daysToAdvance;$i<0;$i++) {
                $this->prevDay();
            }
        }
        return $this;
    }


    /**
     * @return DateTimeEx
     */
    public function nextDay() {
        $this->day++;
        if ($this->day > Calendar::daysInMonth($this->month, $this->year)) {
            $this->day = 1;
            $this->month++;
            if ($this->month > 12) {
                $this->month = 1;
                $this->year++;
            }
        }

        $this->nextDayOfWeek();
        return $this;
    }


    /**
     * @return DateTimeEx
     */
    public function prevDay() {
        $this->day--;
        if ($this->day < 1) {
            $this->month--;
            if ($this->month < 1)
                $this->year--;

            $this->day = Calendar::daysInMonth($this->month, $this->year);
        }

        $this->prevDayOfWeek();
        return $this;
    }


    /**
     * @return DateTimeEx
     */
    private function nextDayOfWeek() {
        $this->dayOfWeek++;
        if ($this->dayOfWeek > 6)
            $this->dayOfWeek = 0;

        $this->timestamp += 86400;
        return $this;
    }


    /**
     * @return DateTimeEx
     */
    private function prevDayOfWeek() {
        $this->dayOfWeek--;
        if ($this->dayOfWeek < 0) {
            $this->dayOfWeek = 6;
        }

        $this->timestamp -= 86400;
        return $this;
    }


    /**
     * @return bool
     */
    public function isEmpty() {
        return $this->day == 0 && $this->month == 0 && $this->year == 0;
    }


    /**
     * @return string
     */
    protected function valueSqlDate() {
        return sprintf("%04d-%02d-%02d", $this->year, $this->month, $this->day);
    }


    /**
     * @return string
     */
    public function valueHumanDate() {
        return sprintf('%02d/%02d/%04d', $this->day, $this->month, $this->year);
    }

    public function valueHumanDateDayMonth() {
        return sprintf('%02d/%02d', $this->day, $this->month);
    }


    /**
     * @return string
     */
    protected function valueSystemDate() {
        return sprintf("%04d-%02d-%02d", $this->year, $this->month, $this->day);
    }

    /**
     * @return string
     */
    public final function asSql() {
        return $this->valueSqlDate();
    }


    /**
     * @return string
     */
    public final function asHumanDate() {
        if ($this->wasEmptyOnConstructor && $this->isEmpty())
            return '';
        else
            return $this->valueHumanDate();
    }


    /**
     * @return string
     */
    public final function asSystem() {
        return $this->valueSystemDate();
    }


    /**
     * @return string
     */
    public final function __toString() {
        return $this->asHumanDate();
    }


    /**
     * @abstract
     * @return string
     */
    public function getSqlValue() {
        return $this->asSql();
    }


    /**
     * @param $day
     * @return DateTimeEx object ($this) for chaining
     */
    public function setDay($day)
    {
        $this->day = $day;
        return $this;
    }


    /**
     * @param $month
     * @return DateTimeEx ($this for chaining)
     */
    public function setMonth($month)
    {
        $this->month = $month;
        return $this;
    }


    /**
     * @param $timestamp
     * @throws NotImplementedException
     */
    public function setTimestamp($timestamp)
    {
        throw new NotImplementedException();
    }


    /**
     * @param $year
     * @return DateTimeEx ($this for chaining)
     */
    public function setYear($year)
    {
        $this->year = $year;
        return $this;
    }


    /**
     * @param $months
     * @return DateTimeEx ($this for chaining)
     */
    public function addMonths($months) {
        if ($months > 0) {
            for($i=0; $i < $months; $i++) {
                $this->_nextMonth(true);
            }
        } elseif ($months < 0) {
            for($i=$months; $i<0; $i++) {
                $this->prevMonth(true);
            }
        }

        $this->refreshData();
        return $this;
    }


    /**
     * @param $years
     * @return DateTimeEx ($this for chaining)
     */
    public function addYears($years) {
        $this->year += $years;
        $this->refreshData();
        return $this;
    }


    /**
     * @return string
     */
    public function getMonthShortName() {
        $months = Calendar::getMonthsShort();
        return $months[$this->month - 1];
    }


    /**
     * @return string
     */
    public function getMonthName() {
        $months = Calendar::getMonths();
        return $months[$this->month - 1];
    }
}
