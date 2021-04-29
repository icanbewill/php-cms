<?php


class Validate {

    /** @var Database */
    private $_Db = null;
    /** @var array */
    private $_errors = [];
    /** @var boolean */
    private $_passed = false;
    /** @var integer */
    private $_recordID = null;
    /** @var array */
    private $_source = [];

   
    public function __construct(array $source, $recordID = null) {
        $this->_Db = DbManager::getInstance();
        $this->_recordID = $recordID;
        $this->_source = $source;
    }

    private function _addError($input, $error) {
        $this->_errors[$input][] = str_replace(['-', '_'], ' ', ucfirst(strtolower($error)));
    }

    public function check(array $inputs) {
        $this->_errors = [];
        $this->_passed = false;
        foreach ($inputs as $input => $rules) {
            if (isset($this->_source[$input])) {
                $value = trim($this->_source[$input]);
                $this->_validate($input, $value, $rules);
            } else {
                $this->_addError($input, Text::get("VALIDATE_MISSING_INPUT", ["%ITEM%" => $input]));
            }
        }
        if (empty($this->_errors)) {
            $this->_passed = true;
        }
        return $this;
    }

    public function errors() {
        return($this->_errors);
    }

    public function passed() {
        return($this->_passed);
    }

    private function _validate($input, $value, array $rules) {
        foreach ($rules as $rule => $ruleValue) {
            if (($rule === "required" and $ruleValue === true) and empty($value)) {
                //print $value."là<br>";
                $this->_addError($input, Text::get("VALIDATE_REQUIRED_RULE", ["%ITEM%" => $input]));
            } elseif (!empty($value)) {
                $methodName = lcfirst(ucwords(strtolower(str_replace(["-", "_"], "", $rule)))) . "Rule";
                if (method_exists($this, $methodName)) {
                    $this->{$methodName}($input, $value, $ruleValue);
                } else {
                    $this->_addError($input, Text::get("VALIDATE_MISSING_METHOD", ["%ITEM%" => $input]));
                }
            }
        }
    }

    protected function filterRule($input, $value, $ruleValue) {
        
        switch ($ruleValue) {
            // Email
            case "email":
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $data = [
                        "%ITEM%" => $input,
                        "%RULE_VALUE%" => $ruleValue
                    ];
                    $this->_addError($input, Text::get("VALIDATE_FILTER_RULE", $data));
                }
                break;
        }
    }

    protected function matchesRule($input, $value, $ruleValue) {
        if ($value != $this->_source[$ruleValue]) {
            $data = [
                "%ITEM%" => $input,
                "%RULE_VALUE%" => $ruleValue
            ];
            $this->_addError($input, Text::get("VALIDATE_MATCHES_RULE", $data));
        
            //print $value."doit ressembler à  ".$this->_source[$ruleValue];
        }
    }

    protected function maxCharactersRule($input, $value, $ruleValue) {
        if (strlen($value) > $ruleValue) {
            $data = [
                "%ITEM%" => $input,
                "%RULE_VALUE%" => $ruleValue
            ];
            $this->_addError($input, Text::get("VALIDATE_MAX_CHARACTERS_RULE", $data));
        }
    }

    protected function minCharactersRule($input, $value, $ruleValue) {
        if (strlen($value) < $ruleValue) {
            $data = [
                "%ITEM%" => $input,
                "%RULE_VALUE%" => $ruleValue
            ];
            $this->_addError($input, Text::get("VALIDATE_MIN_CHARACTERS_RULE", $data));     
           // print $value."    doit aller à  ".$ruleValue;
        }
    }

    protected function requiredRule($input, $value, $ruleValue) {
        //print $value."ici";
        if ($ruleValue === true and empty($value)) {
            $this->_addError($input, Text::get("VALIDATE_REQUIRED_RULE", ["%ITEM%" => $input]));
        }
    }

    protected function uniqueRule($input, $value, $ruleValue) {
        // print $input;
        // print $value;
        $check = $this->_Db->select($ruleValue, [$input, "=", $value]);
       // var_dump($check);
        if ($check->count()) {
         //   print "existe";
            if ($this->_recordID and $check->first()->id === $this->_recordID) {
                // print "bon";
                return;
            }
            $this->_addError($input, Text::get("VALIDATE_UNIQUE_RULE", ["%ITEM%" => $input]));
        }
    }

}
