<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<style>
    .sidebar ul li a.active {
        background: transparent;
    }
    #user_management {
        background-color: #eee;
    }
    .hidden {
        display: none;
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
                <h1 class="page-header"><i class="fa fa-user fa-fw"></i>&nbsp;User Management<span style="float:right;"><button class="btn btn-outline btn-primary add_new">Add User</button></span></h1>
                <div id="flash-message" style="">
                    <?php echo $this->session->flashdata('msg'); ?>  
                </div>
                <!-- Modal -->

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
                                echo form_open_multipart("home/add_update_user", $data); ?>

                                <div class="form-group">
									<label>Enter Name<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" id="name" name="name" class="form-control name" placeholder="Enter User Name" required>
								</div>

                                <div class="form-group">
									<label>Enter Email<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="email" id="email" name="email" class="form-control email" placeholder="Enter User Email" required>
								</div>

                                <div class="form-group">
									<label>Enter Mobile<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="number" id="mobile" name="mobile" class="form-control mobile" placeholder="Enter User Mobile No." required>
								</div>

                                <div class="form-group">
                                    <label>Select User Status<span style="color:#FF0000;"><sup>*</sup></span></label>
                                    <select name="status" id="status" class="form-control status" required>
                                        <option selected value="">Select User Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <div class="form-group">
									<label>Enter Password<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="password" id="password" name="password" class="form-control password" placeholder="Enter User Password" required>
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
                <!-- Add user model end -->

                <!--User Permissions Model -->
                <div class="modal fade" id="userPermissionsModal" tabindex="-1" role="dialog" aria-labelledby="permissionModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" id="userCancleModel" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="permissionModalLabel">Set User Permissions</h4>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger alert-dismissable error1" style="display:none;"></div>
                                <div class="form-group">
                                <form action="" id="permissionsForm">
                                <input type="hidden" id="user_id" name="user_id">
                                <table class="table table-striped table-bordered table-hover dt-responsive text-center">
                                <thead>
                                    <tr>
                                        <th class="text-center">Permissions</th>
                                        <th class="text-center">View</th>
                                        <th class="text-center">Add</th>
                                        <th class="text-center">Edit</th>
                                        <th class="text-center">Delete</th>
                                        <th class="text-center">All</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Dashboard</td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[dashboard][view]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[dashboard][add]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[dashboard][edit]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[dashboard][delete]"></td>
                                        <td><input type="checkbox" class="all-checkbox" name="permissions[dashboard][all]"></td>
                                    </tr>
                                    <tr>
                                        <td>User Managemant</td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[user_management][view]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[user_management][add]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[user_management][edit]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[user_management][delete]"></td>
                                        <td><input type="checkbox" class="all-checkbox" name="permissions[user_management][all]"></td>
                                    </tr>
                                    <tr>
                                        <td>Mobile Managemant</td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[mobile_management][view]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[mobile_management][add]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[mobile_management][edit]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[mobile_management][delete]"></td>
                                        <td><input type="checkbox" class="all-checkbox" name="permissions[mobile_management][all]"></td>
                                    </tr>
                                    <tr>
                                        <td>Facebook Management</td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[facebook_management][view]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[facebook_management][add]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[facebook_management][edit]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[facebook_management][delete]"></td>
                                        <td><input type="checkbox" class="all-checkbox" name="permissions[facebook_management][all]"></td>
                                    </tr>
                                    <tr>
                                        <td>Instagram Management</td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[insta_management][view]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[insta_management][add]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[insta_management][edit]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[insta_management][delete]"></td>
                                        <td><input type="checkbox" class="all-checkbox" name="permissions[insta_management][all]"></td>
                                    </tr>
                                    <tr>
                                        <td>Twitter Management</td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[twitter_management][view]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[twitter_management][add]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[twitter_management][edit]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[twitter_management][delete]"></td>
                                        <td><input type="checkbox" class="all-checkbox" name="permissions[twitter_management][all]"></td>
                                    </tr>
                                    <tr>
                                        <td>Youtube Management</td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[youtube_management][view]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[youtube_management][add]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[youtube_management][edit]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[youtube_management][delete]"></td>
                                        <td><input type="checkbox" class="all-checkbox" name="permissions[youtube_management][all]"></td>
                                    </tr>
                                    <tr>
                                        <td>Tik Tok Management</td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[tiktok_management][view]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[tiktok_management][add]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[tiktok_management][edit]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[tiktok_management][delete]"></td>
                                        <td><input type="checkbox" class="all-checkbox" name="permissions[tiktok_management][all]"></td>
                                    </tr>
                                    <tr>
                                        <td>WhatsApp Management</td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[whatsapp_management][view]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[whatsapp_management][add]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[whatsapp_management][edit]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[whatsapp_management][delete]"></td>
                                        <td><input type="checkbox" class="all-checkbox" name="permissions[whatsapp_management][all]"></td>
                                    </tr>
                                    <tr>
                                        <td>Report</td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[report][view]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[report][add]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[report][edit]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[report][delete]"></td>
                                        <td><input type="checkbox" class="all-checkbox" name="permissions[report][all]"></td>
                                    </tr>
                                    <tr>
                                        <td>Setting</td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[settings][view]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[settings][add]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[settings][edit]"></td>
                                        <td><input type="checkbox" class="perm-checkbox" name="permissions[settings][delete]"></td>
                                        <td><input type="checkbox" class="all-checkbox" name="permissions[settings][all]"></td>
                                    </tr>
                                </tbody>
                            </table>
								</div>

                                <input type="hidden" name="sav-typ" class="sav-typ" value="">
                                <input type="hidden" name="id" class="id">
                            </div>

                            <div class="modal-footer">
                                <input type="submit" name="submit" id="savePermissionsBtn" value="Save" class="btn btn-primary sav-chng" />
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End model of permission -->
                 
                <!-- Show table list -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        User Permissions List
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
                                        <th class="text-center">Created At</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Mobile</th>
                                        <th class="text-center hidden">Password</th>
                                        <th class="text-center">Permissions</th>
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
										echo "<td class='createdAt'>" . $createdAt . "</td>";
										echo "<td class='name'>" . $r["name"] . "</td>";
										echo "<td class='email'>" . $r["email"] . "</td>";
										echo "<td class='mobile'>" . $r["mobile"] . "</td>";
                                        echo "<td class='password hidden'>" . $r["password"] . "</td>";
										echo "<td class='add text-center'><button class='user_rights' data-id='{$r['id']}'>Set Rights</button></td>";
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
        buttons: [
            {
                extend: 'copy',
                exportOptions: {
                    columns: ':visible:not(:last-child)'
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:not(:last-child)'
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':visible:not(:last-child)',
                    orientation: 'landscape',
                    pageSize: 'A4'
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:not(:last-child)',
                    pageSize: 'A4'
                }
            }
        ],
        columnDefs: [{
            width: '18%',
            targets: 3
        }],
        ordering: true,
        pageLength: 15,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        scrollX: true
    });

    // Delete the user
    $(".delcap").on('click', function() {
        var uid = $(this).attr('id');
        $.confirm({
            text: "Are you sure you want to delete this user?",
            confirm: function(button) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . "home/delete_user/"; ?>" + uid,
                    success: function(data) {
                        if (data == '1') {
                            document.location.href = '<?php echo base_url() . "home/user_management"; ?>';
                        } else {
                            document.location.href = '<?php echo base_url() . "home/user_management"; ?>';
                        }
                    }
                });
            },
            cancel: function(button) {
                return false;
            }
        });
    });

    // Edit the user
    $('a.editcap').on('click', function() {
		var myModal = $('#myModal');
		// now get the values from the table
		var id = $(this).attr('id');
		var name = $(this).closest('tr').find('td.name').html();
		var mobile = $(this).closest('tr').find('td.mobile').html();
		var email = $(this).closest('tr').find('td.email').html();
		var status = $(this).closest('tr').find('td.status').html();
		var password = $(this).closest('tr').find('td.password').html();
        var statusValue = (status === "Active") ? "1" : "0";

        // and set them in the modal
		$('.name', myModal).val(name);
		$('.email', myModal).val(email);
		$('.mobile', myModal).val(mobile);
		$('.status', myModal).val(statusValue);
		$('.password', myModal).val(password);
		$('.sav-typ', myModal).val('edit');
		$('.id', myModal).val(id);
		$(".error1", myModal).css("display", "none");
		$("#myModalLabel").text("Edit User");

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
        $('.status', myModal1).val('');
        $('.id', myModal1).val('0');
        $('.sav-typ', myModal1).val('new');
        $(".error1", myModal1).css("display", "none");
        myModal1.modal({
            show: true
        });
        $("#myModalLabel").text("Add User");
        return false;
    });

    // Get user permissions
    $(document).ready(function() {
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
                    $('#userPermissionsModal').modal('show');
                }
            });
        });

        // Save user Permissions
        $('#savePermissionsBtn').click(function() {
            var formData = $('#permissionsForm').serialize();
            $.ajax({
                url: '<?= base_url("home/set_user_permissions") ?>',
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#userPermissionsModal').modal('hide');
                }
            });
        });
    });

</script>

</body>
</html>