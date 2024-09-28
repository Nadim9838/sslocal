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
                <h1 class="page-header"><i class="fa fa-facebook fa-fw"></i>Account Management<span style="float:right;"><button class="btn btn-outline btn-primary add_new">Add Facebook Account</button></span></h1>
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
                                echo form_open_multipart("home/add_update_fb_account", $data); ?>

                                <div class="form-group">
									<label>Enter Facebook Account Name<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" name="name" id="name" class="form-control name" placeholder="Enter Facebook Account Name" required>
								</div>

                                <div class="form-group">
									<label>Enter Facebook Account Link<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" name="profile_link" id="profile_link" class="form-control profile_link" placeholder="Enter Facebook Account Link" required>
								</div>

                                <div class="form-group">
									<label>Enter Facebook Account Id<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" name="account_id" id="account_id" class="form-control account_id" placeholder="Enter Facebook Account Id" required>
								</div>

                                <div class="form-group">
									<label>Enter Facebook Account Password<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="password" name="password" id="password" class="form-control password" placeholder="Enter Facebook Account Password" required>
								</div>

                                <div class="form-group">
									<label>Enter Mobile Number<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="number" name="mobile"id="mobile" class="form-control mobile" placeholder="Enter Mobile Number" required>
								</div>

                                <div class="form-group">
									<label>Enter Email Id<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="email" name="email" id="email" class="form-control email" placeholder="Enter Email Id" required>
								</div>

                                <div class="form-group">
                                    <label>Select Gender<span style="color:#FF0000;"><sup>*</sup></span></label>
                                    <select name="gender" id="gender" class="form-control gender" required>
                                        <option Selected value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div class="form-group">
									<label>Enter Religion<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" id="religion" name="religion" class="form-control religion" placeholder="Enter Religion" required>
								</div>

                                <div class="form-group">
									<label>Enter Cast<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" id="cast" name="cast" class="form-control cast" placeholder="Enter Cast" required>
								</div>
                                
                                <div class="form-group">
                                    <label>Enter Date of Birth<span style="color:#FF0000;"><sup>*</sup></span></label>
                                    <input type="date" name="dob" id="dob" class="form-control dob" placeholder="Enter Date of Birth" required>
                                </div>

                                <div class="form-group">
                                    <label>Enter Age<span style="color:#FF0000;"><sup>*</sup></span></label>
                                    <input type="number" name="age" id="age" readonly class="form-control age" placeholder="Enter age" required>
                                </div>

                                <div class="form-group">
									<label>Enter Location<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" name="location" id="location" class="form-control location" placeholder="Enter Location" required>
								</div>
                                
                                <div class="form-group">
									<label>Enter City<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" name="city" id="city" class="form-control city" placeholder="Enter City" required>
								</div>

                                <div class="form-group">
									<label>Enter State<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="text" name="state" id="state" class="form-control state" placeholder="Enter State" required>
								</div>

                                <div class="form-group">
									<label>Enter No. of Friends<span style="color:#FF0000;"><sup>*</sup></span></label>
									<input type="number" name="friends" id="friends" class="form-control friends" placeholder="Enter No. of Friends" required>
								</div>

                                <div class="statusField">

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
                        All Facebook Accounts List
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
                                        <th class="text-center">Account Code</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Profile Link</th>
                                        <th class="text-center">Account ID</th>
                                        <th class="text-center">Password</th>
                                        <th class="text-center">Mobile No.</th>
                                        <th class="text-center">Email ID</th>
                                        <th class="text-center">Gender</th>
                                        <th class="text-center">Religion</th>
                                        <th class="text-center">Cast</th>
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
                                        $createdAt = date('d/m/Y H:i:s', strtotime($r['date_time']));
                                        echo "<tr>";
										echo "";
										echo "<td>" . ++$i . "</td>";
										echo "<td class='date_time'>" . $createdAt . "</td>";
										echo "<td class='id'>FB00" . $r["id"] ."</td>";
										echo "<td class='name'>" . $r["name"] . "</td>";
										echo "<td class='profile_link'>" . $r["profile_link"] . "</td>";
										echo "<td class='account_id'>" . $r["account_id"] . "</td>";
										echo "<td class='password'>" . $r["password"] . "</td>";
										echo "<td class='mobile'>" . $r["mobile"] . "</td>";
										echo "<td class='email'>" . $r["email"] . "</td>";
										echo "<td class='gender'>" . $r["gender"] . "</td>";
										echo "<td class='religion'>" . $r["religion"] . "</td>";
										echo "<td class='cast'>" . $r["cast"] . "</td>";
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

    // Delete the facebook accounts
    $(".delcap").on('click', function() {
        var uid = $(this).attr('id');
        $.confirm({
            text: "Are you sure you want to delete this facebook account?",
            confirm: function(button) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . "home/delete_fb_account/"; ?>" + uid,
                    success: function(data) {
                        if (data == '1') {
                            document.location.href = '<?php echo base_url() . "home/fb_account_management"; ?>';
                        } else {
                            document.location.href = '<?php echo base_url() . "home/fb_account_management"; ?>';
                        }
                    }
                });
            },
            cancel: function(button) {
                return false;
            }
        });
    });

    // Edit the facebook account details
    $('a.editcap').on('click', function() {
		var myModal = $('#myModal');
        $('#status').closest('.form-group').show();
		// now get the values from the table
		var id = $(this).attr('id');
		var name = $(this).closest('tr').find('td.name').html();
		var profile_link = $(this).closest('tr').find('td.profile_link').html();
		var account_id = $(this).closest('tr').find('td.account_id').html();
		var password = $(this).closest('tr').find('td.password').html();
		var mobile = $(this).closest('tr').find('td.mobile').html();
		var email = $(this).closest('tr').find('td.email').html();
		var gender = $(this).closest('tr').find('td.gender').html();
		var religion = $(this).closest('tr').find('td.religion').html();
		var cast = $(this).closest('tr').find('td.cast').html();
		var dob = $(this).closest('tr').find('td.dob').html();
		var age = $(this).closest('tr').find('td.age').html();
		var location = $(this).closest('tr').find('td.location').html();
		var city = $(this).closest('tr').find('td.city').html();
		var state = $(this).closest('tr').find('td.state').html();
		var friends = $(this).closest('tr').find('td.friends').html();
		var status = $(this).closest('tr').find('td.status').html();
        var statusValue = (status === "Active") ? "1" : "0";
        // and set them in the modal
		$('.name', myModal).val(name);
		$('.profile_link', myModal).val(profile_link);
		$('.account_id', myModal).val(account_id);
		$('.password', myModal).val(password);
		$('.mobile', myModal).val(mobile);
		$('.email', myModal).val(email);
		$('.gender', myModal).val(gender);
		$('.religion', myModal).val(religion);
		$('.cast', myModal).val(cast);
		$('.dob', myModal).val(dob);
		$('.age', myModal).val(age);
		$('.location', myModal).val(location);
		$('.city', myModal).val(city);
		$('.state', myModal).val(state);
		$('.friends', myModal).val(friends);
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

    // Add new facebook account
    $('button.add_new').on('click', function() {
        $('#status').closest('.form-group').hide();
        var myModal1 = $('#myModal');
        $('.name', myModal).val('');
		$('.profile_link', myModal).val('');
		$('.account_id', myModal).val('');
		$('.password', myModal).val('');
		$('.mobile', myModal).val('');
		$('.email', myModal).val('');
		$('.gender', myModal).val('');
		$('.religion', myModal).val('');
		$('.cast', myModal).val('');
		$('.dob', myModal).val('');
		$('.age', myModal).val('');
		$('.location', myModal).val('');
		$('.city', myModal).val('');
		$('.state', myModal).val('');
		$('.friends', myModal).val('');
		$('.status', myModal).val('');
        $('.id', myModal1).val('0');
        $('.sav-typ', myModal1).val('new');
        $(".error1", myModal1).css("display", "none");
        myModal1.modal({
            show: true
        });
        $("#myModalLabel").text("Add Facebook Account Details");
        return false;
    });

    $(document).ready(function(){
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

        // Get age according to the date of birth
        $('#dob').on('change', function(){
            var dob = new Date($(this).val());
            var today = new Date();
            var age = today.getFullYear() - dob.getFullYear();
            var monthDiff = today.getMonth() - dob.getMonth();
            
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            $('#age').val(age);
        });
    });
</script>

</body>
</html>