<?php
// key to authenticate
if (!defined('INDEX_AUTH')) {
  define('INDEX_AUTH', '1');
}
// key to get full database access
define('DB_ACCESS', 'fa');

include_once '../sysconfig.inc.php';
// session checking
require SB.'admin/default/session.inc.php';
require SB.'admin/default/session_check.inc.php';

$time = date("Y-m-d");

$_visitor_q = $dbs->query("SELECT COUNT(visitor_id) FROM visitor_count WHERE checkin_date LIKE '$time%'");
$_visitor_d = $_visitor_q->fetch_row();
echo $_visitor_d[0];