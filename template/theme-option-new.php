<?php

  if(isset($_POST['submit'])){

    global $wpdb; 

    $value = $_POST['submit'];

    $result = $wpdb->get_results("SELECT * FROM wp_order_status WHERE name like '$value'",OBJECT);

    $status = $result[0]->id;

    $chooses = $_POST['choose'];

    switch ($value) {

      case 'Delete': 

         foreach($chooses as $choose){

            $result = $wpdb->get_results("SELECT * FROM wp_order WHERE id = $choose",OBJECT);

            $idCustomer = $result[0]->idCustomer;

            $wpdb->get_results("DELETE FROM wp_order WHERE id = $choose");

            $wpdb->get_results("DELETE FROM wp_order_detail WHERE idOrder = $choose");

            $wpdb->get_results("DELETE FROM wp_info_order WHERE id = $idCustomer");

         } 

        break;

      case 'unpaid':

       foreach($chooses as $choose){

          $wpdb->get_results("UPDATE wp_order SET order_status = $status WHERE id = $choose");

         }

         break;

      case 'paid':

         foreach($chooses as $choose){

          $wpdb->get_results("UPDATE wp_order SET order_status = $status WHERE id = $choose");

         }

        break;

      case 'delivering':

         foreach($chooses as $choose){

          $wpdb->get_results("UPDATE wp_order SET order_status = $status WHERE id = $choose");

         }

        break;  

      case 'complete':

         foreach($chooses as $choose){

          $wpdb->get_results("UPDATE wp_order SET order_status = $status WHERE id = $choose");

         }

        break;

    }

  };



?>
<style>
    .tablenav-pages{

    color: #555;

    cursor: default;

    float: right;

    height: 28px;

    margin-top: 3px;

   }

   .tablenav{

      width: 99%;

   }

   .action input[type='submit']{

      text-transform: capitalize;

      

   }

   .unpaid,.status1{

      background:#bf1e2e !important;

      border: 0px !important;

      color:#fff !important;

   }

   .paid, .status2{

      color:#fff !important;

      background:#42a2da !important;

      border: 0px !important;

   }

   .delivering, .status3{

      color:#fff !important;

      background:#dec649 !important;

      border: 0px !important;

   }

   .complete,.status4{

      color:#fff !important;

      background:#297b29 !important;

      border: 0px !important;

   }

</style>
<h2>Order's Report</h2>
<?php

   global $wpdb;   

      $result = $wpdb->get_results("SELECT * From  wp_info_order join wp_order on wp_info_order.id = wp_order.idCustomer order by wp_info_order.id DESC",OBJECT);

      $count = count($result);

      if(isset($_GET['paged'])){

         $paged = $_GET['paged'];

      }else{

         $paged = 1;

      }

      $post = 15;

      $count_page = ceil($count/$post);

      $limit_post = ($paged-1)*$post;

      $result = $wpdb->get_results("SELECT * From  wp_info_order join wp_order on wp_info_order.id = wp_order.idCustomer order by wp_info_order.id DESC limit $limit_post, $post",OBJECT);

      $i=$limit_post;



?>
<form action="" method="post">
    <div class="action">
        <input type="submit" value="Delete" name="submit" id="doaction" class="button action" onclick="return confirm('Are you sure you want to delete this item?');">
        <?php 

         $status = $wpdb->get_results("SELECT * From  wp_order_status",OBJECT);

         foreach($status as $statu){

       ?>
        <input type="submit" value="<?php echo $statu->name; ?>" name="submit" id="doaction" class="button action <?php echo $statu->name; ?>">
        <?php } ?>
    </div>
    <table style='width:99%; margin-top:20px;' class='wp-list-table widefat fixed striped posts'>
        <thead>
            <tr style='width:100%; '>
                <td style='width:15px;'></td>
                <td style='width:130px;'>Customer's Name</td>
                <td style='width:100px;'>Phone</td>
                <td style='width:100px;'>Order Type</td>
                <td style='width:100px;'>Ready Time</td>
                <td style='width:150px;'>Created Time</td>
                <td style='width:130px;'>Payment method</td>
                <td style='width:100px;'>Total </td>
                <td style='width:120px;'>Action </td>
                <!--<td style='width:100px;'>Print</td>-->
            </tr>
        </thead>
        <?php

      foreach($result as $row){

          $total = 0;

         $order_detail = $wpdb->get_results("SELECT * From  wp_order_detail join wp_order on wp_order.id = wp_order_detail.idOrder Where wp_order.id=".intval($row->id),OBJECT);

         foreach($order_detail as $order){

            $total += $order->price*$order->quanlity;

         }

         $total = ($total*8.1)/100+$total;

         ?>
        <tr style='width:100%; border:1px solid #000;  margin-top: 20px; overflow: hidden;'>
            <td style='width:10px; '><input type="checkbox" value="<?php echo $row->id;?>" name="choose[]" class="<?php echo 'status'.$row->order_status; ?>"></td>
            <td style='width:100px;'>
                <?php echo $row->name; ?>
            </td>
            <td style='width:100px;'>
                <?php echo $row->tel; ?>
            </td>
            <td style='width:150px;'>
                <?php echo $row->order_type; ?>
            </td>
            <td style='width:150px;'>
                <?php echo $row->ready_time; ?>
            </td>
            <td style='width:100px;'>
                <?php echo $row->created; ?>
            </td>
            <td style='width:100px;'>
                <?php echo $row->payment; ?>
            </td>
            <td>
                <?php echo "$".number_format((float)$total, 2, '.', ''); ?>
            </td>
            <td style='width:100px;'><a href="<?php echo plugin_dir_url( __FILE__ ).'pdf.php?id='.$row->id; ?>" TARGET="_blank">Export PDF & Print</a></td>
            <!--<td style='width:100px;'><a href="<?php echo plugin_dir_url( __FILE__ ).'print.php?id='.$row->id.'&print=true'; ?>" TARGET="_blank">Print</a></td>-->
        </tr>
        <?php



      



      }

?>
    </table>
</form>
<div class="tablenav bottom">
    <!-- <div class="alignleft actions bulkactions">

                     <label for="bulk-action-selector-bottom" class="screen-reader-text">Select bulk action</label><select name="action2" id="bulk-action-selector-bottom">

            <option value="-1">Bulk Actions</option>

               <option value="edit" class="hide-if-no-js">Edit</option>

               <option value="trash">Move to Trash</option>

            </select>

            <input id="doaction2" class="button action" value="Apply" type="submit">

                  </div> -->
    <div class="alignleft actions">
    </div>
    <?php if($count_page > 1): ?>
    <div class="tablenav-pages"><span class="displaying-num">
            <?php echo $count; ?> items</span>
        <?php if($paged==1){ ?>
        <span class="pagination-links"><span class="tablenav-pages-navspan" aria-hidden="true">«</span>
            <span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
            <?php

             }else{

               $lastpage = $paged -1;

             ?>
            <a class="next-page" href="<?php echo admin_url( 'admin.php?page=order-report' );?>"><span class="screen-reader-text">Next page</span><span aria-hidden="true">«</span></a>
            <a class="last-page" href="<?php echo admin_url('admin.php?page=order-report&paged='. $lastpage);?>"><span class="screen-reader-text">Last page</span><span aria-hidden="true">‹</span></a></span>
        <?php

          }

          ?>
        <span class="screen-reader-text">Current Page</span><span id="table-paging" class="paging-input">
            <?php echo $paged; ?> of <span class="total-pages">
                <?php echo $count_page; ?></span></span>
        <?php if($paged==$count_page){ ?>
        <span class="pagination-links"><span class="tablenav-pages-navspan" aria-hidden="true">›</span>
            <span class="tablenav-pages-navspan" aria-hidden="true">»</span>
            <?php

             }else{

               $nextpage = $paged+1;

             ?>
            <a class="next-page" href="<?php echo admin_url( 'admin.php?page=order-report&paged='.$nextpage );?>"><span class="screen-reader-text">Next page</span><span aria-hidden="true">›</span></a>
            <a class="last-page" href="<?php echo admin_url( 'admin.php?page=order-report&paged='.$count_page);?>"><span class="screen-reader-text">Last page</span><span aria-hidden="true">»</span></a></span>
        <?php

          }

          ?>
    </div>
    <?php endif; ?>
    <br class="clear">
</div>