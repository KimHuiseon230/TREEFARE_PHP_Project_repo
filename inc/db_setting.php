<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/create_table.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/create_table_data.php";

create_table($conn, 'member');
create_table($conn, 'message');
create_table($conn, 'image_board');
create_table($conn, 'image_board_ripple');
create_table($conn, 'product');
create_table($conn, 'cart');
create_table($conn, 'notice');

insert_table_data($conn, 'member');
insert_table_data($conn, 'message');
insert_table_data($conn, 'image_board');
insert_table_data($conn, 'image_board_ripple');
insert_table_data($conn, 'product');
// insert_table_data($conn, 'cart');
insert_table_data($conn, 'notice');
