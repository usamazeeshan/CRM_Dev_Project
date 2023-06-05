<?php 

ob_start();

error_reporting(E_ALL);
session_start();


class DataSource {
	protected $conn;
	protected $dbhost;
	public $dbname;	
	protected $dbusern;//db user id
	protected $dbuserp;//db password	
    public function __construct($dbhost,$dbusern,$dbuserp, $dbname) { 
	$this->dbhost = $dbhost;
    $this->dbusern = $dbusern;
    $this->dbuserp = $dbuserp;
    $this->dbname = $dbname;
	$this->conn = new mysqli($this->dbhost,$this->dbusern,$this->dbuserp,$this->dbname);
	if ($this->conn->connect_errno) {
			echo "Connect failed: ".$this->conn->connect_error;
		exit();
	}
}

public function insert($table, $data){
   $fields = array_keys( $data );  
	foreach($data AS $val) {
    $values[] = $this->conn->real_escape_string($val); 
	}
// 	echo "INSERT INTO $table(".implode(",",$fields).") VALUES ('".implode("','", $values )."');";
//  	die;
    $this->conn->query( "INSERT INTO $table(".implode(",",$fields).") VALUES ('".implode("','", $values )."');");
	return $insert_id = $this->conn->insert_id;
}

public function getLeadAssesment($table) {
    return $this->conn->query("select * from ".$table);
}

public function display($table,$condition=null)
{
//  echo "select * from ".$table." where ".$condition;
    if($condition) {
        return $this->conn->query("select * from ".$table." where ".$condition);
    } else {
        return $this->conn->query("select * from ".$table);
    }
	
}

public function display2($table,$value,$condition)
{
    // echo "select ".$value." from ".$table." where ".$condition;die;
	return $this->conn->query("select ".$value." from ".$table." where ".$condition);
}

public function display3($query)
{
	echo $query;
// 	die;
	return $this->conn->query($query);
}

public function update($table, $data, $cond)
{
    $fields = array_keys( $data );  
    $values = array_values( $data );  
    //$values = array_map( "mysql_real_escape_string", array_values( $data ) );
	for($i=0;$i<count($data);$i++)
	{
	$value=$this->conn->real_escape_string($values[$i]);
// 	echo "UPDATE $table SET $fields[$i]='$value' where $cond";
    $result=$this->conn->query("UPDATE $table SET $fields[$i]='$value' where $cond" );
	}
	return $result;
}

public function delete($table,$condition)
{
	$ty=$this->conn->query("DELETE FROM ".$table." where ".$condition);
	return $ty;
}

public function fetchCategoryTree($parent = 0,$spacing = '', $user_tree_array = '') 
{
	if (!is_array($user_tree_array))
	$user_tree_array = array();
	$par=$this->display("fb_prdtcategory","1=1 and parent_id=".$parent." order by id ASC"); 	
	while($row=$par->fetch_array())
	{ 
	  $user_tree_array[] = array("id" => $row['id'], "name" => $spacing . $row['prdtcat_name'],"level"=>$row['level']);
	  $user_tree_array = $this->fetchCategoryTree($row['id'], $spacing . '_&nbsp;', $user_tree_array);
	}
	return $user_tree_array;
	}
	
public function pagination($query, $per_page,$page, $url){        
    	$row1 = $this->display3($query);  
		 $total=$row1->num_rows;
        $adjacents = "2"; 

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
    	if($lastpage >= 1)
    	{	
    		$pagination .= "<ul class='pagination'>";
                    $pagination .= "<li class='details'>Page $page of $lastpage</li>";
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li><a class='current'>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='{$url}&page=$counter'>$counter</a></li>";					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}&page=$counter'>$counter</a></li>";					
    				}

   				$pagination.= "<li class='dot'>...</li>";
    				$pagination.= "<li><a href='{$url}&page=$lpm1'>$lpm1</a></li>";
   				$pagination.= "<li><a href='{$url}&page=$lastpage'>$lastpage</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='{$url}&page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}&page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>...</li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}&page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>..</li>";
    				$pagination.= "<li><a href='{$url}&page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}&page=$lastpage'>$lastpage</a></li>";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='{$url}&page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}&page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>..</li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
   						$pagination.= "<li><a href='{$url}&page=$counter'>$counter</a></li>";					
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= "<li><a href='{$url}&page=$next'>Next</a></li>";
                $pagination.= "<li><a href='{$url}&page=$lastpage'>Last</a></li>";
    		}else{
    			$pagination.= "<li><a class='current'>Next</a></li>";
                $pagination.= "<li><a class='current'>Last</a></li>";
            }
    		$pagination.= "</ul>\n";		
    	}
        return $pagination;
    } 
}


$db = new DataSource("localhost","root","","convcrdo_clients");	

if(dirname($_SERVER['PHP_SELF']) == '/') { $dir="";} else { $dir=dirname($_SERVER['PHP_SELF']);}

$base_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]".$dir;
$pathprefix="home.php?page=";

date_default_timezone_set('Asia/Muscat');

 function time_elapsed_string($datetime, $in_days=0, $full=0) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
if($in_days==1){
 $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day'
    );
}else{
    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
}
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : ($in_days==1?"Today":'Just now');
}

?>