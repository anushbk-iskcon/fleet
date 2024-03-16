$(document).ready(function () {
    let complaintsTable = $("#vehicleComplaintsTable").DataTable({
        autoWidth: false,
        columnDefs: [
            { width: '40px', targets: 0 },
            { width: '120px', orderable: false, targets: 6 }
        ]
    });

    loadTable(complaintsTable);

    // Enable datepickers for Filter Date inputs
    $("#filterDateFrom, #filterDateTo").daterangepicker({
        singleDatePicker: true,
        autoUpdateInput: false
    });
    $("#filterDateFrom, #filterDateTo").on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD-MMM-YYYY'));
    });
    $("#filterDateFrom, #filterDateFrom").on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });

    // On selecting vehicle type in ADD form, show vehicles of that type in vehicle select box
    $("#vehicleType").change(function () {
        if ($(this).val()) {
            loadFilteredVehicles(this);
        } else {
            $("#complaintVehicle").empty().append('<option value="">Please Select</option>');
        }
    });

    // On selecting vehicle type in UPDATE form, show vehicles of that type in vehicle select box
    $("#updateVehicleType").change(function () {
        if ($(this).val()) {
            loadFilteredVehicles(this);
        } else {
            $("#updateComplaintVehicle").empty().append('<option value="">Please Select</option>');
        }
    });

    // On showing ADD form
    $("#add").on('shown.bs.modal', function () {
        // Enable datepickers
        $("#complaintDate, #repairStartDate, #repairCompletionDate").daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false
        });
        $("#complaintDate, #repairStartDate, #repairCompletionDate").on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD-MMM-YYYY'));
        });
        $("#complaintDate, #repairStartDate, #repairCompletionDate").on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        // // On selecting vehicle type, show vehicles of that type in vehicle select box
        // Registering event listener here is going to make the callback function be called as many times as the add modal has been shown after page load
        // So moved it to docuemnt.ready instead
        // $("#vehicleType").change(function () {
        //     if ($(this).val()) {
        //         loadFilteredVehicles(this);
        //     } else {
        //         $("#complaintVehicle").empty().append('<option value="">Please Select</option>');
        //     }
        // });
    });

    // Validate and submit ADD Complaint Form
    $("#addComplaintForm").validate({
        rules: {
            complaint_register: 'required',
            complaint_date: 'required',
            job_card_number: {
                maxlength: 40
            },
            driver: 'required',
            complaint_vehicle_type: 'required',
            complaint_vehicle: 'required',
            repair_details: {
                required: true,
                maxlength: 150
            },
            complaint_vehicle_model: {
                maxlength: 50
            },
            km_reading: {
                digits: true,
                maxlength: 10
            },
            bill_amount: {
                min: 0
            }
        },
        messages: {
            repair_details: 'Please provide repair details for the complaint'
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-sm-]').append(error);
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();

            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.successCode == 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        $("#add").modal('hide');
                        loadTable(complaintsTable);
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function () {
                    toastr.error('Some error occured. Please try again', '', { closeButton: true });
                }
            });
        }
    });

    // Remove validation messages and errors on hiding ADD form modal
    $("#add").on('hidden.bs.modal', function () {
        $("#addComplaintForm").trigger('reset');
        $("#addComplaintForm").validate().resetForm();
        $("#addComplaintForm .form-control.error").removeClass('error');
        $("#addComplaintForm .form-control").removeAttr('aria-invalid');
        $("#addComplaintForm .basic-single").change();
    });

    // On showing EDIT form modal
    $("#edit").on('shown.bs.modal', function () {
        // Enable datepickers - locale object is necessary for edit/update time, but not in add form, possibly because of using moment().format()
        $("#updateComplaintDate, #updateRepairStartDate, #updateRepairCompletionDate").daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
            locale: {
                format: 'DD-MMM-YYYY'
            }
        });
        $("#updateComplaintDate, #updateRepairStartDate, #updateRepairCompletionDate").on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD-MMM-YYYY'));
        });
        $("#updateComplaintDate, #updateRepairStartDate, #updateRepairCompletionDate").on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });

    // Validate and submit Edit Form
    $("#updateComplaintForm").validate({
        rules: {
            complaint_register: 'required',
            complaint_date: 'required',
            job_card_number: {
                maxlength: 40
            },
            driver: 'required',
            complaint_vehicle_type: 'required',
            complaint_vehicle: 'required',
            repair_details: {
                required: true,
                maxlength: 150
            },
            complaint_vehicle_model: {
                maxlength: 50
            },
            km_reading: {
                digits: true,
                maxlength: 10
            },
            bill_amount: {
                min: 0
            }
        },
        messages: {
            repair_details: 'Please provide repair details for the complaint'
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-sm-]').append(error);
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();

            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.successCode == 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        $("#edit").modal('hide');
                        loadTable(complaintsTable);
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function () {
                    toastr.error('Some error occured. Please try again', '', { closeButton: true });
                }
            });
        }
    });

    // Remove validation messages and errors on hiding EDIT form modal
    $("#edit").on('hidden.bs.modal', function () {
        $("#updateComplaintForm").validate().resetForm();
        $("#updateComplaintForm .form-control.error").removeClass('error');
        $("#updateComplaintForm .form-control").removeAttr('aria-invalid');
        $("#updateComplaintForm .basic-single").change();
    });

    // On clicking the Approve complaint button
    $("#approveForm").submit(function (ev) {
        ev.preventDefault();
        let approveForm = $(this);

        if (confirm("Are you sure?")) {
            $.ajax({
                url: approveForm.attr('action'),
                type: approveForm.attr('method'),
                data: approveForm.serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.successCode == 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        $("#view").modal('hide');
                        loadTable(complaintsTable);
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                        $("#view").modal('hide');
                    }
                },
                error: function () {
                    toastr.error('Error approving complaint. Please try again', '', { closeButton: true });
                }
            });
        }
    });

    // On clicking the Cancel complaint button
    $("#cancelForm").submit(function (ev) {
        ev.preventDefault();
        let cancelForm = $(this);

        if (confirm("Are you sure?")) {
            $.ajax({
                url: cancelForm.attr('action'),
                type: cancelForm.attr('method'),
                data: cancelForm.serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.successCode == 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        $("#view").modal('hide');
                        loadTable(complaintsTable);
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                        $("#view").modal('hide');
                    }
                },
                error: function () {
                    toastr.error('Error canceling complaint. Please try again', '', { closeButton: true });
                }
            });
        }
    });

    // To hide the Approve / Cancel buttons by default
    $("#view").on('hidden.bs.modal', function () {
        $("#approveComplaintBtn, #cancelComplaintBtn").hide();
        $("#detail-value").html('');
    });

    // On showing the Mark Complaint as closed modal
    $("#completeComplaint").on('shown.bs.modal', function () {
        $("#complaintCompletionDate").daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
            locale: {
                format: 'DD-MMM-YYYY'
            }
        });
        $("#complaintCompletionDate").on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD-MMM-YYYY'));
        });
        $("#complaintCompletionDate").on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });

    // Validate and Submit Clsoing Complaint Form
    $("#completeComplaintForm").validate({
        rules: {
            repair_completion_date: 'required',
            bill_amount: {
                required: true,
                min: 0
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-sm-]').append(error);
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function (res) {
                    if (res.successCode == 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        $("#completeComplaint").modal('hide');
                        loadTable(complaintsTable);
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function () {
                    toastr.error('Error performing action. Please try again', '', { closeButton: true });
                }
            });
        }
    });

    // Remove validation messages and errors on hiding EDIT form modal
    $("#completeComplaint").on('hidden.bs.modal', function () {
        $("#completeComplaintForm").trigger('reset');
        $("#completeComplaintForm").validate().resetForm();
        $("#completeComplaintForm .form-control.error").removeClass('error');
        $("#completeComplaintForm .form-control").removeAttr('aria-invalid');
        $("#completeComplaintForm .basic-single").change();
    });


});
// End of jQuery document.ready

function viewInfo(id) {
    $.ajax({
        url: viewDetailsURL,
        type: 'post',
        data: {
            _token: csrfToken,
            complaint_id: id
        },
        dataType: 'json',
        beforeSend: function () {
            $('.custom-loader').show();
        },
        success: function (res) {
            console.log(res);
            // Load Details to View Info Modal and show
            let approvalStatusText = '';
            if (res[0].APPROVAL_STATUS == 'P')
                approvalStatusText = '<span class="badge badge-primary p-2"><i class="far fa-hourglass mr-2"></i>Pending</span>';
            else if (res[0].APPROVAL_STATUS == 'A')
                approvalStatusText = '<span class="badge badge-success p-2"><i class="fas fa-check-circle mr-2"></i>Approved</span>';
            else if (res[0].APPROVAL_STATUS == 'X')
                approvalStatusText = '<span class="badge badge-danger p-2"><i class="fas fa-ban mr-2"></i>Canceled</span>';
            else
                approvalStatusText = '<span class="badge badge-secondary p-2"><i class="fas fa-check-double mr-2"></i>Resolved</span>';

            let complaintRegisterVal = (res[0].COMPLAINT_REGISTER == 'C' ? 'Car Complaints Register' : 'Auto Rickshaw Complaints Register');
            let vehicleDetail = res[0].VEHICLE_NAME + ' (' + res[0].LICENSE_PLATE + ')';
            let vehicleModel = res[0].MODEL ? res[0].MODEL : '';
            let repairStartDate = res[0].REPAIR_START_DATE ? moment(res[0].REPAIR_START_DATE).format('DD-MMM-YYYY') : '';
            let repairCompletionDate = res[0].REPAIR_COMPLETION_DATE ? moment(res[0].REPAIR_COMPLETION_DATE).format('DD-MMM-YYYY') : '';
            $("#approvalStatus").html(approvalStatusText);
            $("#complaintRegisterValue").html(complaintRegisterVal);
            $("#vehicleDetail").html(vehicleDetail);
            $("#driverNameDetail").html(res[0].DRIVER_NAME);
            $("#vehicleTypeDetail").html(res[0].VEHICLE_TYPE_NAME);
            $("#vehicleModelDetail").html(vehicleModel);
            $("#kmReadingDetail").html(res[0].ODOMETER_READING);
            $("#complaintDateDetail").html(moment(res[0].DATE).format('DD-MMM-YYYY'));
            $("#jobCardNumberDetail").html(res[0].JOB_CARD_NUMBER);
            $("#repairDetail").html(res[0].REPAIR_DETAILS);
            $("#repairStartDateDetail").html(repairStartDate);
            $("#repairCompletionDateDetail").html(repairCompletionDate);
            $("#billAmountDetail").html(res[0].BILL_AMOUNT);

            // To show the Accept/Cancel buttons
            if (res[0].APPROVAL_STATUS == 'P')
                $("#approveComplaintBtn").show();
            if (res[0].APPROVAL_STATUS == 'P' || res[0].APPROVAL_STATUS == 'A')
                $("#cancelComplaintBtn").show();

            $("#approveComplaintId, #cancelComplaintId").val(id);
            $("#view").modal('show');
        },
        error: function () {
            toastr.error("An error occured while getting details. Please try again", '', { closeButton: true });
        },
        complete: function () {
            $('.custom-loader').hide();
        }
    });
}

// Load filtered vehicles list to Vehicle Select Dropdown in either Add or Edit Form
function loadFilteredVehicles(el) {
    $.ajax({
        url: filteredVehiclesListURL,
        type: 'post',
        data: {
            _token: csrfToken,
            vehicle_type: $(el).val()
        },
        dataType: 'json',
        beforeSend: function () {
            $('.custom-loader').show();
        },
        success: function (res) {
            let vehicleSelectBox = $(el).closest('form').find('select[name=complaint_vehicle]');
            if (res.length >= 1) {
                vehicleSelectBox.empty().append('<option value="">Please Select</option>');
                let choice = vehicleSelectBox.attr('data-og-selection') ? vehicleSelectBox.attr('data-og-selection') : '';
                $.each(res, function (i, data) {
                    vehicleSelectBox.append(`<option value="${data.VEHICLE_ID}">${data.VEHICLE_NAME + ' (' + data.LICENSE_PLATE + ')'}</option>`);
                });
                // to set originally selected value of Vehicle if vehicle type is changed back
                if (vehicleSelectBox.find('option[value="' + choice + '"]').length)
                    vehicleSelectBox.val(choice).change(); // to reflect the set value since select2 is being used
                else
                    vehicleSelectBox.val('').change();
            } else {
                vehicleSelectBox.empty().append('<option value="">Please Select</option>');
                toastr.error("No vehicles found", '', { closeButton: true });
            }
        },
        error: function () {
            toastr.error("Error getting data. Please try again", "", { closeButton: true });
        },
        complete: function () {
            $('.custom-loader').hide();
        }
    });
}

// Load details to Edit Form for updating
function editInfo(id) {
    $.ajax({
        url: getDetailsURL,
        type: 'post',
        data: {
            _token: csrfToken,
            complaint_id: id
        },
        dataType: 'json',
        beforeSend: function () {
            $('.custom-loader').show();
        },
        success: function (res) {
            // console.log(res);

            let complaintDate = moment(res.DATE).format('DD-MMM-YYYY');
            let repairStartDate = '';
            let repairCompletionDate = '';
            if (res.REPAIR_START_DATE)
                repairStartDate = moment(res.REPAIR_START_DATE).format('DD-MMM-YYYY');
            if (res.REPAIR_COMPLETION_DATE)
                repairCompletionDate = moment(res.REPAIR_COMPLETION_DATE).format('DD-MMM-YYYY');
            $("#edit").modal('show');
            $("#updateComplaintId").val(res.COMPLAINT_ID);
            $("#updateComplaintRegister").val(res.COMPLAINT_REGISTER);
            $("#updateComplaintDate").val(complaintDate);
            $("#updateJobCardNumber").val(res.JOB_CARD_NUMBER);
            $("#updateComplaintDriver").val(res.DRIVER_ID).change();
            $("#updateComplaintVehicle").val(res.VEHICLE_ID).change();
            $("#updateComplaintVehicle").attr('data-og-selection', res.VEHICLE_ID);
            $("#updateVehicleType").val(res.VEHICLE_TYPE_ID).trigger('change');
            $("#updateRepairDetails").val(res.REPAIR_DETAILS);
            $("#updateVehicleModel").val(res.MODEL);
            $("#updateKmReading").val(res.ODOMETER_READING);
            $("#updateRepairStartDate").val(repairStartDate);
            $("#updateRepairCompletionDate").val(repairCompletionDate);
            $("#updateBillAmount").val(res.BILL_AMOUNT);

            loadFilteredVehicles($("#updateVehicleType"));

            // $("#updateVehicleType").change(function () {
            //     if ($(this).val()) {
            //         loadFilteredVehicles(this);
            //     } else {
            //         $("#updateComplaintVehicle").empty().append('<option value="">Please Select</option>');
            //     }
            // });

            // // Enable datepickers
            // $("#updateComplaintDate, #updateRepairStartDate, #updateRepairCompletionDate").daterangepicker({
            //     singleDatePicker: true,
            //     locale: {
            //         format: 'DD-MMM-YYYY'
            //     },
            //     autoUpdateInput: false
            // });
            // $("#updateComplaintDate, #updateRepairStartDate, #updateRepairCompletionDate").on('apply.daterangepicker', function (ev, picker) {
            //     $(this).val(picker.startDate.format('DD-MMM-YYYY'));
            // });
            // $("#updateComplaintDate, #updateRepairStartDate, #updateRepairCompletionDate").on('cancel.daterangepicker', function (ev, picker) {
            //     $(this).val('');
            // });
        },
        error: function () {
            toastr.error("Error getting details. Please try again", '', { closeButton: true });
        },
        complete: function () {
            $('.custom-loader').hide();
        }
    });
}

// To show form to set a complaint as 'Closed' or 'Completed'
function updateCompletion(id) {
    if (confirm("Are you sure?")) {
        $.ajax({
            url: getDetailsURL,
            type: 'post',
            data: {
                _token: csrfToken,
                complaint_id: id
            },
            beforeSend: function () {
                $('.custom-loader').show();
            },
            dataType: 'json',
            success: function (res) {
                $("#completeComplaint").modal('show');
                $("#complaintIdToClose").val(id);
                if (res.REPAIR_COMPLETION_DATE)
                    $("#complaintCompletionDate").val(moment(res.REPAIR_COMPLETION_DATE).format('DD-MMM-YYYY'));
                if (res.BILL_AMOUNT)
                    $("#complaintCompletionAmount").val(res.BILL_AMOUNT);
            },
            error: function () {
                toastr.error("Error getting details. Please try again", '', { closeButton: true });
            },
            complete: function () {
                $('.custom-loader').hide();
            }
        });

    }
}

// To load complaints list to table or to refresh the table
function loadTable(table) {
    $.ajax({
        url: complaintsListURL,
        type: 'post',
        data: {
            _token: csrfToken
        },
        dataType: 'json',
        beforeSend: function () {
            $("#table-loader").show();
        },
        success: function (res) {
            // console.log(res);
            table.clear();
            if (res.length >= 1) {
                $.each(res, function (i, data) {
                    let vehicleDetail = data.VEHICLE_NAME + ' (' + data.LICENSE_PLATE + ')';
                    let complaintDate = moment(data.DATE).format('DD-MMM-YYYY');
                    let status = '';
                    if (data.APPROVAL_STATUS == 'P')
                        status = 'Pending';
                    else if (data.APPROVAL_STATUS == 'A')
                        status = 'Accepted';
                    else if (data.APPROVAL_STATUS == 'X')
                        status = 'Canceled';
                    else
                        status = 'Resolved';

                    let actionBtns = `
                    <button class="btn btn-sm btn-info mr-1" onclick="viewInfo(${data.COMPLAINT_ID})" title="View"><i class="fas fa-eye"></i></button>
                    <button class="btn btn-sm btn-primary mr-1" onclick="editInfo(${data.COMPLAINT_ID})" title="Update"><i class="ti-pencil"></i></button>
                    `;

                    if (data.APPROVAL_STATUS == 'A')
                        actionBtns += `<button class="btn btn-sm btn-danger mr-1" onclick="updateCompletion(${data.COMPLAINT_ID})" title="Mark as Resolved">
                <i class="ti-check"></i></button>`;

                    table.row.add([
                        i + 1,
                        vehicleDetail,
                        data.VEHICLE_TYPE,
                        data.DRIVER_NAME,
                        complaintDate,
                        status,
                        actionBtns
                    ]);
                });
            }
            table.draw();
        },
        error: function () {
            toastr.error('Error fetching data. Please try again', '', { closeButton: true });
        },
        complete: function () {
            $("#table-loader").hide();
        }
    });
}
