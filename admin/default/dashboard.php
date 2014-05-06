<?php
// IP based access limitation
require LIB.'ip_based_access.inc.php';
do_checkIP('smc');
do_checkIP('smc-reporting');
// start the session
require SB.'admin/default/session_check.inc.php';
// privileges checking
$can_read = utility::havePrivilege('reporting', 'r');
$can_write = utility::havePrivilege('reporting', 'w');

if (!$can_read) {
    die('<div class="alert alert-danger">'.__('You don\'t have enough privileges to access this area!').'</div>');
}

require SIMBIO.'simbio_GUI/form_maker/simbio_form_element.inc.php';
?>
<div class="row r-margin">
    <div class="col-md-12">
        <div class="d-container">
            <div class="col-md-3 col-sm-3">
                <a href="<?php echo MWB.'reporting/customs/visitor_list.php';?>">
                <div class="w-box">
                    <div class="w-left bg-success">
                        <i class="fa fa-sign-in"></i>
                    </div>
                    <div class="w-right">
                        <p class="w-value" id="w-visitor"><i>Loading ...</i></p>
                        <p class="w-key">Visitors</p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-3">
                <a href="<?php echo MWB.'reporting/loan_report.php'; ?>">
                <div class="w-box">
                    <div class="w-left bg-info">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="w-right">
                        <p class="w-value" id="w-loan"><i>Loading ...</i></p>
                        <p class="w-key">Loans</p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="w-box">
                    <div class="w-left bg-warning">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="w-right">
                        <p class="w-value">80<span class="w-unit">%</span></p>
                        <p class="w-key">Text</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3">
                <a href="<?php echo MWB.'reporting/customs/overdued_list.php';?>">
                <div class="w-box">
                    <div class="w-left bg-danger">
                        <i class="fa fa-warning"></i>
                    </div>
                    <div class="w-right">
                        <p class="w-value"><?php echo $num_overdue;?></p>
                        <p class="w-key">overdue</p>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-8 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o"></i> Visitor Graph <?php echo date("Y"); ?>
                </div>
                <div class="panel-body">
                    <div id="visit-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o"></i> <?php echo __('Collection Statistic'); ?>
                </div>
                <div class="panel-body">
                    <div id="col_type"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// months array    
    for($a = 1; $a <= 12; $a++){
        if($a < 10){
            $a = '0'.$a;
        }else{
            $a;
        }
        $months[] = date("Y-").$a;
    }
    
// get member type data from databse
    $_q = $dbs->query("SELECT member_type_id, member_type_name FROM mst_member_type LIMIT 100");
    while ($_d = $_q->fetch_row()) {
        $member_types[$_d[0]] = $_d[1];
    }
    $selected_member_type = $member_types;
    $outvisit = '';
    foreach ($months as $month_num => $month) {
        $outvisit .= '{';
        $outvisit .= 'period:\''.$month.'\',';
        foreach ($selected_member_type as $id => $member_type) {
            $sql_str = "SELECT COUNT(visitor_id) FROM visitor_count AS vc
                INNER JOIN (member AS m LEFT JOIN mst_member_type AS mt ON m.member_type_id=mt.member_type_id) ON m.member_id=vc.member_id
                WHERE m.member_type_id=$id AND vc.checkin_date LIKE '$month-%'";
            $visitor_q = $dbs->query($sql_str);
            $visitor_d = $visitor_q->fetch_row();
            $outvisit .= '\''.$member_type.'\':'.$visitor_d[0].',';
        }
        $outvisit .= '},';
    }
    $ykeys = '';
    foreach ($member_types as $item) {
        $ykeys .= '\'';
        $ykeys .= $item;
        $ykeys .= '\',';
    }
    
    // total items by Collection Type
    $stat_query = $dbs->query('SELECT coll_type_name, COUNT(item_id) AS total_items
        FROM `item` AS i
        INNER JOIN mst_coll_type AS ct ON i.coll_type_id = ct.coll_type_id
        GROUP BY i.coll_type_id
        HAVING total_items >0
        ORDER BY COUNT(item_id) DESC');
    $stat_data = '';
    while ($data = $stat_query->fetch_row()) {
        $stat_data .= '{';
        $stat_data .= 'value: '.$data[1].', label: \''.$data[0].'\'';
        $stat_data .= '},';
    }
?>
<script type="text/javascript">
    $(document).ready(function(){
        // get data with ajax
        setInterval(function(){
            $.get('default/visitor.php', function(data) {
                $('#w-visitor').html(data);
            });
            $.get('default/loan.php', function(data) {
                $('#w-loan').html(data);
            });
        }, 3000); //time to reload data (milisecond)
        Morris.Area({
            element: 'visit-chart',
            data: [<?php echo $outvisit; ?>],
            xkey: 'period',
            ykeys: [<?php echo $ykeys; ?>],
            labels: [<?php echo $ykeys; ?>],
            pointSize: 0,
            hideHover: 'auto',
            lineColors: ['#ff7857', '#fdd761', '#7acbee', '#3FB8AF', '#D4EE5E', '#F2D694', '#DD7D27', '#2FCE03'],
            fillOpacity: 0.75,
            lineWidth: 0,
            resize: true
        });
        Morris.Donut({
            element: 'col_type',
            data: [<?php echo $stat_data; ?>],
            backgroundColor: '#fff',
            labelColor: '#060',
            colors: ['#ff7857', '#fdd761', '#7acbee', '#3FB8AF', '#D4EE5E', '#F2D694', '#DD7D27', '#2FCE03'],
            formatter: function (x) { return x + " item"}
        });
    });        
</script>
<script src="<?php echo ATD; ?>js/plugins/morris/raphael-2.1.0.min.js"></script>
<script src="<?php echo ATD; ?>js/plugins/morris/morris.js"></script>