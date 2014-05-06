<?php
// key to authenticate
if (!defined('INDEX_AUTH')) {
  define('INDEX_AUTH', '1');
}
// key to get full database access
define('DB_ACCESS', 'fa');

include_once '../../sysconfig.inc.php';
// session checking
require SB.'admin/default/session.inc.php';
require SB.'admin/default/session_check.inc.php';

$time = date("Y-m-d");

$loan_q = $dbs->query("SELECT COUNT(loan_id) FROM loan WHERE loan_date LIKE '$time%'");
$loan_d = $loan_q->fetch_row();
echo $loan_d[0];