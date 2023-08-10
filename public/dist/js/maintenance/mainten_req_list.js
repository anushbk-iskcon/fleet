$(document).ready(function () {
    let maintenReqTable = $("#mainreq").DataTable();

    $("#btn-filter").click(function () {
        populateTable(maintenReqTable);
    });

    $("#btn-reset").click(function () {
        $("#mainten_type").val("");
        $("#vehicle").val("");
        $("#status").val("");
        $("#service_fr").val("");
        $("#from").val("");
        $("#to").val("");
        populateTable(maintenReqTable);
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
            from: $("#from").val(),
            to: $("#to").val(),
            _token: csrfToken
        },
        dataType: 'json',
        success: function (res) {
            table.clear();
            if (res.length >= 1) {
                // Fill rows in the table
                $.each(res, function (i, data) {
                    let reqStatus = '';
                    let editURL = editRequisitionPlaceholderURL;
                    editURL = editURL.replace('0', data.MAINTENANCE_REQ_ID);
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
                        data.SERVICE_DATE,
                        data.VEHICLE_NAME,
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
    console.log(approvalStatus);
    console.log(requisitionId);

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