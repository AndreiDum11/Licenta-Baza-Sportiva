<?php
    class DbConnect{
        private $db_server = "localhost";
        private $db_user = "root";
        private $db_pass = "";
        private $db_name = "bsportiva";

        public function connect(){
                try {
                    $conn  = new PDO('mysql:host=' . $this->db_server . ';dbname=' . $this->db_name,$this->db_user,
                $this->db_pass);
                    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                    return $conn;
                } catch (PDOException $th) {
                    echo 'Database Error: '.$th->getMessage();
                }
        }
}
?>