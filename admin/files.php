<?php
    class files{
        private $id;
        private $nume;
        private $tip;
        private $dataincarcarii;
        private $titlu;
        private $subtitlu;
        private $tipSport;
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
        function setUploadedDate($dataincarcarii){
            $this->dataincarcarii =$dataincarcarii;
        }
        function getUploadedDate($dataincarcarii){
            return $this->dataincarcarii;
        }
        function settitlu($titlu){
            $this->titlu =$titlu;
        }
        function gettitlu($titlu){
            return $this->titlu;
        }
        function setsubtitlu($subtitlu){
            $this->subtitlu =$subtitlu;
        }
        function getsubtitlu($nusubtitlume){
            return $this->subtitlu;
        }
        function settipSport($tipSport){
            $this->tipSport =$tipSport;
        }
        function gettipSport($tipSport){
            return $this->tipSport;
        }
        function __construct(){
            require 'database2.php';
            $db = new DbConnect;
            $this->dbConn = $db->connect();
            
        }
        
        public function insert() {
            global $conn;
            $sql = "INSERT INTO slider_imagef (nume, tip, data_incarcarii, titlu, subtitlu, tipSport) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'ssssss', $this->nume, $this->tip, $this->dataincarcarii, $this->titlu, $this->subtitlu, $this->tipSport);
            return mysqli_stmt_execute($stmt);
        }
        public function getFilesBySport($tipSport){
            $sql_command = $this->dbConn->prepare("SELECT * FROM slider_imagef WHERE tipSport = :tipSport");
            $sql_command->bindParam(':tipSport', $tipSport);
            $sql_command->execute();
            $result = $sql_command->fetchAll(PDO::FETCH_ASSOC); 
            return $result;
        }
        
    }