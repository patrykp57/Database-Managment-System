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

        public function returnRecordsFromRange($id, $start) {
            if($this->isConnected()) {
                $stmt = $this->DB->prepare("SELECT * FROM ".$id." LIMIT ".$start.", 30");
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


        public function returnSize($id) {
            if($this->isConnected()):
                if($stmt = $this->DB->query("SELECT * FROM ".$id)):
                    $num = mysqli_num_rows($stmt);
                    return $num;
                endif;
            else:
                return 0;
            endif;
                
        }

        public function updateRecordFromArray($post_id, $insert_id, $value, $array) {
            if($this->isConnected()) {
                $loop = 2*sizeof($array);
                
                $query = "UPDATE ".$post_id." SET ".$insert_id." = '".$value."' WHERE ";
                $types ='';
                $where_array = array();

                foreach($array as $key => $value): 
                    $where_array[] = $key;
                    $where_array[] = $value;

                    $types.='s';
                    if(is_numeric($value)):
                        $types.='i';
                    elseif(is_string($value)):
                        $types.='s';
                    elseif(is_double($value)):
                        $types.='d';
                    else:
                        $types.='s';
                    endif;
                    
                endforeach;

                for($i = 0; $i< ($loop/2); $i++) {
                    if($i == ($loop/2)-1):
                        $query .= "? = ?";
                    else:
                        $query .= "? = ? AND ";
                    endif;
                }
                return $where_array;
                if($stmt = $this->DB->prepare($query)):
                    $stmt->bind_param($types, ...$where_array);
                    $stmt->execute();
                    $stmt = $stmt->num_rows;
                    return $stmt;
                else:
                    echo $this->DB->errno;
                    
                endif;
       
            } else {
                return '';
            }
        }

        function __construct($host, $user, $password, $dbName) {
            $this->setConection($host, $user, $password, $dbName);
        }
    }

?>