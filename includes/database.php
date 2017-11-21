<?php
    class Database {
        private $host;
        private $user;
        private $password;
        private $dbName;
        private $DB;

        private function dbClose() {
            mysqli_close($this->DB);
        }

        public function setConection($host, $user, $password, $dbName) {
            $this->host = $host;
            $this->user = $user;
            $this->password = $password;
            $this->dbName = $dbName;

            $this->dbConnect();
        }

        private function dbConnect() {
                $this->DB = new MYSQLI($this->host, $this->user, $this->password,  $this->dbName);

                if (!$this->DB) {
                    die("Connection failed: " . mysqli_connect_error());
                }
        }

        public function returnConnection() {
            return $this->DB;
        }
    }

?>