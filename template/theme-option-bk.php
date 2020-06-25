<?php



	global $wpdb;



   	$result = $wpdb->get_results("SELECT * From  wp_info_order join wp_order on wp_info_order.id = wp_order.idCustomer order by wp_info_order.id DESC",OBJECT);

//echo '<pre>';

//print_r($result);

//die;



   	echo "<table style='width:95%; margin-top:40px;' class='wp-list-table widefat fixed striped posts'>";



   	$i=0;



?>



	<thead>



   	<tr style='width:100%; '>



   				<td style='width:10px;'></td>



   				<td style='width:100px;'>Customer's Name</td>



   				<td style='width:100px;'>Phone</td>



   				<td style='width:150px;'>Order Type</td>



   				<td style='width:150px;'>Ready Time</td>



   				<td style='width:100px;'>Created Time</td>



                                <td style='width:100px;'>Payment method</td>



   				<td style='width:100px;'>Action</td>

                                 

                                <!--<td style='width:100px;'>Print</td>-->



   			</tr>



   </thead>			



<?php



   	foreach($result as $row){



   		?>



   			<tr style='width:100%; border:1px solid #000;  margin-top: 20px; overflow: hidden;'>



   				<td style='width:10px; '><?php echo ++$i; ?></td>



   				<td style='width:100px;'><?php echo $row->name; ?></td>



   				<td style='width:100px;'><?php echo $row->tel; ?></td>



   				<td style='width:150px;'><?php echo $row->order_type; ?></td>



   				<td style='width:150px;'><?php echo $row->ready_time; ?></td>



   				<td style='width:100px;'><?php echo $row->created; ?></td>



                                <td style='width:100px;'><?php echo $row->payment; ?></td>



   				<td style='width:100px;'><a href="<?php echo plugin_dir_url( __FILE__ ).'pdf.php?id='.$row->id; ?>" TARGET="_blank">Export PDF & Print</a></td>

               <!--<td style='width:100px;'><a href="<?php echo plugin_dir_url( __FILE__ ).'print.php?id='.$row->id.'&print=true'; ?>" TARGET="_blank">Print</a></td>-->

   			</tr>



<?php



   	



   	}



   		echo "</table>";



?>



