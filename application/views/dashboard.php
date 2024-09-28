<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<head>
        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?php echo base_url(); ?>assets/header/js/plugins/metisMenu/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->
        <script src="<?php echo base_url(); ?>assets/header/js/plugins/morris/raphael.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/header/js/plugins/morris/morris.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/header/js/plugins/morris/morris-data.js"></script>

</head>
<style>
    .sidebar ul li a.active {
        background: transparent;
    }
    #dashboard {
        background-color: #eee;
    }
</style>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Automation Dashboard!</h1>
        </div>
        <div class="col-lg-12">
            <div id="reportrange" class="pull-right" style="background: #0088CC; color:#fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                <span></span> <b class="caret"></b>
            </div>
            <div class="col-lg-12">
                <br />
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-facebook fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" id="app_rec">

                            </div>
                            <div>Facebook</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-twitter fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" id="site_vis">

                            </div>
                            <div>Twitter</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-instagram fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" id="prp_val">

                            </div>
                            <div>Instagram</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-youtube fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" id="rep_sent"></div>
                            <div>Youtube</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Average Automation
                </div>
                <div class="panel-body">
                    <div id="morris-area-chart"></div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        var cb = function(start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        var optionSet1 = {
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            minDate: '01/01/2012',
            maxDate: '12/31/2020',
            dateLimit: {
                days: 180
            },
            showDropdowns: true,
            showWeekNumbers: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'left',
            buttonClasses: ['btn btn-default'],
            applyClass: 'btn-small btn-primary',
            cancelClass: 'btn-small',
            format: 'MM/DD/YYYY',
            separator: ' to ',
            locale: {
                applyLabel: 'Submit',
                cancelLabel: 'Clear',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
        };

        var optionSet2 = {
            startDate: moment().subtract(7, 'days'),
            endDate: moment(),
            opens: 'left',
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        };

        $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

        $('#reportrange').daterangepicker(optionSet1, cb);

        $('#reportrange').on('show.daterangepicker', function() {
            console.log("show event fired");
        });
        $('#reportrange').on('hide.daterangepicker', function() {
            console.log("hide event fired");
        });
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {

            $.ajax({
                type: "POST",
                url: "ajax.php",
                data: {
                    dt1: picker.startDate.format('YYYY-MM-DD'),
                    dt2: picker.endDate.format('YYYY-MM-DD'),
                },
                success: function(data, textStatus) {
                    var obj = JSON.parse(data);
                    $("#app_rec").html(obj.app_received);
                    $("#site_vis").html(obj.sites_visited);
                    $("#prp_val").html(obj.prop_valuated);
                    $("#rep_sent").html(obj.reports_sent);
                }
            });
            console.log("apply event fired, start/end dates are " +
                picker.startDate.format('MDY') +
                " to " +
                picker.endDate.format('YY-MM-DD')
            );
        });
        $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
            console.log("cancel event fired");
        });

    });
</script>

</body>
</html>