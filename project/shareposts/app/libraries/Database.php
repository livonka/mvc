<?php
/**
 * PDO DB class
 * connect to DB, create, prepare statements, bind values, return rows and results
 */
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASS;
    private $dbname = DB_NAME;

    private $db_handler;
    private $statement;
    private $error;

    public function __construct(){
        $dsn = "mysql:host=$this->host;dbname=$this->dbname";
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        //Create PDO instance
        try {
            $this->db_handler = new PDO($dsn, $this->user, $this->password, $options);
        }
        catch (PDOException $e){
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }
    //prepare query
    public function query($sql){
        $this->statement = $this->db_handler->prepare($sql);
    }
//////////////////////////////////кгда ставим ::
    //bind values
    public function bind($param, $value, $type = null){
        if (is_null($type)){
            switch (true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->statement->bindValue($param, $value, $type);
    }
	////////////////////////////////зачем такая функция, мы просто чужую вызываем без изменений
    //execute prepared statement
    public function execute(){
        return $this->statement->execute();
    }
    //get result set as array of objects
    public function result_set(){
        $this->statement->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }
    //get a single row result as object
    public function result_single(){
        $this->statement->execute();
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }
    //get rw count
    public function row_count(){
        return $this->statement->rowCount();
    }
}