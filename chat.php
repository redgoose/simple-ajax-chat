<?php

class Chat {

    private $initial_lines = 5;
	
    public function __construct() {
		$this->db = new SQLiteDatabase('db/c.db');
		//$this->setupDb();
	    $this->truncateDb();
    }

	public function getLog($offset) {
        $query = $this->db->query("select max(rowid) from chat");
        $maxid = $query->fetchSingle();		
	    if (!$maxid) { $maxid = 0; }
        
        if (!$offset) {
            $offset = $maxid - $this->initial_lines;
		}

		$sql = "select rowid,n,m from chat where rowid > $offset";
		$query = $this->db->unbufferedQuery($sql);
		
        $json = array("msgs"=>array(),"offset"=>$maxid);
		
        while ($entry = $query->fetch(SQLITE_ASSOC)) {
			$name = $entry['n'];
			$msg = $entry['m'];
    		array_push($json["msgs"],array("n"=>$name,"m"=>$msg));
		}

        return json_encode($json);
	}

	public function insertMsg($msg) {
		$sql = "insert into chat values("
		. "'" . sqlite_escape_string($msg['name']) . "',"
		. "'" . sqlite_escape_string($msg['msg']) . "'"
		. ")";
		$this->db->queryExec($sql);
	}

    private function setupDb() {
		$this->db->queryExec("drop table chat");
		$this->db->queryExec("create table chat (n varchar(1), m text)");	
		//$this->db->queryExec("insert into chat values ('t','1')");
	}
    
    private function truncateDb() {
        $sql = "delete from chat where rowid not in (select rowid from chat order by rowid desc limit 100)";
        $this->db->queryExec($sql);
    }

}

?>
