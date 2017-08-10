<?PHP
class Pageing {

	var $CurrRow = 0;
	var $size=3; // No. of Records per page
	var $MaxPage = 0;
	var $pageno = 1;
	var $totalrc = 0;
	var $rc1 = 0;
	var $functionflag = true ;
	var $formid = 0;
	var $inc = 1;

	function Pageing($size) {
		$this->size = $size;
	}

	function setForm($formid) {
		$this->formid = $formid;
	}

	function setPagesize($size) {
		$this->size = $size;
	}

	function getLimit($PageNo,$totalrc) {
		// echo $PageNo;
		$this->size;
		$this->totalrc = $totalrc;
		$this->MaxPage = ceil($this->totalrc/$this->size);
		$this->pageno = ($this->MaxPage >= $PageNo)?$PageNo:1;
		$this->CurrRow = ($this->pageno - 1) * $this->size;
		$limit = " LIMIT"." ".$this->CurrRow.",".$this->size*$this->inc ;

		// $limit = " LIMIT"." ".$this->CurrRow.",".$this->size*$this->inc ;
		// $this->inc++;
		return $limit;
	}

	function showPageing() {


		$StartPage = $this->pageno;

		// $EndPage
		if($this->pageno==$this->MaxPage){
	   $EndPage = $this->MaxPage+1;
    }else if($this->pageno<$this->MaxPage){
	   $EndPage =$StartPage+5;
	   if($EndPage>$this->MaxPage){$EndPage=$this->MaxPage+1;}
    }
   // $StartPage code
	 if($StartPage>=6){
		  $StartPage=($this->pageno)-4;
	 }else{
		 $StartPage=1;
	 	}

		if($this->MaxPage <= 10) {
			$EndPage = $this->MaxPage+1;
			$StartPage=1;
		}

		$pagename= $_SERVER['PHP_SELF'];
		echo "<span class='btn btn-blue btn-small btn-effect mtbrl'>";
		echo $pre = ($this->pageno==1)?"&lt;&nbsp;Prev":"<a href=$pagename?page=".($this->pageno-1)." >&lt;&nbsp;Prev</a>";
		echo "</span>";

		for($i=$StartPage;$i<$EndPage;$i++) {
			$startrec = ($i-1)*$this->size;
			$endrec = $startrec + $this->size;
			if($i==$EndPage-1){$hifstr="";}else{$hifstr="";}
			if ($this->pageno == $i){
				echo "<span class='btn btn-blue btn-small btn-effect mtbrl'>";
				echo " ".$i." " ;
				echo "</span>";
			}
			else{
				echo "<span class='btn btn-blue btn-small btn-effect mtbrl'>";
				echo "<a href='$pagename?page=".$i."' >".($i).'</a> '.$hifstr ;}
				echo "</span>";
			}
			echo "<span class='btn btn-blue btn-small btn-effect mtbrl'>";
			echo $next = ($this->MaxPage==$this->pageno)?"Next&nbsp;&gt;":"<a href=$pagename?page=".($this->pageno + 1).">Next&nbsp;&gt;</a> ";

			echo "</span>";
		}
	}
	?>
