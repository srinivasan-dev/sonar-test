<?php
include_once("../include/loader.php");
include_once("resize.php");
if($sesobj->get("username")==""){
	echo '<script language="javascript" type="text/javascript">window.location.href="index.php"</script>';die;
}

if($userobj->getVariable('cmd_submit')!="" && $userobj->getVariable('txt_proname')!=""){

	$thumb_width=170;
	$thumb_height=100;

	$large_width=150;
	$large_height=150;
	

	$icon_dir="iconimage/";
	$thumb_dir="assets/img/imageforproduct/";
	$large_dir="assets/img/largeimage/";
	$verylarge_dir="assets/img/verylargeimage/";

	if($_FILES['txt_product_image']["name"]!=""){
		
		$filename=time().$_FILES['txt_product_image']["name"];
		$tmp_name=$_FILES["txt_product_image"]['tmp_name'];
		$up_fname=$large_dir.$filename;
		$up_fnamelarge=$verylarge_dir.$filename;
		copy($tmp_name,$up_fname);
		chmod($up_fname,0777);
		if(move_uploaded_file($tmp_name,$up_fname)) {
			
			$thumb=new thumbnail($large_dir.$filename);
			$thumb->size_width($thumb_width);
			$thumb->size_height($thumb_height);
			$thumb->save($thumb_dir.$filename);

			$image=new thumbnail($large_dir.$filename);
			$image->size_width($large_width);
			$image->size_height($large_height);
			$image->save($verylarge_dir.$filename);

			copy($up_fname);
		}
	}
	if($_FILES['txt_partsimage']["name"]!="")
		move_uploaded_file($_FILES['txt_partsimage']["tmp_name"],"partsimage/".time().$_FILES['txt_partsimage']["name"]);

	$data=array();
	$data["product_name"]= stripslashes($userobj->getVariable('txt_proname'));
	$data["cat_id"]= $userobj->getVariable('sel_rootcatname');
	$data["subcat_id"]= $userobj->getVariable('sel_subcatname');
	$data["product_short_desc"]= stripslashes($userobj->getVariable('txt_desc'));
	$data["product_qty"]=$userobj->getVariable('txt_quantity');
	$data["aprice"]=$userobj->getVariable('txt_price');
	$data["sprice"]=$userobj->getVariable('txt_special_price');
	if($_FILES['txt_product_image']['name']!="")
		$data["product_image"]=time().$_FILES['txt_product_image']['name'];
	$data["rank"]=$userobj->getVariable('txt_rank');
	$data["is_active"]=$userobj->getVariable('sel_status');
	if($userobj->getVariable('cmd_submit')=="Add"){
		$data["inserted_date"]=time();
	}
	$data["is_featured_product"]=($userobj->getVariable('featured_product')!= "")?$userobj->getVariable('featured_product'):'0';
	$data["is_out_of_stock"]=($userobj->getVariable('chk_outof_stock')!= "")?$userobj->getVariable('chk_outof_stock'):'0';;
	if($userobj->getVariable('cmd_submit')=="Update") {
		$data["updated_date"]=time();
		$where=" product_id=".$userobj->getVariable('id');
	}
	$res =$sqlobj->save("products",$data,$where);
	echo '<script type="text/javascript">window.location.href="manage_product.php"</script>';die;
}
if($userobj->getVariable('id')!=""){
	$query_prod="SELECT * FROM products where product_id='".$userobj->getVariable('id')."' ";
	$res_prod=$sqlobj->getdatalistfromquery($query_prod);
}
$qry = "SELECT cat_id, cat_name, parent_id FROM categories where is_deleted=0"; 
$res_qry=$sqlobj->getdatalistfromquery($qry);
include_once("header1.php");
?>
<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="assets/scripts/main.js"></script> 
<script language="javascript" type="text/javascript">
	CKEDITOR.config.width ='600px';
	CKEDITOR.config.height='250px';
	function populate_select(values,id){
		$("#"+id).each(function(){
			$('#'+id+' option[value="'+values+'"]').prop("selected",true);
		});
	}
function showSubcat(str){
		$.ajax({
			type: "POST",
			url: "subcat.php",
			data: { "id": str},
			dataType: "html"
		}).done(function(msg) {
			document.getElementById("subcatecory").innerHTML=msg;
		});
	}
	
	$(document).ready(function(){
		$("#cancel_button1").click(function(event){
			event.preventDefault();
			$("#cancel_button").hide();
			$("#cancel_button1").hide();
			$("#showing").show();
		});
	});
	$(document).ready(function(){
		$("#cancelbutton2").click(function(event){
			$("#filehide").hide();
			$("#cancelbutton2").hide();
			$("#buton").show();
			event.preventDefault();
		});
	});
	$(document).ready(function(){
		$("#cancelbutton3").click(function(event){
		$("#hidingfile").hide();
		$("#cancelbutton3").hide();
		$("#cancel").show();
		event.preventDefault();
		});
	});
	$(document).ready(function(){
		$("#cancelbutton4").click(function(event){
			alert('test');
			$("#filehiding").hide();
			$("#cancelbutton4").hide();
			$("#butten").show();
			event.preventDefault();
		});
	});
	
</script>
<div class="clearfix">
	<?php include_once('leftnavi.php'); ?>
	<div class="col-sm-9">
		<section class="content">
			<form name="frm_add_product" id="frm_add_product" action="#" method="post" onsubmit="javascript:return addProduct();" enctype="multipart/form-data">
				<input type="hidden" value="<?php echo $_GET['id'];?>" id="txt_prod_id" name="txt_prod_id">
				<div class="totalcontent">
					<div id="full">
						
						<div class="title"><h3 style="border-bottom: 1px solid;margin-bottom: 20px;padding-bottom: 10px;">Add Product</h3></div>
						<div class="box1">Product Name</div>
						<div class="dot">:</div>
						<div class="search1">
							<input class="text" type="text" name="txt_proname" id="txt_proname" value="<?php echo  $res_prod[0]['product_name'];?>">
						</div>
						<div class="clear"></div>
						<div class="box1">Product Category</div>
						<div class="dot">:</div>
						<div class="search1">
							<select id="sel_rootcatname" name="sel_rootcatname" class="text" onchange="showSubcat(this.value)">
								<option value="">--Select--</option>
								<?php foreach((array)$res_qry as $key => $value){ if($value['parent_id']=="" || $value['parent_id']=='0') {?>
								<option value="<?php echo $value['cat_id'];?>"><?php echo $value['cat_name'];?></option>
								<?php } } ?>
							</select>
							<script>populate_select('<?php echo $res_prod[0]["cat_id"];?>','sel_rootcatname');</script>
						</div>
						<div class="clear"></div>
						<?php if($_GET['id']!=""){?>
						<div id="subcatecory">
						<div class="box1">Sub Category</div>
						<div class="dot">:</div>
						<div class="search1" style="text-align: left;">
							<select id="sel_subcatname" name="sel_subcatname" class="text">
								<option value="0">--Select--</option>
								<?php foreach((array)$res_qry as $key => $value){ if($value['parent_id']!="" || $value['parent_id']!='0') {?>
								<option value="<?php echo $value["cat_id"];?>"><?php echo $value["cat_name"];?></option>
								<?php } } ?>
							</select>
							<script>populate_select('<?php echo $res_prod[0]["subcat_id"];?>','sel_subcatname');</script>
						</div>
						</div>
						<?php }?>
						<div id="subcatecory"></div>
						<div class="clear"></div>
						<div class="box1">Description</div>
						<div class="dot">:</div>
						<div class="search1">
							<textarea id="txt_desc" name="txt_desc" rows="10" cols="50"><?php echo stripslashes($res_prod[0]['product_short_desc']);?></textarea>
						</div>
						
						<div class="clear"></div>
						<div class="box1">Product Quantity</div>
						<div class="dot">:</div>
						<div class="search1">
							<input class="text" type="text" name="txt_quantity" id="txt_quantity" value="<?php echo  $res_prod[0]['product_qty'];?>" onkeypress="javascript: return isNumberKey(event);">
						</div>
						
						<div class="clear"></div>
						<div class="box1">Price</div>
						<div class="dot">: </div>
						<div class="search1">
							<input class="text" type="text" name="txt_price" id="txt_price" value="<?php echo $res_prod[0]['aprice'];?>"  onkeypress="javascript: return isNumberKey_price(event);">
						</div>
						<div class="clear"></div>
						<div class="box1">Special Price</div>
						<div class="dot">: </div>
						<div class="search1">
							<input class="text" type="text" name="txt_special_price" id="txt_special_price" value="<?php echo $res_prod[0]['sprice'];?>"  onkeypress="javascript: return isNumberKey_price(event);">
						</div>
						<div class="clear"></div>
						<?php if($_GET['id']!="" && $res_prod[0]['product_image']!=""){?>
						<div class="clear"></div>
						<div class="box1">Product Image</div>
						<div class="dot">:</div>
						<div class="search1" id="filehiding" >
							<a href='verylargeimage/<?php echo $res_prod[0]['product_image'];?>'><?php echo $res_prod[0]['product_image'];?></a> &nbsp;[<a href="#" id="cancelbutton4" onclick="javascript:$('#filehiding').hide();$('#cancelbutton4').hide();$('#butten').show();return false;">Cancel</a>]
						</div>
						<div id="butten" style="display:none; float:left;" class="search1"><input class="inputfile1" type="file" name="txt_product_image" id="txt_product_image" value=""></div>
						<?php }else{?>
						<div class="clear"></div>
						<div class="box1">Product Image</div>
						<div class="dot">:</div>
						<div class="search1" style="padding-left:12px;">
							<input class="inputfile1" type="file" name="txt_product_image" id="txt_product_image" value="">
						</div>
						<?php }?>
						
						
						<div class="clear"></div>
						<div class="box1">Rank</div>
						<div class="dot">:</div>
						<div class="search1">
							<input class="text" type="text" name="txt_rank" id="txt_rank" value="<?php echo  $res_prod[0]['rank'];?>" onkeypress="javascript: return isNumberKey(event);">
						</div>
						<div class="clear"></div>
						<div class="box1">Is Featured Product?</div>
						<div class="dot">:</div>
						<div class="search1" style="text-align: left;">
							<input type="checkbox" id="featurd_product" name="featured_product" value="1" <?php echo ($res_prod[0]["is_featured_product"]==1)?"checked":"";?>>
						</div>
						<div class="clear"></div>
						<div class="box1">Is Out of Stock?</div>
						<div class="dot">:</div>
						<div class="search1" style="text-align: left;">
							<input type="checkbox" id="chk_outof_stock" name="chk_outof_stock" value="1" <?php echo ($res_prod[0]["is_out_of_stock"]==1)?"checked":"";?>>
						</div>
						<div class="clear"></div>
						<div class="box1">Status</div>
						<div class="dot">:</div>
						<div class="search1" style="text-align: left;">
							<select id="sel_status" name="sel_status" class="text">
								<option value="">--Select--</option>
								<option value="0">Active</option>
								<option value="1">Inactive</option>
							</select>
							<script>populate_select('<?php echo $res_prod[0]["is_active"];?>','sel_status');</script>
						</div>
						<div class="pull-left">
							<input type="submit" class="login btn" value="<?php echo ($userobj->getVariable('id')=="")?"Add":"Update";?>" name="cmd_submit">
							<input type="button" class="login btn" name="btn_cancel" value="Cancel" onclick="javascript:window.location.href='manage_product.php';">
						</div>
					</div>
				</div>
			</form>
		</section>
		</div>
</div>
		<div id="clear">&nbsp;</div>
<?php include_once("footer1.php");?>