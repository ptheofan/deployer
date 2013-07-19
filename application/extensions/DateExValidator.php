<?php
/**
 * User: Paris Theofanidis
 * Date: 9/7/12
 * Time: 9:18 AM
 */
class DateExValidator extends CValidator
{
    /**
     * @var boolean whether the attribute value can be null or empty. Defaults to true,
     * meaning that if the attribute is empty, it is considered valid.
     */
    public $allowEmpty=true;


    public $min;
    public $max;

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

        if (!$value instanceof DateEx) {
            $message = $this->message !== null ? $this->message : Yii::t('validators','The instance of {attribute} is not DateEx.');
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
    }
}
