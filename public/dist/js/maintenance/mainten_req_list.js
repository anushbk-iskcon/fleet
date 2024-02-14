$(document).ready(function () {
    let maintenReqTable = $("#mainreq").DataTable({
        "columnDefs": [{ "width": "40px", "targets": 0 },
        { "max-width": "10%", "targets": 1 },
        { "width": "140px", "orderable": false, targets: 6 }
        ],
        autoWidth: false
    });

    $("#btn-filter").click(function () {
        populateTable(maintenReqTable);
    });

    $("#btn-reset").click(function () {
        $("#mainten_type").val("").change();
        $("#vehicle").val("").change();
        $("#status").val("").change();
        $("#service_fr").val("").change();
        $("#filter_from").val("");
        $("#filter_to").val("");
        populateTable(maintenReqTable);
    });

    // To enable date-pickers on filter form
    $("#filter_from, #filter_to").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        autoApply: false,
        minYear: 2000,
        maxDate: '31-Dec' + (currentYear + 1),
        drops: "down",
        locale: {
            format: 'DD-MMM-YYYY'
        },
        maxYear: parseInt(moment().format('YYYY'), 10)
    });
    $("#filter_from, #filter_to").on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD-MMM-YYYY'));
    });
    $("#filter_from, #filter_to").on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });

    populateTable(maintenReqTable);
});

function populateTable(table) {
    $.ajax({
        url: getRequisitionsDataURL,
        type: 'post',
        data: {
            mainten_type: $("#mainten_type").val(),
            vehicle: $("#vehicle").val(),
            status: $("#status").val(),
            mainten_service: $("#service_fr").val(),
            from: $("#filter_from").val(),
            to: $("#filter_to").val(),
            _token: csrfToken
        },
        dataType: 'json',
        beforeSend: function () {
            $("#table-loader").show();
        },
        success: function (res) {
            table.clear();
            if (res.length >= 1) {
                // Fill rows in the table
                $.each(res, function (i, data) {
                    let reqStatus = '';
                    let reqDate = moment(data.SERVICE_DATE).format('DD-MMM-YYYY');

                    // To set the URL used to load the Edit Page for the specific maintenance requisition
                    let editURL = editRequisitionPlaceholderURL;
                    // editURL = editURL.replace('0', data.MAINTENANCE_REQ_ID);

                    editURL = editURL.substring(0, editURL.lastIndexOf('0'));
                    editURL += data.MAINTENANCE_REQ_ID;
                    editURL += '/edit';

                    if (data.APPROVAL_STATUS == 'P')
                        reqStatus = 'Pending';
                    else if (data.APPROVAL_STATUS == 'A')
                        reqStatus = 'Approved';
                    else
                        reqStatus = 'Rejected';

                    let actionBtns = '<a href="' + editURL + '" class="btn btn-success mr-1" title="Update"><i class="ti-pencil"></i></a> ';
                    actionBtns += '<a href="javascript:void(0);" class="btn btn-info mr-1" title="View Details" onclick="viewInfo(' + data.MAINTENANCE_REQ_ID + ')"><i class="far fa-eye"></i></a> ';
                    // if (data.IS_ACTIVE == 'Y')
                    //     actionBtns += '<a href="javascript:void(0);" class="btn btn-danger mr-1" title="Deactivate" onclick="changeActivationstatus(' + data.MAINTENANCE_REQ_ID + ')"><i class="ti-close"></i></a> ';
                    // else
                    //     actionBtns += '<a href="javascript:void(0);" class="btn btn-danger mr-1" title="Activate" onclick="changeActivationstatus(' + data.MAINTENANCE_REQ_ID + ')"><i class="ti-close"></i></a> ';

                    let approvalBtnsContainer = `<div class="" style="display:inline-block;">
                                                <div class="actions" style="display:inline-block;">
                                                <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changeStatus2(1, ${data.MAINTENANCE_REQ_ID})" class="dropdown-item">Accept</a>
                                                    <a onclick="changeStatus2(2, ${data.MAINTENANCE_REQ_ID})" class="dropdown-item">Reject</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;

                    actionBtns += approvalBtnsContainer;
                    table.row.add([
                        i + 1,
                        reqDate,
                        data.VEHICLE_NAME + ' (' + data.LICENSE_PLATE + ')',
                        data.MAINTENANCE_NAME,
                        data.EMPLOYEE_NAME,
                        reqStatus,
                        actionBtns
                    ]);
                });
            }
            table.draw();
        },
        error: function () {
            toastr.error("Could not load details. Please try again", "", { closeButton: true });
        },
        complete: function () {
            $("#table-loader").hide();
        }
    });
}

function viewInfo(reqId) {
    $.ajax({
        url: getRequisitionDetailsURL,
        type: 'post',
        data: {
            mainten_req_id: reqId,
            _token: csrfToken
        },
        success: function (res) {
            $("#viewInfo .modal-body").empty().html(res);
            $("#viewInfo").modal('show');
        },
        error: function (jqXHR, status, err) {
            toastr.error("Error fetching details. Please try again");
        }
    });
}

function changeStatus2(approvalStatus, requisitionId) {
    // approvalStatus 1 = Accept (Approve), 2 = Deny (Reject)
    $.ajax({
        url: updateApprovalStatusURL,
        type: 'post',
        data: {
            mainten_req_id: requisitionId,
            approval_status: approvalStatus,
            _token: csrfToken
        },
        dataType: 'json',
        success: function (res) {
            if (res.successCode == 1) {
                toastr.success(res.message, '', { closeButton: true });
                populateTable($("#mainreq").DataTable());
            } else {
                toastr.error(res.message, '', { closeButton: true });
            }
        },
        error: function (jqxhr, status, err) {
            toastr.error("Some error occcured. Please try again", "", { closeButton: true });
        }
    });
}