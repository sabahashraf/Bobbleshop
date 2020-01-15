<?php
session_start();

if (isset($_GET['id'])) {

    //connect to database
    $mysqli = mysqli_connect("localhost", "root", "", "bobbleshop");
	
	$get_cart_sql = "SELECT st.id, si.item_title,si.cur_quant,si.id, si.item_price, st.sel_item_qty,  st.sel_item_id FROM store_shoppertrack AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE session_id = '".$_COOKIE["PHPSESSID"]."'";
	$get_cart_res = mysqli_query($mysqli, $get_cart_sql) or die(mysqli_error($mysqli));
	
	    while ($cart_info = mysqli_fetch_array($get_cart_res)) {
   	    $id = $cart_info['id'];
   	   
		$new_qty = $cart_info['cur_quant']+$cart_info['sel_item_qty'];
   	   
		$sess_id = $_COOKIE['PHPSESSID'];
		
		
		$update_quant = "UPDATE store_items SET cur_quant = '".$new_qty."'where'".$id."' = store_items.id";
		$get_update_res = mysqli_query($mysqli, $update_quant) or die(mysqli_error($mysqli));


    }
    //create safe values for use
    $safe_id = mysqli_real_escape_string($mysqli, $_GET['id']);
	
    $delete_item_sql = "DELETE FROM store_shoppertrack WHERE id = '".$safe_id."' and session_id = '".$_COOKIE['PHPSESSID']."'";
    $delete_item_res = mysqli_query($mysqli, $delete_item_sql) or die(mysqli_error($mysqli));

	//close connection to MySQL
	mysqli_close($mysqli);

    //redirect to showcart page
    header("Location: bhshowcart.php");
    exit;

} else {
    //send them somewhere else
    header("Location: collections.php");
    exit;
}
?>