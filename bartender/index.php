<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
global $conf;
$conf = array();
require_once 'config.php';
$siteviews = array(NULL => 'EntranceController','' => 'EntranceController','/' => 'EntranceController',
                        '/products' => 'ProductsController','/fillorders' => 'FillOrderController',);
$uri = $_SERVER['PATH_INFO'];
if(array_key_exists($uri, $siteviews)) {
  $controller = $siteviews[$uri];
}else{
  $controller = 'ErrorController';
}
require_once 'controllers/' . $controller . '.php';
$control = new $controller($_SERVER, $_REQUEST);
$control->process();

class Model {
  protected $db;
  protected $table;
  protected $id_column = 'id';

  public function __construct($db, $table, $id_column = 'id') {
    $this->db = $db;
    $this->table = $table;
    $this->id_column = $id_column;
  }

  public function get($where = NULL) {
    $sqlStatement = 'SELECT * FROM ' . $this->table;
    if($where) {$sqlStatement .= ' WHERE fill_status IS NULL';}
    $sqlStatement .= ' LIMIT :limit OFFSET :offset';
    $statement = $this->db->prepare($sqlStatement);
    $statement->bindValue(':limit', 100, PDO::PARAM_INT);
    $statement->bindValue(':offset', 0, PDO::PARAM_INT);
    if($statement->execute()) {
      return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
  }
  public function insert($record) {
    $column_names = $this->get_column_names();
    $sqlStatement = 'INSERT INTO ' . $this->table . ' (';
    foreach($column_names as $column) {
      if(array_key_exists($column, $record)) {
        if($column > 0) {
          $sqlStatement .= ', ';
        }
        $sqlStatement .= $column;
      }
    }
    $sqlStatement .= ') VALUES (';
    foreach($column_names as $column) {
      if(array_key_exists($column, $record)) {
        if($column > 0) {
          $sqlStatement .= ', ';
        }
        $sqlStatement .= ':' . $column;
      }
    }
    $sqlStatement .= ')';
    $st = $this->db->prepare($sqlStatement);
    if($st->execute($record)) {
      return $this->db->lastInsertId();
    }
  }

  public function update($record) {
    $column_names = $this->get_column_names();
    $sqlStatement = 'UPDATE ' . $this->table . ' SET ';
    $first = TRUE;
    foreach($column_names as $column) {
      if(array_key_exists($column, $record)) {
        if($first) {
          $first = FALSE;
        } else {
          $sqlStatement .= ', ';
        }
        $sqlStatement .= $column . '=:' . $column;
      }
    }
    $sqlStatement .= ' WHERE ' . $this->id_column . '=:' . $this->id_column;
    $st = $this->db->prepare($sqlStatement);
    return $st->execute($record);
  }

  protected function get_column_names() {
    static $column_names = array();
    if(empty($column_names)) {
      $rs = $this->db->query('SELECT * FROM ' . $this->table . ' LIMIT 0');
      for ($i = 0; $i < $rs->columnCount(); $i++) {
        $column = $rs->getColumnMeta($i);
        if($column['name'] != $this->id_column) {
          $column_names[] = $column['name'];
        }
      }
    }
    return $column_names;
  }
}

class View {
  protected $template;
  public function __construct($view) {
    $this->template = 'views/' . $view . '.php';
  }
  
  public function render($parameters = array()) {
    ob_start();
    extract($parameters);
    include $this->template;
    ob_end_flush();
  }
}

class Controller { 
  protected $server;
  protected $request;
  protected $method;
  public function __construct($server, $request) {
    global $conf;
    $this->server = $server;
    $this->request = $request;
    $this->method = strtoupper($server['REQUEST_METHOD']);
    $this->db = new PDO($conf['db']['url'], $conf['db']['username'], $conf['db']['password']);
  } 
  public function GET(){}

  public function POST(){}

  public function process() {
    switch ($this->method) {
      case 'POST':
        $this->POST();
        break;
      default:
        $this->GET();
    }
  }
}


