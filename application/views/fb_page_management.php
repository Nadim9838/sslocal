<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .sidebar ul li a.active {
        background: transparent;
    }
    #facebook_management {
        background-color: #eee;
    }
    .year-filter-container {
        text-align: right;
        margin-bottom: 10px;
    }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12"> 
                <h1 class="page-header"><i class="fa fa-facebook fa-fw"></i>Page Management<span style="float:right;"><button class="btn btn-outline btn-primary add_new">Add Facebook Page</button></span></h1>
                <div id="flash-message" style="">
                    <?php echo $this->session->flashdata('msg'); ?>  
                </div>

                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel"></h4>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger alert-dismissable error1" style="display:none;"></div>

                                <?php $data = array('role' => 'form');
                                echo form_open_multipart("home/add_update_facebook_page", $data); ?>

                                <div class="form-group">
                                    <label>Select Profile Id<span style="color:#FF0000;"><sup>*</sup></span></label>
                                    <select name="profile_id" id="profile_id" class="form-control profile_id" required>
                                        <option Selected value="">Select Profile Id</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Select Profile Name<span style="color:#FF0000;"><sup>*</sup></span></label>
                                    <select name="profile_name" id="profile_name" class="form-control profile_name" required>
                                        <option Selected value="">Select Profile Name</option>
                                    </select>
                                </div>

                                <div class="form-group">
									<label>Enter Page Name<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" name="page_name" id="page_name" class="form-control page_name" placeholder="Enter Page Name" required>
								</div>

                                <div class="form-group">
									<label>Enter Page Link<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" name="page_link" id="page_link" class="form-control page_link" placeholder="Enter Page Link" required>
								</div>

                                <div class="form-group">
									<label>Enter Page Category<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" name="page_category" id="page_category" class="form-control page_category" placeholder="Enter Page Category" required>
								</div>

                                <div class="form-group">
									<label>Enter Page Location<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" name="page_location" id="page_location" class="form-control page_location" placeholder="Enter Page Location" required>
								</div>

                                <div class="form-group">
									<label>Enter Page Followers<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" name="page_followers" id="page_followers" class="form-control page_followers" placeholder="Enter Page Followers" required>
								</div>

                                <div class="form-group">
									<label>Enter Page Permission<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" name="page_permissions" id="page_permissions" class="form-control page_permissions" placeholder="Enter Page Permission" required>
								</div>

                                <div class="form-group">
                                    <label>Select Status<span style="color:#FF0000;"><sup>*</sup></span></label>
                                    <select name="status" id="status" class="form-control status">
                                        <option Selected value="">Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <input type="hidden" name="sav-typ" class="sav-typ" value="">
                                <input type="hidden" name="id" class="id">
                            </div>

                            <div class="modal-footer">
                                <input type="submit" name="submit" class="btn btn-primary sav-chng" />
                            </div>
                            <?php echo form_close();  ?>
                        </div>
                    </div>
                </div>
                <!-- model end -->

                <!-- Show table list  -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        All Facebook Page List
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <!-- Year wise table data filtering -->
                            <div class="year-filter-container">
                                <label for="yearFilter">Filter by Year:</label>
                                <select id="yearFilter">
                                    <option value="">All</option>
                                    <?php 
                                        $years = []; 
                                        foreach ($result as $r) {
                                            $year = substr($r["date_time"], 0, 4);
                                            $years[] = $year;
                                        }
                                        $uniqueYears = array_unique($years);
                                        foreach($uniqueYears as $year) {
                                            echo '<option value="'.$year.'">'.$year.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <table class="table table-striped table-bordered table-hover dt-responsive text-center" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th class="text-center">Sl No.</th>
                                        <th class="text-center">Registered Date</th>
                                        <th class="text-center">Profile Id</th>
                                        <th class="text-center">Profile Name</th>
                                        <th class="text-center">Page Code</th>
                                        <th class="text-center">Page Name</th>
                                        <th class="text-center">Page Link</th>
                                        <th class="text-center">Page Category</th>
                                        <th class="text-center">Page Location</th>
                                        <th class="text-center">Page Followers</th>
                                        <th class="text-center">Page Permissions</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($result as $r) {
                                        $status = ($r["status"] == 1) ? 'Active' : 'Inactive';
                                        $createdAt = date('d/m/Y H:i:s', strtotime($r['date_time']));
                                        echo "<tr>";
										echo "";
										echo "<td>" . ++$i . "</td>";
										echo "<td class='date_time'>" . $createdAt . "</td>";
										echo "<td class='profile_id'>" . $r["profile_id"] . "</td>";
										echo "<td class='profile_name'>" . $r["profile_name"] . "</td>";
										echo "<td class='account_id'>FBG00" . $r["id"] ."</td>";
										echo "<td class='page_name'>" . $r["page_name"] . "</td>";
										echo "<td class='page_link'>" . $r["page_link"] . "</td>";
										echo "<td class='page_category'>" . $r["page_category"] . "</td>";
										echo "<td class='page_location'>" . $r["page_location"] . "</td>";
										echo "<td class='page_followers'>" . $r["page_followers"] . "</td>";
										echo "<td class='page_permissions'>" . $r["page_permissions"] . "</td>";
                                        echo "<td class='status'>" . $status . "</td>";
										echo "<td><a class=\"fa fa-pencil fa-fw editcap\" id='{$r['id']}' href='#'></a>&nbsp;&nbsp;&nbsp;<a class=\"fa fa-trash-o fa-fw delcap\" href='#' id='{$r['id']}'></a></td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<script>
    // Data table attributes
    $('#dataTables-example').dataTable({
        dom: 'Bfrtip',
        buttons: ['copy', 'excel', 'pdf'],
        columnDefs: [{
            width: 'auto',
            targets: 12
        }],
        "ordering": true,
        buttons: true,
        "pageLength": 15,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "text":['center'],
        "scrollX": true
    });

    // Delete the facebook page
    $(".delcap").on('click', function() {
        var uid = $(this).attr('id');
        $.confirm({
            text: "Are you sure you want to delete this facebook page?",
            confirm: function(button) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . "home/delete_facebook_page/"; ?>" + uid,
                    success: function(data) {
                        if (data == '1') {
                            document.location.href = '<?php echo base_url() . "home/fb_page_management"; ?>';
                        } else {
                            document.location.href = '<?php echo base_url() . "home/fb_page_management"; ?>';
                        }
                    }
                });
            },
            cancel: function(button) {
                return false;
            }
        });
    });

    // Edit the facebook page details
    $('a.editcap').on('click', function() {
        $('#status').closest('.form-group').show();
		var myModal = $('#myModal');
		// Now get the values from the table
		var id = $(this).attr('id');
		var profile_id = $(this).closest('tr').find('td.profile_id').html();
		var profile_name = $(this).closest('tr').find('td.profile_name').html();
		var account_id = $(this).closest('tr').find('td.account_id').html();
		var page_name = $(this).closest('tr').find('td.page_name').html();
		var page_link = $(this).closest('tr').find('td.page_link').html();
		var page_category = $(this).closest('tr').find('td.page_category').html();
		var page_location = $(this).closest('tr').find('td.page_location').html();
		var page_followers = $(this).closest('tr').find('td.page_followers').html();
		var page_permissions = $(this).closest('tr').find('td.page_permissions').html();
		var status = $(this).closest('tr').find('td.status').html();
        var statusValue = (status === "Active") ? "1" : "0";
        // Set them in the modal
		$('.profile_id', myModal).val(profile_id);
		$('.profile_name', myModal).val(profile_name);
		$('.account_id', myModal).val(account_id);
		$('.page_name', myModal).val(page_name);
		$('.page_link', myModal).val(page_link);
		$('.page_category', myModal).val(page_category);
		$('.page_location', myModal).val(page_location);
		$('.page_followers', myModal).val(page_followers);
		$('.page_permissions', myModal).val(page_permissions);
		$('.status', myModal).val(statusValue);
		$('.sav-typ', myModal).val('edit');
		$('.id', myModal).val(id);
		$(".error1", myModal).css("display", "none");
		$("#myModalLabel").text("Edit Facebook Page Details");

		// Show the modal
		myModal.modal({
			show: true
		});

		return false;
	});

    // Add new facebook page
    $('button.add_new').on('click', function() {
        $('#status').closest('.form-group').hide();
        var myModal1 = $('#myModal');
        $('.profile_id', myModal).val('');
		$('.profile_name', myModal).val('');
		$('.account_id', myModal).val('');
		$('.page_name', myModal).val('');
		$('.page_link', myModal).val('');
		$('.page_category', myModal).val('');
		$('.page_location', myModal).val('');
		$('.page_followers', myModal).val('');
		$('.page_permissions', myModal).val('');
		$('.status', myModal).val('');
        $('.id', myModal1).val('0');
        $('.sav-typ', myModal1).val('new');
        $(".error1", myModal1).css("display", "none");
        myModal1.modal({
            show: true
        });
        $("#myModalLabel").text("Add Facebook Page Details");
        return false;
    });

    $(document).ready(function(){
        // Show facebook account id
        $('#profile_id').select2({
            placeholder: "Select Profile Id",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#profile_id').parent(),
            ajax: {
                url: '<?php echo base_url(); ?>home/fetch_all_facebook_account_details',
                dataType: 'json',
                delay: 2000,
                data: function (params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.account_id,
                                text: item.account_id 
                            };
                        })
                    };
                },
                cache: true
            }
        });

        // Show facebook profile name
        $('#profile_name').select2({
            placeholder: "Select Profile Name",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#profile_id').parent(),
            ajax: {
                url: '<?php echo base_url(); ?>home/fetch_all_facebook_account_details',
                dataType: 'json',
                delay: 2000,
                data: function (params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.name, 
                                text: item.name
                            };
                        })
                    };
                },
                cache: true
            }
        });

        $('.account-select').select2({
            placeholder: "Select Profile Name",
            allowClear: true
        });

        // Outside the modal not clickable 
        $('#myModal').modal({
        backdrop: 'static',
        keyboard: false,
        show: false
        });

        // Year wise filtering
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var selectedYear = $('#yearFilter').val(); 
                var dateTime = data[1];
                if (!dateTime) return false;
                
                var year = dateTime.substring(6, 10);
                // Compare the extracted year with the selected year
                if (selectedYear === "" || year === selectedYear) {
                    return true;
                }
                return false;
            }
        );
        var table = $('#dataTables-example').DataTable();
        // Event listener to the year filter dropdown
        $('#yearFilter').on('change', function() {
            table.draw();
        });
    });
</script>

</body>
</html>