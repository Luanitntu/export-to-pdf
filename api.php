<?php

function add_submenu_options()

{

    add_menu_page("Order's Report", "Order's Report", "edit_posts", 'order-report', 'access_menu_options','',4 );

}

// Thêm hành động hiển thị menu con vào Action admin_menu Hooks

add_action('admin_menu', 'add_submenu_options');

function access_menu_options(){

	require "template/theme-option.php";

}?>