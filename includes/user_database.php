<?php
    class UserDatabase {
        private $host;
        private $user;
        private $password;
        private $dbName;
        private $DB;

        private function dbClose() {
            mysqli_close($this->DB);
        }

        private function setConection($host, $user, $password, $dbName) {
            $this->host = $host;
            $this->user = $user;
            $this->password = $password;
            $this->dbName = $dbName;

            $this->dbConnect();
        }

        private function dbConnect() {
                $this->DB = @mysqli_connect($this->host, $this->user, $this->password,  $this->dbName);
                if (!$this->DB) {
                    $this->DB = null;
                }
        }
        
        private function isConnected() {
            if(empty($this->DB))return false;
            else return true;
        }


        public function returnConnection() {
            if($this->isConnected())
                return $this->DB;
            else
                return null;
        }

        public function returnTables() {
              $tables = array();
            if($this->isConnected()) {
                $query = mysqli_query($this->DB,"SHOW TABLES");
                while($value = mysqli_fetch_array($query)) 
                    $tables[] = $value[0];
                $this->dbClose();      
                return $tables;
            } else 
                return '';
            
        }

        public function returnColumns($id) {
            if($this->isConnected()) {
                $query = 'SHOW COLUMNS FROM '.$id;
                $stmt = $this->DB->query($query);
                while($row = $stmt->fetch_assoc())
                    $columns[] = $row['Field'];
            
                if($columns)
                    return $columns;
                else
                    return '';
            } else {
                return '';
            }
        }

        public function returnRecords($id) {
            if($this->isConnected()) {
                $stmt = $this->DB->prepare("SELECT * FROM ".$id);
                $stmt->execute();
                
                $res = $stmt->get_result();
                $result = array();

                while($row = $res->fetch_assoc())
                    $result[] = $row;
                return $result;
           
       
            } else {
                return '';
            }
        }

        function __construct($host, $user, $password, $dbName) {
            $this->setConection($host, $user, $password, $dbName);
        }
    }

?>