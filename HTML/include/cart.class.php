<?php
class vinscart {
	var $shippingprice;
	function vinscart()
	{
		global $sesobj;
		if(!$sesobj->isassign("cartspipping"))
			$sesobj->assign("cartspipping","0.00");
		$this->shippingprice = $sesobj->get("cartspipping");
	}
	function setDonateInfo($orgid,$orgname,$partnerid,$partnername)
	{
		global $sesobj;
		$donateto = array("orgid" => $orgid, "orgname" => $orgname, "partnerid" => $partnerid, "partnername" => $partnername );
		$sesobj->assign("donateto",$donateto);
	}
	function removeDonateInfo()
	{
		global $sesobj;
		if($sesobj->isassign("donateto"))
		{
			$sesobj->unassign('donateto');
		}
	}
	function getorgid()
	{
		global $sesobj;
		$donateto = $sesobj->get("donateto");
		return $donateto['orgid'];
	}
	function getorgname()
	{
		global $sesobj;
		$donateto = $sesobj->get("donateto");
		return $donateto['orgname'];
	}
	function getpartnerid()
	{
		global $sesobj;
		$donateto = $sesobj->get("donateto");
		return $donateto['partnerid'];
	}
	function gettotaltax()
	{
		global $sesobj;
		$totaltax = 0 ;
		$cart = $sesobj->get("ecart");
		foreach($cart as $key=>$value)
			if(isset($cart[$key]['tax']))
				$totaltax += $cart[$key]['tax'];
		return $totaltax;
	}
	function getpartnername()
	{
		global $sesobj;
		$donateto = $sesobj->get("donateto");
		return $donateto['partnername'];
	}
	function addtocart($id,$proid,$name,$qty,$unitprice,$type,$off,$point,$shipping)
	{
		global $sesobj;
		if($sesobj->isassign("ecart"))
		{
			$newcart = array("cart_id" => $id, "prodid" => $proid,"name" => $name, "qty" => $qty, "off" => $off, "unitprice" => $unitprice,"totalprice" => $unitprice-$off,"granttotal" =>$qty*($unitprice-$off), "saving" => $qty*$off,"protype" => $type, "re_point" => $point,"tot_point" => $qty*$point,"shipping" => $shipping, "tot_shipping" => $qty*$shipping);
			$oldcart = $sesobj->get("ecart");
			foreach($oldcart as $key=>$value) $cart[$key]=$value;
			$cart[$proid] = $newcart;
			$sesobj->assign("ecart",$cart);
		}
		else
		{
			$cart =array($proid => array("cart_id" => $id, "prodid" => $proid, "name" => $name, "qty" => $qty, "off" => $off, "unitprice" => $unitprice,"totalprice" => $unitprice-$off,"granttotal" =>$qty*($unitprice-$off), "saving" => $qty*$off,"protype" => $type, "re_point" => $point,"tot_point" => $qty*$point, "shipping" => $shipping, "tot_shipping" => $qty*$shipping));
			$sesobj->assign("ecart",$cart);
		}
	
	}
	function addtocarts($newcart)
	{
		global $sesobj;
		$cart=array();
		if($sesobj->isassign("ecart"))
		{
			$oldcart = $sesobj->get("ecart");
			foreach($oldcart as $key=>$value) $cart[$key]=$value;
			foreach($newcart as $key=>$value) $cart[$key]=$value;
			$sesobj->assign("ecart",$cart);

		}
		else
		{
			foreach($newcart as $key=>$value) $cart[$key]=$value;
			$sesobj->assign("ecart",$cart);
		}
	}
	function editcart($edit)
	{
		global $sesobj;
		$cart = $sesobj->get("ecart");
		$sesobj->unassign("errmsg");
		foreach($edit as $key=>$value)
		{
			if(isset($cart[$key]))
			{
				if($value=="") {
					$value=1;
				}
				if($value==" ") {
					$value=1;
				}
				if($value=="0") {
					$value=1;
				}
				if($value=="") {
					$value=1;
				}
				if($value=="") {
					$value=1;
				}
				$cart[$key]['qty']=$value;
				$cart[$key]['totsave']=$value*$cart[$key]['save'];
				$cart[$key]['totalprice']=$value*$cart[$key]['price'];
				if($cart[$key]['tax']>0) {
					if($cart[$key]['taxname']=="Florida 7%" || $cart[$key]['taxname']=="Georgia 7%")
						$cart[$key]['tax']=(($cart[$key]["unitprice"]-$cart[$key]["save"])*$value)*0.07;
					if($cart[$key]['taxname']=="Texas 8.25%")
						$cart[$key]['tax']=(($cart[$key]["unitprice"]-$cart[$key]["save"])*$value)*0.0825;
				}
			}
		}
		$sesobj->assign("ecart",$cart);
	}
	function getcart()
	{
		global $sesobj;
		$cart = $sesobj->get("ecart");
		return $cart ;
	}
	function getproduct($proid)
	{
		global $sesobj;
		$cart = $sesobj->get("ecart");
		return $cart[$proid] ;
	}
	function removeproduct($proid)
	{
		global $sesobj;
		$cart = $sesobj->get("ecart");
		unset($cart[$proid]);
		$sesobj->assign("ecart",$cart);
	}
	function removecart()
	{
		global $sesobj;
		if($sesobj->isassign("ecart")) {
			$sesobj->unassign('ecart');
		}
		if($sesobj->isassign("donateto")) {
			$sesobj->unassign('donateto');
		}
		if($sesobj->isassign("cartspipping"))
			$sesobj->unassign("cartspipping");
	}
	function getshipingprice()
	{
		return $this->shippingprice ;
	}
	function setshipingprice($shprice)
	{
		global $sesobj;
		$this->shippingprice = $shprice ;
		$sesobj->assign("cartspipping", $shprice);
	}
	function gettotal()
	{
		global $sesobj;
		$total = 0 ;
		$cart = $sesobj->get("ecart");
		foreach($cart as $key=>$value) $total += $cart[$key]['totalprice'];
		return $total + $this->shippingprice ;
	}
	function gettotalpoint()
	{
		global $sesobj;
		$totalp = 0 ;
		$cart = $sesobj->get("ecart");
		foreach($cart as $key=>$value) $totalp += $cart[$key]['tot_point'];
		return $totalp;
	}
	function gettotalprice()
	{
		global $sesobj;
		$total = 0 ;
		$cart = $sesobj->get("ecart");
		foreach($cart as $key=>$value) $total += $cart[$key]['totalprice'];
		return $total;
	}
	function savecart()
	{
		global $sqlobj;
		global $sesobj;
		if($sesobj->isassign("ecart") && $sesobj->isassign("login"))
		{
		$cart = $sesobj->get("ecart");
		$savequery = "insert into usercart (user_id,pro_id,pro_name,qty,unitprice,pro_type,savings) values ";
		foreach($cart as $key=>$value)
		{
			$savequery .= " ('".$sesobj->get("login")."','".$cart[$key]['prodid']."','".$cart[$key]['name']."','".$cart[$key]['qty']."','".$cart[$key]['unitprice']."','".$cart[$key]['protype']."','".$cart[$key]['off']."'),";
		}
			$savequery = substr($savequery,0,(strlen($savequery)-1));
			$sqlobj->query($savequery);
			$sesobj->unassign('ecart');
			$sesobj->unassign('login');
		}
	}
	function getTaxval($val=0) {
		global $sesobj;
		if($val==0) $val=$this->gettotalprice();
		if($sesobj->get('taxname')=='FL') {
			return round($val*0.07,2);
		} else if($sesobj->get('taxname')=='GA') {
			return round($val*0.08,2);
		} else if($sesobj->get('taxname')=='TX') {
			return round($val*0.0825,2);
		} else if($sesobj->get('taxname')=='CA') {
			return round($val*0.0975,2);
		} else if($sesobj->get('taxname')=='NC') {
			return round($val*0.0775,2);
		} else {
			return 0;
		}
	}
}
$cartobj = new vinscart();
?>
