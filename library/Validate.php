<?php

class Validate
{
    private bool $runValue = true;
    private array $errorsValue = [];

    public function rules($input, $showName, $rules, $additional = null) : void {
        $value = $_POST[$input];
        $explodeRules = explode("|", $rules);
        if (array_search("numeric", $explodeRules) !== false) {
            $this->isNumeric($value, $showName);
        }

        if (array_search("required", $explodeRules) !== false) {
            $this->checkEmpty($value, $showName);
        }

        if (array_search("validEmail", $explodeRules) !== false) {
            $this->validEmail($value, $showName);
        }

        if (array_search("match", $explodeRules) !== false) {
            $this->match($value, $showName, $additional);
        }


    }

    public function errors() : string {
        $errors = "";
        foreach ($this->errorsValue as $item) {
            $errors .= "<div class='alert alert-danger'>";
            $errors .= $item;
            $errors .= "</div>";
        }
        return $errors;
    }

    public function run() : bool {
        return $this->runValue;
    }

    public function clean($value, $xssFiltering = true) : string | bool | int | float {
        $data = $value;
        if ($xssFiltering == true) {
            $data = trim($value);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
        }
        return $data;
    }

    // private methods
    private function validEmail($value, $showName) : void{
        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->runValue = false;
            $this->errorsValue[] = sprintf("The %s invalid format", $showName);
        }
    }

    private function checkEmpty($value, $showName) {
        if (empty($value)) {
            $this->runValue = false;
            $this->errorsValue[] = sprintf("The %s is required", $showName);
        }
    }

    private function isNumeric($value, $showName) {
        if (! is_numeric($value)) {
                $this->runValue = false;
                $this->errorsValue[] = sprintf("The %s must be number", $showName);
        }
    }

    private function match($value, $showName, $additional) {
        if ($value === $_POST[$additional]) {

        } else {
            $this->runValue = false;
            $this->errorsValue[] = sprintf("The %s must be match with %s", $showName, $additional);
        }
    }

}