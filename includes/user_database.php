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
                $loop = sizeof($array);
                
                $query = "UPDATE ".$post_id." SET ".$insert_id." = ? WHERE ";
                $types ='';
                $where_array = array();
                $where_array[] = $value;
                $i = 0;

                if(is_numeric($value)):
                    $types.='i';
                elseif(is_string($value)):
                    $types.='s';
                else:
                    $types.='s';
                endif;



                foreach($array as $key=>$value):
                    if(is_numeric($value)):
                        $types.='i';
                    elseif(is_double($value)):
                        $types.='d';
                    elseif(is_string($value)):
                        $types.='s';
                    else:
                        $types.='s';
                    endif;

                    if($i == $loop - 1):
                        $query .= $key."=? LIMIT 1";
                    else:
                        $query .= $key."=? AND ";
                    endif;

                    $where_array[] = $value;

                    $i++;
                endforeach;




                if($stmt = $this->DB->prepare($query)):
                    $stmt->bind_param($types, ...$where_array);
                    $stmt->execute();
                    
                    return mysqli_affected_rows($this->DB);
                else:
                    return $this->DB->errno;             
                endif;
       
            } else {
                return false;
            }
        }



        public function deleteRecordFromArray($post_id, $array) {
            if($this->isConnected()) {
                $loop = sizeof($array);
                
                $query = "DELETE FROM ".$post_id." WHERE ";
                $types ='';
                $where_array = array();
                $i = 0;


                foreach($array as $key=>$value):
                    if(is_numeric($value)):
                        $types.='i';
                    elseif(is_double($value)):
                        $types.='d';
                    elseif(is_string($value)):
                        $types.='s';
                    else:
                        $types.='s';
                    endif;

                    if($i == $loop - 1):
                        $query .= $key."=?";
                    else:
                        $query .= $key."=? AND ";
                    endif;

                    $where_array[] = $value;

                    $i++;
                endforeach;


        

                if($stmt = $this->DB->prepare($query)):
                    $stmt->bind_param($types, ...$where_array);
                    $stmt->execute();
                  
                    return true;
                else:
                    return $this->DB->errno;             
                endif;
       
            } else {
                return false;
            }
        }

        public function createTable($data) {
            if($this->isConnected()) {
                $query = "CREATE TABLE ".$data[0]['value']." (";
                
                for($i = 1; $i < sizeof($data); $i++):
                    if($i % 2 == 1):
                        $query.= $data[$i]['value']." "; 
                    else:
                        if($i != (sizeof($data)-1)):
                            $query.=$data[$i]['value'].",";
                        else :
                            $query.=$data[$i]['value']." )";
                        endif;
                    endif;
                endfor;

                if($stmt = $this->DB->prepare($query)):
                    $stmt->execute();
                  
                    return "Zaktualizowany rekord";
                else:
                    return $this->DB->error;             
                endif;
                        

            } else {
                return "Nie mozna polaczyc sie z baza danych";
            }
        }


        public function deleteTable($id) {
            if($this->isConnected()) {
              $query = "DROP TABLE ".$id;
                if($stmt = $this->DB->prepare($query)):
                    $stmt->execute();
                  
                    return "Usunięto tabelę ".$id;
                else:
                    return $this->DB->error;             
                endif;
                        

            } else {
                return "Nie mozna polaczyc sie z baza danych";
            }
        }

        public function querySelect($query) {
            if($this->isConnected()) {      
                if($stmt = $this->DB->prepare($query)):
                    $stmt->execute();
                    
                    $res = $stmt->get_result();

                    $result = array();
                     
                    if(is_array($res)):
                        while($row = $res->fetch_assoc())
                            $result[] = $row;
                        return $result;
                    else: 
                        return "Zapytanie wykonane pomyslnie";
                    endif;
               
                else:
                    return $this->DB->error;             
                endif;
                        

            } else {
                return "Nie mozna polaczyc sie z baza danych";
            }
        }

        public function returnDB() {
            return $this->DB;
        }

        function __construct($host, $user, $password, $dbName) {
            $this->setConection($host, $user, $password, $dbName);
        }
    }

?>