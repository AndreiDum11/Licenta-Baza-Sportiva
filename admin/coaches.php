<?php
class coaches {
    private $id;
    private $nume;
    private $poza;
    private $varsta;
    private $tipSport;
    public $dbConn;

    function setId($id) {
        $this->id = $id;
    }

    function getId() {
        return $this->id;
    }

    function setName($nume) {
        $this->nume = $nume;
    }

    function getName() {
        return $this->nume;
    }

    function setPoza($poza) {
        $this->poza = $poza;
    }

    function getPoza() {
        return $this->poza;
    }

    function setVarsta($varsta) {
        $this->varsta = $varsta;
    }

    function getVarsta() {
        return $this->varsta;
    }

    function settipSport($tipSport) {
        $this->tipSport = $tipSport;
    }

    function gettipSport() {
        return $this->tipSport;
    }

    function __construct() {
        require_once 'database2.php';
        $db = new DbConnect;
        $this->dbConn = $db->connect();
    }

    public function insert() {
        $sql_command = $this->dbConn->prepare("INSERT INTO antrenori (nume, poza, varsta, tipSport) VALUES (:nume, :poza, :varsta, :tipSport)");
        $sql_command->bindParam(':nume', $this->nume);
        $sql_command->bindParam(':poza', $this->poza);
        $sql_command->bindParam(':varsta', $this->varsta);
        $sql_command->bindParam(':tipSport', $this->tipSport);
        if ($sql_command->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getCoachesBySport($tipSport) {
        $sql_command = $this->dbConn->prepare("SELECT * FROM antrenori WHERE tipSport = :tipSport");
        $sql_command->bindParam(':tipSport', $tipSport);
        $sql_command->execute();
        return $sql_command->fetchAll(PDO::FETCH_ASSOC);
    }
}
