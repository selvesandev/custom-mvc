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
                if ($rule === 'required' &&
                    (isset($_POST[$field]) && ($_POST[$field] === '' || count($_POST[$field]) < 1) ||
                        (isset($_FILES[$field])) && $this->isImageEmpty($field))) {
                    $this->setRules($field, $field . ' is required');
                } else if ((isset($_POST[$field]) && $_POST[$field] !== '') || isset($_FILES[$field]) && !$this->isImageEmpty($field)) {
                    if (preg_match('/min:\d*/', $rule)) {
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
                    } else if (preg_match('/extension:/', $rule)) {
                        $matchField = str_replace('extension:', '', $rule);
                        $matchFields = explode(',', $matchField);

                        $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));

                        if (!in_array($ext, $matchFields)) {
                            $this->setRules($field, $matchField . ' only supported');
                        }
                    } else if (preg_match('/unique:/', $rule)) {
                        $matchField = str_replace('unique:', '', $rule);
                        $matchFields = explode(',', $matchField);
                        if (count($matchFields) >= 2) {
                            $tableName = $matchFields[0];
                            $columnName = $matchFields[1];

                            $db = Database::instantiate();

                            if (count($matchFields) === 3) {
                                $criteriaColumnValue = explode(':', $matchFields[2]);
                                $query = "SELECT " . $columnName . " FROM " . $tableName . " where " . $columnName . "='" . $_POST[$field] . "' AND " . $criteriaColumnValue[0] . "!='" . $criteriaColumnValue[1] . "'";
                                $data = $db->query($query);
                            } else {
                                $data = $db->where([$columnName => $_POST[$field]])->select($tableName, [$columnName]);
                            }

                            if (count($data))
                                $this->setRules($field, $field . ' must be unique');
                        }

                    }
                }
            }
        }

    }


    private function isImageEmpty($field)
    {
        if ($_FILES[$field]['error'] === 4)
            return true;
        return false;
    }

    /**
     * Checks to see if the validation passed or not
     * @return bool
     */
    public function isValid()
    {
        return empty($this->_errors);
    }


    private function emailCheck($field)
    {

    }

    private function minCheck($field)
    {

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