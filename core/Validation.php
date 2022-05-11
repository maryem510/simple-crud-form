<?php

class Validation
{
    public $errors = [];
    public function minVal($name, $value, $length)
    {
        if (is_string($value)) {
            if (strlen($value) < $length) {
                $this->errors[] = "$name must be grater than $length";
            
            }
        } else {
            if ($value < $length) {
                $this->errors[] = "$name must be grater than $length";
            }
        }
    }

    public function maxVal($name, $value, $length)
    {
        if (is_string($value)) {
            if (strlen($value) > $length) {
                $this->errors[] = "$name must be less than $length";
            }
        } else {
            if ($value > $length) {
                $this->errors[] = "$name must be less than $length";
            }
        }
    }

    public function requiredVal($name, $value)
    {

        if (empty($value)) {
            $this->errors[] = "$name field is required";
        }
    }

    public function stringVal($name, $value)
    {
        if (is_string($value)) {
            $value = trim(htmlspecialchars(htmlentities($value)));
            if (!preg_match("/^[a-zA-Z 0-9]+$/", $value)) {
                $this->errors[] = "$name field must be valid string";
            }
        }
    }

    public function emailVal($name, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "$name field must be valid email ";
        }
    }

    public function intVal($name, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            $this->errors[] = "$name field must be valid integer ";
        }
    }

    public function floatVal($name, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_FLOAT)) {
            $this->errors[] = "$name field must be valid float ";
        }
    }

    public function boolVal($name, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
            $this->errors[] = "$name field must be valid boolean ";
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }


    public function isSuccess()
    {
        if (empty($this->errors)) {
            return true;
        }
    }

    public function result()
    {
        if (!$this->isSuccess()) {
            foreach ($this->getErrors() as $error) {
                echo "$error <br/> ";
            }
            exit;
        } else {
            return true;
        }
    }
}
