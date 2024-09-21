<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<style>
    .sidebar ul li a.active {
        background: transparent;
    }
    #facebook_management {
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
                <h1 class="page-header"><i class="fa fa-facebook fa-fw"></i>Facebook Management<span style="float:right;"><button class="btn btn-outline btn-primary add_new">Add Facebook Account</button></span></h1>
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
                                echo form_open_multipart("home/add_update_facebook", $data); ?>

                                <div class="form-group">
									<label>Enter Name<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" id="name" name="name" class="form-control name" placeholder="Enter Name" required>
								</div>

                                <div class="form-group">
									<label>Enter Profile Link<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" id="profile_link" name="profile_link" class="form-control profile_link" placeholder="Enter Profile Link" required>
								</div>

                                <div class="form-group">
									<label>Enter Facebook Id<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" id="facebook_id" name="facebook_id" class="form-control facebook_id" placeholder="Enter Facebook Id" required>
								</div>

                                <div class="form-group">
									<label>Enter Password<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="password" id="password" name="password" class="form-control password" placeholder="Enter Password" required>
								</div>

                                <div class="form-group">
									<label>Enter Mobile Number<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="number" id="mobile" name="mobile" maxlength="10" class="form-control mobile" placeholder="Enter Facebook Id" required>
								</div>

                                <div class="form-group">
									<label>Enter Email Id<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="email" id="email" name="email" class="form-control email" placeholder="Enter Facebook Id" required>
								</div>

                                <div class="form-group">
                                    <label>Select Gender<span style="color:#FF0000;"><sup>*</sup></span></label>
                                    <select name="gender" id="gender" class="form-control gender">
                                        <option Selected value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Enter Date of Birth<span style="color:#FF0000;"><sup>*</sup></span></label>
                                    <input type="date" id="dob" name="dob" class="form-control dob" placeholder="Enter Date DOB" required>
                                </div>

                                <div class="form-group">
									<label>Enter Location<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" id="location" name="location" class="form-control location" placeholder="Enter Location" required>
								</div>
                                
                                <div class="form-group">
									<label>Enter City<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" id="city" name="city" class="form-control city" placeholder="Enter City" required>
								</div>

                                <div class="form-group">
									<label>Enter State<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" id="state" name="state" class="form-control state" placeholder="Enter State" required>
								</div>

                                <div class="form-group">
									<label>Enter No. of Friends<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="number" id="friends" name="friends" class="form-control friends" placeholder="Enter No. of Friends" required>
								</div>

                                <div class="form-group">
                                    <label>Selec Status<span style="color:#FF0000;"><sup>*</sup></span></label>
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
                        All Facebook Accounts List
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dt-responsive text-center" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th class="text-center">Sl No.</th>
                                        <th class="text-center">Registered Date</th>
                                        <th class="text-center">Account Code</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Profile Link</th>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Password</th>
                                        <th class="text-center">Mobile No.</th>
                                        <th class="text-center">Email ID</th>
                                        <th class="text-center">Gender</th>
                                        <th class="text-center">Religion</th>
                                        <th class="text-center">DOB</th>
                                        <th class="text-center">Age</th>
                                        <th class="text-center">Location</th>
                                        <th class="text-center">City</th>
                                        <th class="text-center">State</th>
                                        <th class="text-center">Friends</th>
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
										echo "<td class='id'>FB00" . $r["id"] ."</td>";
										echo "<td class='name'>" . $r["name"] . "</td>";
										echo "<td class='profile_link'>" . $r["profile_link"] . "</td>";
										echo "<td class='facebook_id'>" . $r["facebook_id"] . "</td>";
										echo "<td class='password'>" . $r["password"] . "</td>";
										echo "<td class='mobile'>" . $r["mobile"] . "</td>";
										echo "<td class='email'>" . $r["email"] . "</td>";
										echo "<td class='gender'>" . $r["gender"] . "</td>";
										echo "<td class='religion'>" . $r["religion"] . "</td>";
										echo "<td class='dob'>" . $r["dob"] . "</td>";
										echo "<td class='age'>" . $r["age"] . "</td>";
										echo "<td class='location'>" . $r["location"] . "</td>";
										echo "<td class='city'>" . $r["city"] . "</td>";
										echo "<td class='state'>" . $r["state"] . "</td>";
										echo "<td class='friends'>" . $r["friends"] . "</td>";
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

    // Delete the facebook accounts
    $(".delcap").on('click', function() {
        var uid = $(this).attr('id');
        $.confirm({
            text: "Are you sure you want to delete this facebook account?",
            confirm: function(button) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . "home/delete_facebook/"; ?>" + uid,
                    success: function(data) {
                        if (data == '1') {
                            document.location.href = '<?php echo base_url() . "home/facebook_management"; ?>';
                        } else {
                            document.location.href = '<?php echo base_url() . "home/facebook_management"; ?>';
                        }
                    }
                });
            },
            cancel: function(button) {
                return false;
            }
        });
    });

    // Edit the facebook
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
		$("#myModalLabel").text("Edit Facebook Account Details");

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
        $('.facebook', myModal1).val('');
        $('.password', myModal1).val('');
        $('.id', myModal1).val('0');
        $('.sav-typ', myModal1).val('new');
        $(".error1", myModal1).css("display", "none");
        myModal1.modal({
            show: true
        });
        $("#myModalLabel").text("Add Facebook Details");
        return false;
    });

</script>

</body>
</html>