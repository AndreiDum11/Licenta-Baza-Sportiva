<?php
    class content{
        private $id;
        private $nume;
        private $tip;
        private $tipSport;
        private $descriere;
        private $dataincarcarii;
        public $dbConn;
        function setId($id){
            $this->id =$id;
        }
        function getId($id){
            return $this->id;
        }
        function setName($nume){
            $this->nume =$nume;
        }
        function getName($nume){
            return $this->nume;
        }
        function setType($tip){
            $this->tip =$tip;
        }
        function getType($tip){
            return $this->tip;
        }
        function settipSport($tipSport){
            $this->tipSport =$tipSport;
        }
        function gettipSport($tipSport){
            return $this->tipSport;
        }
        function setdescriere($descriere){
            $this->descriere =$descriere;
        }
        function getdescriere($descriere){
            return $this->descriere;
        }
        function setUploadedDate($dataincarcarii){
            $this->dataincarcarii =$dataincarcarii;
        }
        function getUploadedDate($dataincarcarii){
            return $this->dataincarcarii;
        }
        function __construct(){
            require_once 'database2.php';
            $db = new DbConnect;
            $this->dbConn = $db->connect();
            
        }
        public function insert(){
            $sql_command = $this->dbConn->prepare("insert into content_aboutus values(null, :nume, :tip, :tipSport,:descriere, :data)");
            $sql_command->bindParam(':nume',$this->nume);
            $sql_command->bindParam(':tip',$this->tip);
            $sql_command->bindParam(':tipSport',$this->tipSport);
            $sql_command->bindParam(':descriere',$this->descriere);
            $sql_command->bindParam(':data',$this->dataincarcarii);
            if($sql_command->execute()){
                return true;
            }else
                return false;
        }
        public function getContentBySport($tipSport){
            $sql_command = $this->dbConn->prepare("SELECT * FROM content_aboutus WHERE tipSport = :tipSport");
            $sql_command->bindParam(':tipSport', $tipSport, PDO::PARAM_STR);
            $sql_command->execute();
            return  $sql_command->fetch(PDO::FETCH_ASSOC);;
        }
    }