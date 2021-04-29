<?php
    class Model {

        protected $Db = null;
        protected $data = [];
        public function __construct() {
            $this->Db = DbManager::getInstance();
        }

        protected function create($table, array $fields) {
            return($this->Db->insert($table, $fields));
        }
    
        public function data() {
            return($this->data);
        }

        public function exists() {
            return(!empty($this->data));
        }
        
        protected function find($table, array $where = []) {
            $data = $this->Db->select($table, $where);
            if ($data->count()) {
                $this->data = $data->first();
            }
            return $this;
        }

        protected function update($table, array $fields, $recordID = null) {
            if (!$recordID and $this->exists()) {
                $recordID = $this->data()->id;
            }
            return(!$this->Db->update($table, $recordID, $fields));
        }

    }
