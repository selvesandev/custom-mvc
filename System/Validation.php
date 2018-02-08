<?php

namespace Application\System;
class Validation
{
    private $_errors = [];

    /**
     * Validation Logic (empty,min,max,email)
     * @param $ruleCollections
     */
    public function validate($ruleCollections)
    {
        foreach ($ruleCollections as $field => $rules) {
            $rules = explode('|', $rules);

            foreach ($rules as $rule) {
                if ($rule === 'required' && $_POST[$field] === '') {
                    $this->setRules($field, $field . ' is required');
                } else if ($_POST[$field] !== '') {
                    if (preg_match('/min:\d*/', $rule)) {
                        preg_match('/\d/', $rule, $match);
                        $minValue = $match[0];
                        if (strlen($_POST[$field]) < $minValue) {
                            $this->setRules($field, $field . ' must be at least ' . $minValue . ' characters');
                        }
                    } else if (preg_match('/max:\d*/', $rule)) {
                        preg_match('/\d+/', $rule, $match);
                        $maxValue = $match[0];

                        if (strlen($_POST[$field]) > $maxValue) {
                            $this->setRules($field, $field . ' must be less than ' . $maxValue . ' characters');
                        }
                    } else if ($rule === 'email') {
                        if (!filter_var($_POST[$field], FILTER_VALIDATE_EMAIL)) {
                            $this->setRules($field, $field . ' should be a valid email address');
                        }
                    } else if (preg_match('/matches:/', $rule)) {
                        $matchField = str_replace('matches:', '', $rule);
                        if ($_POST[$field] !== $_POST[$matchField]) {
                            $field = str_replace('_', ' ', $field);
                            $this->setRules($field, "{$field} as {$matchField} must match");
                        }
                    }

                }
            }
        }
    }

    /**
     * Checks to see if the validation passed or not
     * @return bool
     */
    public function isValid()
    {
        return empty($this->_errors);
    }


    /**
     * Get all the validation fail errors if any
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }


    /**
     *
     * @param $field
     * @param $message
     * @return bool
     */
    private function setRules($field, $message)
    {
        if (empty($field)) return false;
        $this->_errors[$field] = $message;
    }
}