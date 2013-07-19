<?php
/**
 * User: Paris Theofanidis
 * Date: 9/7/12
 * Time: 9:18 AM
 */
class DateTimeExValidator extends CValidator
{
    /**
     * @var boolean whether the attribute value can be null or empty. Defaults to true,
     * meaning that if the attribute is empty, it is considered valid.
     */
    public $allowEmpty=true;

    /**
     * Validates the attribute of the object.
     * If there is any error, the error message is added to the object.
     * @param CModel $object the object being validated
     * @param string $attribute the attribute being validated
     */
    protected function validateAttribute($object, $attribute) {
        $value=$object->$attribute;
        if($this->allowEmpty && $this->isEmpty($value))
            return;

        if (!$value instanceof DateTimeEx) {
            $message = $this->message !== null ? $this->message : Yii::t('validators','The instance of {attribute} is not DateTimeEx.');
            $this->addError($object, $attribute, $message);
            return;
        }

        if ($value->year < Calendar::MINIMUM_YEAR) {
            $this->addError($object, $attribute, Yii::t('validators', 'Invalid Year'));
            return;
        }

        if ($value->month < 1 || $value->month > 12) {
            $this->addError($object, $attribute, Yii::t('validators', 'Invalid Month'));
            return;
        }

        if ($value->day < 1 || $value->day > Calendar::daysInMonth($value->month, $value->year)) {
            $this->addError($object, $attribute, Yii::t('validators', 'Invalid Date'));
            return;
        }

        if ($value->hour < 0 || $value->hour > 23) {
            $this->addError($object, $attribute, Yii::t('validators', 'Invalid Hour (24h format) {value}'), array('{value}' => $value->hour));
            return;
        }

        if ($value->min < 0 || $value->min > 59) {
            $this->addError($object, $attribute, Yii::t('validators', 'Invalid minutes {value}'), array('{value}' => $value->min));
            return;
        }

        if ($value->sec < 0 || $value->sec > 59) {
            $this->addError($object, $attribute, Yii::t('validators', 'Invalid seconds {value}'), array('{value}' => $value->sec));
            return;
        }
    }
}
