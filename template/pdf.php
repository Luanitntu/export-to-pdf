<?php if(isset($_POST['submit'])) {

    global $wpdb;

    $value=$_POST['submit'];

    $result=$wpdb->get_results("SELECT * FROM wp_order_status WHERE name like '$value'", OBJECT);

    $status=$result[0]->id;

    $chooses=$_POST['choose'];

    switch ($value) {

        case 'Delete': foreach($chooses as $choose) {

            $result=$wpdb->get_results("SELECT * FROM wp_order WHERE id = $choose", OBJECT);

            $idCustomer=$result[0]->idCustomer;

            // $wpdb->get_results("DELETE FROM wp_order WHERE id = $choose");

            $wpdb->get_results("UPDATE wp_order SET is_deleted = 1 WHERE id = $choose");

            // $wpdb->get_results("DELETE FROM wp_order_detail WHERE idOrder = $choose");

            // $wpdb->get_results("DELETE FROM wp_info_order WHERE id = $idCustomer");

            // $wpdb->get_results("DELETE FROM wp_order_extra WHERE idOrder = $choose");

        }

        break;

        case 'unpaid': foreach($chooses as $choose) {

            $wpdb->get_results("UPDATE wp_order SET order_status = $status WHERE id = $choose");

        }

        break;

        case 'paid': foreach($chooses as $choose) {

            $wpdb->get_results("UPDATE wp_order SET order_status = $status WHERE id = $choose");

        }

        break;

        case 'delivering': foreach($chooses as $choose) {

            $wpdb->get_results("UPDATE wp_order SET order_status = $status WHERE id = $choose");

        }

        break;

        case 'complete': foreach($chooses as $choose) {

            $wpdb->get_results("UPDATE wp_order SET order_status = $status WHERE id = $choose");

        }

        break;

    }

}

;



?><style>.tablenav-pages {

    color: #555;

    cursor: default;

    float: right;

    height: 28px;

    margin-top: 3px;

}

.tablenav {

    width: 99%;

}

.action input[type='submit'] {

    text-transform: capitalize;



}

.unpaid {

    background: #bf1e2e !important;

    border: 0px !important;

    color: #fff !important;

}

.paid {

    color: #fff !important;

    background: #42a2da !important;

    border: 0px !important;

}

.delivering {

    color: #fff !important;

    background: #dec649 !important;

    border: 0px !important;

}

.complete {

    color: #fff !important;

    background: #297b29 !important;

    border: 0px !important;

}

#bg_audio {

    opacity: 0;

}

/*css edit*/

.status4 {

    background-color: transparent;

}

.check-list {

    opacity: 0;

}



.check-btn span {

    border: 1px solid #544e4e;

    color: #555;

    clear: none;

    cursor: pointer;

    display: inline-block;

    line-height: 0;

    height: 12px;

    margin: -4px 4px 0 0;

    margin-top: -4px;

    margin-bottom: 0px;

    outline: 0;

    padding: 0 !important;

    text-align: center;

    vertical-align: middle;

    width: 12px;

    -webkit-appearance: none;

    -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);

    box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);

    -webkit-transition: .05s border-color ease-in-out;

    transition: .05s border-color ease-in-out;

    position: absolute;

    top: 16px;

    left: 10px;

    pointer-events: none;

}



.check-btn :checked+span {

    width: 12px;

    height: 12px;

}

.check-btn :checked+span:after {

    content: '\2714';

    font-size: 10px;

    position: absolute;

    top: 5px;

    left: 2px;

    color: #ffffff;

}

.check-btn {

    position: relative;

}



.check-btn.status4 span,
.check-btn.status4 :checked+span {

    background: #297b29;

}



.check-btn.status3 span,
.check-btn.status3 :checked+span {

    background: #dec649;

}



.check-btn.status2 span,
.check-btn.status2 :checked+span {

    background: #42a2da;

}



.check-btn.status1 span,
.check-btn.status1 :checked+span {

    background: #bf1e2e;

}



</style><h2>Order's Report</h2>
<?php global $wpdb;

$result=$wpdb->get_results("SELECT * From  wp_info_order join wp_order on wp_info_order.id = wp_order.idCustomer order by wp_info_order.id DESC", OBJECT);

$count=count($result);

$max=$wpdb->get_results("SELECT MAX(id) as max FROM wp_order ", OBJECT);

if(isset($_GET['paged'])) {

    $paged=$_GET['paged'];

}

else {

    $paged=1;

}

$post=15;

$count_page=ceil($count/$post);

$limit_post=($paged-1)*$post;

$result=$wpdb->get_results("SELECT * From  wp_info_order join wp_order on wp_info_order.id = wp_order.idCustomer order by wp_info_order.id DESC limit $limit_post, $post", OBJECT);

$i=$limit_post;

?>< !-- <input type="hidden"value="<?php // echo $max[0]->max; ?>"id="max">--><script>jQuery(document).ready(function() {



    // document.getElementById('bg_audio').play();





    // setInterval(function(){

    //   max = jQuery('#max').val();

    //   jQuery.ajax({

    //       type: "POST",

    //       data: {action : 'sb_test_ajax', max: max},

    //       url: "<?php // echo admin_url('admin-ajax.php'); ?>", 

    //       dataType: "text",    

    //       success: function(results)

    //       {

    //         // alert('success');

    //         // console.log(results);

    //         result = jQuery.parseJSON(results);

    //         if(result.check == 1){

    //           document.getElementById('bg_audio').play();

    //           setTimeout(function(){

    //             location.reload();

    //           }, 3000);

    //         }

    //       }

    //     });

    // }, 10000);

}

) </script>< !-- <audio controls id="bg_audio"><source src="<?php // echo bloginfo('template_directory'); ?>/lib/ring.mp3"type="audio/mpeg"></audio>--><form action=""method="post"><div class="action"><input type="submit"value="Delete"name="submit"id="doaction"class="button action"onclick="return confirm('Are you sure you want to delete this item?');"><?php $status=$wpdb->get_results("SELECT * From  wp_order_status", OBJECT);

foreach($status as $statu) {

    ?><input type="submit"value="<?php echo $statu->name; ?>"name="submit"id="doaction"class="button action <?php echo $statu->name; ?>"><?php
}

?></div><table style='width:99%; margin-top:20px;'class='wp-list-table widefat fixed striped posts'><thead><tr style='width:100%; '><td style='width:15px;'></td><td style='width:15px;'>#</td><td style='width:130px;'>Customer's Name</td>
<td style='width:100px;'>Phone</td><td style='width:100px;'>Order Type</td><td style='width:100px;'>Shipping Type</td><td style='width:100px;'>Ready Time</td><td style='width:150px;'>Created Time</td><td style='width:100px;'>Total </td><td style='width:120px;'>Action </td>< !--<td style='width:100px;'>Print</td>--></tr></thead><?php foreach($result as $row) {

    $total=0;

    $subtotal=0;

    $extra_price_total=0;

    // $order_detail = $wpdb->get_results("SELECT * From wp_order_detail join wp_order on wp_order.id = wp_order_detail.idOrder Where wp_order.id=".intval($row->id),OBJECT);

    $order_detail=$wpdb->get_results("SELECT * From  wp_order_detail where wp_order_detail.idOrder=".intval($row->id), OBJECT);

    foreach($order_detail as $order) {

        $orderId=$order->idOrder;

        $subtotal+=$order->price * $order->quanlity;

    }

    // print_r($order_detail);

    $extra_items=$wpdb->get_results("SELECT * From  wp_order_extra where wp_order_extra.idOrder=".$orderId, OBJECT);

    if( !empty($extra_items)) {

        foreach($extra_items as $extra_item) {

            $extra_price_total+=$extra_item->price;

        }

    }

    // print_r($extra_price_total);

    $tax=($subtotal + $extra_price_total) *8.1/100;

    $total=$subtotal+$tax+$extra_price_total;

    // $total = ($total*8.1)/100+$total;

    $date=new DateTime($row->created);

    ?><tr style='width:100%; border:1px solid #000;  margin-top: 20px; overflow: hidden;'><td style='width:10px;'class="<?php echo 'status'.$row->order_status; ?> check-btn"><input type="checkbox"value="<?php echo $row->id;?>"name="choose[]"class="check-list"><span></span></td><td style='width:20px;'><?php echo $row->id;
    ?></td><td style='width:100px;'><?php echo $row->name;
    ?></td><td style='width:100px;'><?php echo $row->tel;
    ?></td><td style='width:150px;'><?php echo $row->order_type;
    ?></td><td style='width:150px;'><?php echo $row->shipping_type;
    ?></td><td style='width:150px;'><?php echo $row->ready_time;
    ?></td><td style='width:100px;'><?php echo $date->format('M d, Y - H:i:s'); // $row->created; ?>
    </td><td><?php echo "$".number_format((float)$total, 2, '.', '');
    ?></td><td style='width:100px;'><a href="<?php echo plugin_dir_url( __FILE__ ).'pdf.php?id='.$row->id; ?>"TARGET="_blank">Export PDF & Print</a></td>< !--<td style='width:100px;'><a href="<?php echo plugin_dir_url( __FILE__ ).'print.php?id='.$row->id.'&print=true'; ?>"TARGET="_blank">Print</a></td>--></tr><?php
}

?></table></form><div class="tablenav bottom">< !-- <div class="alignleft actions bulkactions"><label for="bulk-action-selector-bottom"class="screen-reader-text">Select bulk action</label><select name="action2"id="bulk-action-selector-bottom"><option value="-1">Bulk Actions</option><option value="edit"class="hide-if-no-js">Edit</option><option value="trash">Move to Trash</option></select><input id="doaction2"class="button action"value="Apply"type="submit"></div>--><div class="alignleft actions"></div><?php if($count_page > 1): ?><div class="tablenav-pages"><span class="displaying-num"><?php echo $count;

?>items</span><?php if($paged==1) {
    ?><span class="pagination-links"><span class="tablenav-pages-navspan"aria-hidden="true">«</span><span class="tablenav-pages-navspan"aria-hidden="true">‹</span><?php
}

else {

    $lastpage=$paged -1;

    ?><a class="next-page"href="<?php echo admin_url( 'admin.php?page=order-report' );?>"><span class="screen-reader-text">Next page</span><span aria-hidden="true">«</span></a><a class="last-page"href="<?php echo admin_url('admin.php?page=order-report&paged='. $lastpage);?>"><span class="screen-reader-text">Last page</span><span aria-hidden="true">‹</span></a></span><?php
}

?><span class="screen-reader-text">Current Page</span><span id="table-paging"class="paging-input"><?php echo $paged;
?>of <span class="total-pages"><?php echo $count_page;

?></span></span><?php if($paged==$count_page) {
    ?><span class="pagination-links"><span class="tablenav-pages-navspan"aria-hidden="true">›</span><span class="tablenav-pages-navspan"aria-hidden="true">»</span><?php
}

else {

    $nextpage=$paged+1;

    ?><a class="next-page"href="<?php echo admin_url( 'admin.php?page=order-report&paged='.$nextpage );?>"><span class="screen-reader-text">Next page</span><span aria-hidden="true">›</span></a><a class="last-page"href="<?php echo admin_url( 'admin.php?page=order-report&paged='.$count_page);?>"><span class="screen-reader-text">Last page</span><span aria-hidden="true">»</span></a></span><?php
}

?></div><?php endif;
?><br class="clear"></div>