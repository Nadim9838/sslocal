<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .sidebar ul li a.active {
        background: transparent;
    }
    #mobile_management {
        background-color: #eee;
    }
    .year-filter-container {
        text-align: right;
        margin-bottom: 10px;
    }
    #account-fields-container .form-group {
        margin-bottom: 5px !important;
    }
    #account-fields-container .form-group .child-plateform {
        padding-right:20px !important;
    }
    .select2-results {
        max-height: 100px;
        overflow-y: auto;
    }
    .account-select {
        width: 150px !important;
    }
    .social-modal-footer {
        padding: 90px 0px 0px 0px !important;
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
                                <button type="button" class="close" id="userCancleModal" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="permissionModalLabel">View & Add Social Media Accounts</h4>
                            </div>
                            <div class="modal-body">
                              <div class="alert alert-danger alert-dismissable error1" style="display:none;"></div>
                              <?php echo form_open('home/save_mobile_accounts', ['id'=>'socialMediaForm', 'class'=>'form-inline']); ?>
                                <div id="account-fields-container">
                                <input type="hidden" id="mobile_id" name="mobile_id" class="mobile_id">
                              </div>
                              <div class="modal-footer social-modal-footer">
                                <input type="submit" name="submit" id="saveAccountsBtn" style="margin-left:200px;" value="Save" class="btn btn-primary sav-chng" />
                              </div>
                            </div>
                            <?php echo form_close();?>
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
                                        <th class="text-center">Mobile Id</th>
                                        <th class="text-center">Company & Model</th>
                                        <th class="text-center">Android Version</th>
                                        <th class="text-center">IMEI Number</th>
                                        <th class="text-center">Facebook</th>
                                        <th class="text-center">Instagram</th>
                                        <th class="text-center">Twitter</th>
                                        <th class="text-center">YouTube</th>
                                        <th class="text-center">TikTok</th>
                                        <th class="text-center">WhatsApp</th>
                                        <th class="text-center">Social Media Accounts</th>
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
                                        $createdAt = date('d/m/Y H:i:s', strtotime($r['date_time']));
                                        echo "<tr>";
										echo "";
										echo "<td>" . ++$i . "</td>";
										echo "<td class='date_time'>" . $createdAt . "</td>";
										echo "<td class='id'>Mob" . $r["id"] ."</td>";
										echo "<td class='company_model'>" . $r["company_model"] . "</td>";
										echo "<td class='android_version'>" . $r["android_version"] . "</td>";
										echo "<td class='imei_number'>" . $r["imei_number"] . "</td>";
                                        echo "<td class='facebook'>".$totalFacebookAccount."</td>";
                                        echo "<td class='instagram'>0</td>";
                                        echo "<td class='twitter'>0</td>";
                                        echo "<td class='youtube'>0</td>";
                                        echo "<td class='tiktok'>0</td>";
                                        echo "<td class='whatsapp'>0</td>";
										echo "<td class='add text-center'><button class='add_social_account' id='{$r['id']}'>Add Social Accounts</button></td>";
										echo "<td class='add text-center'><button class='validate_accounts' id='{$r['id']}'>Validate Accounts</button></td>";
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

    // Delete the mobile details
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

    // Edit the mobile details
    $('a.editcap').on('click', function() {
        $('#status').closest('.form-group').show();
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

    // Add new mobile details
    $('button.add_new').on('click', function() {
        $('#status').closest('.form-group').hide();
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

    $(document).ready(function() {
        // Outside the modal not clickable 
        $('#myModal').modal({
            backdrop: 'static',
            keyboard: false,
            show: false
        });

        // Outside the social account modal not clickable 
        $('#social_accounts').modal({
            backdrop: 'static',
            keyboard: false,
            show: false
        });

        // Relode the page when close the model
        $('#userCancleModal').click(function() {
            location.reload();
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

        // Open add social media account modal
        $('.add_social_account').click(function() {
            var id = $(this).attr('id');
            var social_account_model = $('#social_accounts');
            social_account_model.find('#mobile_id').val(id);

            // Fetch saved data via AJAX
            $.ajax({
                url: '<?php echo base_url(). "home/get_saved_social_media_accounts" ?>',
                type: 'POST',
                data: { mobile_id: id },
                dataType: 'json',
                success: function (response) {
                    // Populate the modal with saved accounts
                    if (response && response.saved_accounts.length > 0) {
                        response.saved_accounts.forEach(function (account, index) {
                            var savedAccountFields = `
                                <div class="form-group">
                                    <select name="platform[]" class="form-control platform-select" required>
                                        <option value="">Select Social Media Platform</option>
                                        <option value="facebook" ${account.platform === 'facebook' ? 'selected' : ''}>Facebook</option>
                                        <option value="instagram" ${account.platform === 'instagram' ? 'selected' : ''}>Instagram</option>
                                        <option value="twitter" ${account.platform === 'twitter' ? 'selected' : ''}>Twitter</option>
                                        <option value="youtube" ${account.platform === 'youtube' ? 'selected' : ''}>YouTube</option>
                                    </select>
                                    <select name="app_series[]" class="form-control app-series-select" required>
                                        <option value="">Select App Series</option>
                                        <option value="${account.app_series}" selected>${account.app_series}</option>
                                    </select>
                                    <select name="accounts[]" class="form-control account-select" required>
                                        <option value="">Select Account</option>
                                        <option value="${account.account}" selected>${account.account}</option>
                                    </select>
                                    ${
                                        index === 0
                                            ? `<button type="button" class="btn btn-secondary addFieldBtn" style="padding: 6px 13px; background-color: green; color: white;">+</button>
                                            <button type="button" title="Blank the current field"style="padding: 6px 6px;" class="removeFieldBtn btn btn-danger">-</button>`
                                            : `<button type="button" class="btn btn-danger removeFieldBtn" style="padding: 6px 20px; color: white;">-</button>`
                                    }
                                </div>
                            `;
                            $('#account-fields-container').append(savedAccountFields);
                        });
                    } else {
                        // If no saved accounts, add an empty first row with "+" button
                        addNewAccountRow();
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching saved accounts:', error);
                }
            });
            // Show the modal
            $('#social_accounts').modal('show');
        });

        // Function to add a new account row
        function addNewAccountRow() {
            var newAccountFields = `
                <div class="form-group mt-5">
                    <select name="platform[]" class="form-control platform-select" required>
                        <option value="" selected>Select Social Media Platform</option>
                        <option value="facebook">Facebook</option>
                        <option value="instagram">Instagram</option>
                        <option value="twitter">Twitter</option>
                        <option value="youtube">YouTube</option>
                    </select>
                    <select name="app_series[]" class="form-control app-series-select" required>
                        <option value="" selected>Select App Series</option>
                    </select>
                    <select name="accounts[]" class="form-control account-select" required>
                        <option value="" selected>Select Account</option>
                    </select>
                    <button type="button" class="btn btn-secondary addFieldBtn" style="padding: 6px 20px; background-color: green; color: white;">+</button>
                </div>
            `;
            // Append the new fields to the container
            $('#account-fields-container').append(newAccountFields);
        }

        // Add new fields when + button is clicked
        $('#account-fields-container').on('click', '.addFieldBtn', function () {
            var newAccountFields = `
                <div class="form-group mt-5">
                    <select name="platform[]" class="form-control platform-select" required>
                        <option value="" selected>Select Social Media Platform</option>
                        <option value="facebook">Facebook</option>
                        <option value="instagram">Instagram</option>
                        <option value="twitter">Twitter</option>
                        <option value="youtube">YouTube</option>
                    </select>
                    <select name="app_series[]" class="form-control app-series-select" required>
                        <option value="" selected>Select App Series</option>
                    </select>
                    <select name="accounts[]" class="form-control account-select" required>
                        <option value="" selected>Select Account</option>
                    </select>
                    <button type="button" class="btn btn-danger removeFieldBtn" style="padding: 6px 20px; color: white;">-</button>
                </div>
            `;

            // Append the new fields to the container
            $('#account-fields-container').append(newAccountFields);
        });

        // Remove fields and delete the record when - button is clicked
        $('#account-fields-container').on('click', '.removeFieldBtn', function () {

            var $formGroup = $(this).closest('.form-group');
            var accountId = $formGroup.find('.account-select').val();
            var platform = $formGroup.find('.platform-select').val();
            if (accountId) {
                $.ajax({
                    url: '<?php echo base_url(). "home/delete_social_media_account" ?>',
                    type: 'POST',
                    data: { id: accountId, platform: platform},
                    success: function(response) {
                        if (response) {
                            $formGroup.remove();
                        } else {
                            alert('Failed to delete the account.');
                        }
                    },
                    error: function() {
                        alert('Error deleting account.');
                    }
                });
            } else {
                $formGroup.remove();
            }
        });

        // Show app series list
        var appSeriesOptions = {
            facebook: [
                { value: 'facebook1', text: 'Facebook1' },
                { value: 'facebook2', text: 'Facebook2' }
            ],
            instagram: [
                { value: 'instagram1', text: 'Instagram1' },
                { value: 'instagram2', text: 'Instagram2' }
            ],
            twitter: [
                { value: 'twitter1', text: 'Twitter1' },
                { value: 'twitter2', text: 'Twitter2' }
            ],
            youtube: [
                { value: 'youtube1', text: 'YouTube1' },
                { value: 'youtube2', text: 'YouTube2' }
            ],
            tiktok: [
                { value: 'tiktok1', text: 'TikTok1' },
                { value: 'tiktok2', text: 'TikTok2' }
            ],
            whatsapp: [
                { value: 'whatsapp1', text: 'WhatsApp1' },
                { value: 'whatsapp2', text: 'WhatsApp2' }
            ]
        };

        // When change the social account platform show app series
        $(document).on('change', '.platform-select', function() {
            var platform = $(this).val();
            var $appSeriesSelect = $(this).closest('.form-group').find('.app-series-select'); 
            $appSeriesSelect.empty();
            $appSeriesSelect.append('<option value="" selected>Select App Series</option>');

            if (appSeriesOptions[platform]) {
                $.each(appSeriesOptions[platform], function(index, option) {
                    $appSeriesSelect.append('<option value="' + option.value + '">' + option.text + '</option>');
                });
            }
        });

        // Fetch social accounts when select app series
        $(document).on('change', '.app-series-select', function() {
            // Initialize Select2 on account-select
            $(document).ready(function() {
                $('.account-select').select2({
                    placeholder: "Select Account",
                    allowClear: true
                });
            });

            var socialApp = $(this).val();
            var selectAccount = $(this).closest('.form-group').find('.account-select');
            if (socialApp != '') {
                $.ajax({
                    url: "<?php echo base_url(); ?>home/fetch_social_media_accounts",
                    method: "POST",
                    data: { social_app: socialApp },
                    success: function(data) {
                        selectAccount.html('');
                        selectAccount.html(data);

                        selectAccount.select2({
                            placeholder: "Select Account",
                            allowClear: true
                        });
                    }
                });
            } else {
                selectAccount.html('<option value="">Select Account</option>');
                selectAccount.select2({
                    placeholder: "Select Account",
                    allowClear: true
                });
            }
        });
    });

</script>

</body>
</html>