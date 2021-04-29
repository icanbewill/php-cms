<?php 

class DbManager{
          private $connection;
          private static $_Database = null;
          private $_query = null;
          private $_error = false;
          public $_results = [];
          private $_count = 0;

          private function __construct() {
                    try {
                        $host = Config::get("DATABASE_HOST");
                        $name = Config::get("DATABASE_NAME");
                        $username = Config::get("DATABASE_USERNAME");
                        $password = Config::get("DATABASE_PASSWORD");
                        $this->connection = new PDO("mysql:host={$host};dbname={$name}", $username, $password);
                    } catch (PDOException $e) {
                        die($e->getMessage());
                    }
          }

          private static $settings = array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_EMULATE_PREPARES => false,
          );
          
          public static function queryOne($query, $params = array()){
                    $result = self::$connection->prepare($query);
                    $result->execute($params);
                    return $result->fetch();
          }

          public static function queryAll($query, $params = array()) {
                    $result = self::$connection->prepare($query);
                    $result->execute($params);
                    return $result->fetchAll();
          }

          public static function querySingle($query, $params = array())  {
                    $result = self::queryOne($query, $params);
                    if (!$result) return false;
                    return $result[0];
          }

      
          public static function getInstance() {
                    if (!isset(self::$_Database)) {
                              self::$_Database = new DbManager();
                              // print "non";
                    }
                    return(self::$_Database);
          }

          public function select($table, array $where = []) {
                    return($this->action('SELECT *', $table, $where));
          } 

          public function update($table, $id, array $fields) {
                    if (count($fields)) {
                        $x = 1;
                        $set = "";
                        $params = [];
                        foreach ($fields as $key => $value) {
                            $params[":{$key}"] = $value;
                            $set .= "`{$key}` = :$key";
                            if ($x < count($fields)) {
                                $set .= ", ";
                            }
                            $x ++;
                        }
                        if (!$this->query("UPDATE `{$table}` SET {$set} WHERE `id` = {$id}", $params)->error()) {
                            return true;
                        }
                    }
                    return false;
          }

          public function updateslug($table, $slug, array $fields) {
                    if (count($fields)) {
                        $x = 1;
                        $set = "";
                        $params = [];
                        foreach ($fields as $key => $value) {
                            $params[":{$key}"] = $value;
                            $set .= "`{$key}` = :$key";
                            if ($x < count($fields)) {
                                $set .= ", ";
                            }
                            $x ++;
                        }
                        if (!$this->query("UPDATE `{$table}` SET {$set} WHERE `slug` = {$slug}", $params)->error()) {
                            return true;
                        }
                    }
                    return false;
          }

          public function query($sql, array $params = []) {
                    $this->_count = 0;
                    $this->_error = false;
                    $this->_results = [];
                    if (($this->_query = $this->connection->prepare($sql))) {
                        foreach ($params as $key => $value) {
                            $this->_query->bindValue($key, $value);
                        }
                        if ($this->_query->execute()) {
                            $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                            $this->_count = $this->_query->rowCount();
                        } else {
                            $this->_error = true;
                            //die(print_r($this->_query->errorInfo()));
                        }
                    }
                    return $this;
          }
          
          public function results($key = null) {
                    return(isset($key) ? $this->_results[$key] : $this->_results);
          }
          
          public function action($action, $table, array $where = []) {
                    if (count($where) === 3) {
                        $operator = $where[1];
                        $operators = ["=", ">", "<", ">=", "<="];
                        if (in_array($operator, $operators)) {
                            $field = $where[0];
                            $value = $where[2];
                            $params = [":value" => $value];
                            if (!$this->query("{$action} FROM `{$table}` WHERE `{$field}` {$operator} :value", $params)->error()) {
                                return $this;
                            }
                        }
                    } else {
                        if (!$this->query("{$action} FROM `{$table}`")->error()) {
                            return $this;
                        }
                    }
                    return false;
          }

          public function error() {
                  //  var_dump($this->_error);
                    return($this->_error);
          }

          public function first() {
                    return($this->results(0));
          }

          public function count() {
                    // print $this->_count;
                    return($this->_count);
          }

          public function insert($table, array $fields) {
                    if (count($fields)) {
                            //   print_r($fields);
                        $params = [];
                        foreach ($fields as $key => $value) {
                            $params[":{$key}"] = $value;
                        }
                        $columns = implode("`, `", array_keys($fields));
                        $values = implode(", ", array_keys($params));
                        if (!$this->query("INSERT INTO `{$table}` (`{$columns}`) VALUES({$values})", $params)->error()) {
                            return($this->connection->lastInsertId());
                        }
                    }
                    return false;
          }

          public function find($table, array $where = []) {
                    $data = $this->select($table, $where);
                    // print "ici";
                    // print $table;
                    // print_r($where);
                    // print_r($data);
                    if ($data->count()) {
                        $this->data = $data->first();
                    }
                    return $this;
          }
            
          

}