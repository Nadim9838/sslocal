<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<style>
    .sidebar ul li a.active {
        background: transparent;
    }
    #mobile_management {
        background-color: #eee;
    }
    .hidden {
        display: none;
    }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12"> 
                <h1 class="page-header"><i class="fa fa-mobile fa-fw"></i>Mobile Management<span style="float:right;"><button class="btn btn-outline btn-primary add_new">Add Mobile</button></span></h1>
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
                                echo form_open_multipart("home/add_update_mobile", $data); ?>

                                <div class="form-group">
									<label>Enter Company & Model<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" id="company_model" name="company_model" class="form-control company_model" placeholder="Enter Company & Model" required>
								</div>

                                <div class="form-group">
									<label>Enter Android Version<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" id="android_version" name="android_version" class="form-control android_version" placeholder="Enter Android Version" required>
								</div>

                                <div class="form-group">
									<label>Enter IMEI Number<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" id="imei_number" name="imei_number" maxlength="15" class="form-control imei_number" placeholder="Enter IMEI Number" required>
								</div>

                                <div class="form-group">
                                    <label>Select Mobile Status<span style="color:#FF0000;"><sup>*</sup></span></label>
                                    <select name="status" id="status" class="form-control status">
                                        <option Selected value="">Select Mobile Status</option>
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

                <!--Add Social Media Accounts Model -->
                <div class="modal fade" id="social_accounts" tabindex="-1" role="dialog" aria-labelledby="permissionModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" id="userCancleModel" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="permissionModalLabel">Add Social Media Accounts</h4>
                            </div>
                            <div class="modal-body">
                              <div class="alert alert-danger alert-dismissable error1" style="display:none;"></div>
                              <form action="" id="socialMediaForm">
                                <div class="form-group form-control">
                                    <input type="hidden" id="user_id" name="user_id">
                                    <label>Select Social Media Plateform<span style="color:#FF0000;"><sup>*</sup></span></label>
                                    <select name="status" id="status">
                                        <option value="facebook">Facebook</option>
                                        <option value="instagram">Instagram</option>
                                        <option value="twitter">Twitter</option>
                                        <option value="youtube">Youtube</option>
                                        <option value="tiktok">Tik Tok</option>
                                        <option value="whatsapp">WhatsApp</option>
                                    </select>
                                    <label>Select Accounts<span style="color:#FF0000;"><sup>*</sup></span></label>
                                    <select name="accounts" id="accounts">
                                        <option value="facebook">Account1</option>
                                        <option value="instagram">Account2</option>
                                        <option value="twitter">Account3</option>
                                        <option value="youtube">Account4</option>
                                        <option value="tiktok">Account5</option>
                                        <option value="whatsapp">Account6</option>
                                    </select>
                                    <button>+</button>
                                </div>

                                <input type="hidden" name="sav-typ" class="sav-typ" value="">
                                <input type="hidden" name="id" class="id">
                            </div>
                            <div class="modal-footer">
                                <input type="submit" name="submit" id="saveAccountsBtn" value="Save" class="btn btn-primary sav-chng" />
                            </div>
                          </form>
                        </div>
                    </div>
                </div>
                <!-- model end -->

                <!-- Show table list  -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        All Mobiles List
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dt-responsive text-center" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th class="text-center">Sl No.</th>
                                        <th class="text-center">Registered Date</th>
                                        <th class="text-center">Mobile Id</th>
                                        <th class="text-center">Company & Model</th>
                                        <th class="text-center">Android Version</th>
                                        <th class="text-center">IMEI Number</th>
                                        <th class="text-center">No. of Social Media Accounts</th>
                                        <th class="text-center">Validate</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($result as $r) {
                                        $status = ($r["status"] == 1) ? 'Active' : 'Inactive';
                                        echo "<tr>";
										echo "";
										echo "<td>" . ++$i . "</td>";
										echo "<td class='date_time'>" . $r["date_time"] . "</td>";
										echo "<td class='id'>Mob" . $r["id"] ."</td>";
										echo "<td class='company_model'>" . $r["company_model"] . "</td>";
										echo "<td class='android_version'>" . $r["android_version"] . "</td>";
										echo "<td class='imei_number'>" . $r["imei_number"] . "</td>";
										echo "<td class='add text-center'><button class='user_rights' data-id='{$r['id']}'>Add Social Accounts</button></td>";
										echo "<td class='add text-center'><button class='user_rights' data-id='{$r['id']}'>Validate Accounts</button></td>";
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

    // Delete the mobile
    $(".delcap").on('click', function() {
        var uid = $(this).attr('id');
        $.confirm({
            text: "Are you sure you want to delete this mobile?",
            confirm: function(button) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . "home/delete_mobile/"; ?>" + uid,
                    success: function(data) {
                        if (data == '1') {
                            document.location.href = '<?php echo base_url() . "home/mobile_management"; ?>';
                        } else {
                            document.location.href = '<?php echo base_url() . "home/mobile_management"; ?>';
                        }
                    }
                });
            },
            cancel: function(button) {
                return false;
            }
        });
    });

    // Edit the mobile
    $('a.editcap').on('click', function() {
		var myModal = $('#myModal');
		// now get the values from the table
		var id = $(this).attr('id');
		var company_model = $(this).closest('tr').find('td.company_model').html();
		var android_version = $(this).closest('tr').find('td.android_version').html();
		var imei_number = $(this).closest('tr').find('td.imei_number').html();
		var status = $(this).closest('tr').find('td.status').html();
        var statusValue = (status === "Active") ? "1" : "0";
        // and set them in the modal
		$('.company_model', myModal).val(company_model);
		$('.android_version', myModal).val(android_version);
		$('.imei_number', myModal).val(imei_number);
		$('.status', myModal).val(statusValue);
		$('.sav-typ', myModal).val('edit');
		$('.id', myModal).val(id);
		$(".error1", myModal).css("display", "none");
		$("#myModalLabel").text("Edit Mobile Details");

		// and finally show the modal
		myModal.modal({
			show: true
		});

		return false;
	});

    // Add new users
    $('button.add_new').on('click', function() {
        var myModal1 = $('#myModal');
        $('.name', myModal1).val('');
        $('.email', myModal1).val('');
        $('.mobile', myModal1).val('');
        $('.password', myModal1).val('');
        $('.id', myModal1).val('0');
        $('.sav-typ', myModal1).val('new');
        $(".error1", myModal1).css("display", "none");
        myModal1.modal({
            show: true
        });
        $("#myModalLabel").text("Add Mobile Details");
        return false;
    });

    // Get user permissions
    $(document).ready(function() {
        // Functionality when 'All' checkbox is clicked
        $('.all-checkbox').change(function() {
            var isChecked = $(this).is(':checked');
            // Check/uncheck all permission checkboxes in the same row
            $(this).closest('tr').find('.perm-checkbox').prop('checked', isChecked);
        });

        // Functionality when any individual permission checkbox is clicked
        $('.perm-checkbox').change(function() {
            var row = $(this).closest('tr');
            var allChecked = row.find('.perm-checkbox:checked').length === row.find('.perm-checkbox').length;
            
            // If all individual checkboxes are checked, check the 'All' checkbox
            row.find('.all-checkbox').prop('checked', allChecked);
        });

        // When cancle user model referesh the page
        $('#userCancleModel').click(function() {
            location.reload();
        });

        // Open Set Rights Modal
        $('.user_rights').click(function() {
            var userId = $(this).data('id');
            $('#user_id').val(userId);

            // Fetch current permissions
            $.ajax({
                url: '<?= base_url("home/get_user_permissions/") ?>' + userId,
                method: 'GET',
                success: function(response) {
                    var permissions = JSON.parse(response);
                    // Update checkbox values based on the fetched permissions
                    $.each(permissions, function(index, perm) {
                        var row = $('input[name="permissions['+ perm.permission +'][add]"]').closest('tr');

                        row.find('input[name="permissions['+ perm.permission +'][add]"]').prop('checked', perm.add == 1);
                        row.find('input[name="permissions['+ perm.permission +'][view]"]').prop('checked', perm.view == 1);
                        row.find('input[name="permissions['+ perm.permission +'][edit]"]').prop('checked', perm.edit == 1);
                        row.find('input[name="permissions['+ perm.permission +'][delete]"]').prop('checked', perm.delete == 1);

                        // Check if all permissions (Add, View, Edit, Delete) are checked, then check the 'All' checkbox
                        var allChecked = row.find('.perm-checkbox:checked').length === row.find('.perm-checkbox').length;
                        row.find('.all-checkbox').prop('checked', allChecked);
                    });
                    // Show the modal
                    $('#social_accounts').modal('show');
                }
            });
        });

        // Save user Permissions
        $('#saveAccountsBtn').click(function() {
            var formData = $('#socialMediaForm').serialize();
            $.ajax({
                url: '<?= base_url("home/set_user_permissions") ?>',
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#social_accounts').modal('hide');
                }
            });
        });
    });

</script>

</body>
</html>