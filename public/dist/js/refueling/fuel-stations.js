$(document).ready(function () {
    let fuelStationsTable = $("#stationinfo").DataTable();

    // To add serial numbers in data table on adding new item
    fuelStationsTable.on('draw.dt', function () {
        var PageInfo = $('#stationinfo').DataTable().page.info();
        fuelStationsTable.column(0, {
            page: 'current'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

    // Validate and submit Add Fuel Station Form
    $("#addFuelStationForm").validate({
        rules: {
            vendor_name: {
                required: true,
                maxlength: 50
            },
            station_name: {
                maxlength: 80
            },
            station_code: {
                required: true,
                maxlength: 25
            },
            authorize_person: {
                required: true,
                maxlength: 80
            },
            contact_num: {
                required: true
            }
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();
            console.log($(form).serializeArray());

            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.successCode == 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        console.log(res);

                        $("#add0").modal('hide');
                        // Add newly created entry to datatable
                        let actionBtns = '<button type="button" class="btn btn-info mr-1" title="Edit" data-id="' + res.data.FUEL_STATION_ID + '" onclick="editInfo(this, \'' + res.data.FUEL_STATION_NAME + '\')"><i class="ti-pencil"></i></button>';
                        actionBtns += '<button type="button" class="btn btn-danger" title="Deactivate" data-id="' + res.data.FUEL_STATION_ID + '" onclick="updateStatus(this)"><i class="ti-close"></i></button>';
                        fuelStationsTable.row.add(['', res.data.FUEL_STATION_NAME, res.data.VENDOR_NAME, res.data.AUTHORIZE_PERSON, res.data.CONTACT_NUMBER, res.data.IS_AUTHORIZED == 'Y' ? 'Yes' : 'No', actionBtns]);

                        fuelStationsTable.draw(false);

                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function (xhr, status, err) {
                    toastr.error('Error adding fuel station. Please try again', '', { closeButton: true });
                }
            });
        }
    });

    // Reset error messages and form on closing modal
    $("#add0").on('hidden.bs.modal', function () {
        $("#addFuelStationForm").trigger('reset');
        $("#addFuelStationForm").data('validator').resetForm();
        $("#addFuelStationForm .form-control.error").removeClass('error').removeAttr('aria-invalid');
    });
});

function editInfo(el, name) {
    $("#editFuelStationId").val($(el).data('id'));
    $("#edit").modal('show');
    getFuelStationDetails($(el).data('id'));

}

function getFuelStationDetails(fuelStationId) {
    $.ajax({
        url: getFuelStationDetailsURl,
        type: 'post',
        data: {
            _token: csrfToken,
            fuel_station_id: fuelStationId
        },
        dataType: 'json',
        success: function (res) {
            if (res.successCode == 1) {
                $("#new_station_name").attr('value', res.data.FUEL_STATION_NAME);
                $("#new_vendor_name").attr('value', res.data.VENDOR_NAME);
                $("#new_station_code").attr('value', res.data.STATION_CODE);
                $("#new_authorize_person").attr('value', res.data.AUTHORIZE_PERSON);
                $("#new_contact_num").attr('value', res.data.CONTACT_NUMBER);
                if (res.data.IS_AUTHORIZED == 'Y')
                    $("#editFuelStationForm input[name=is_authorized]").attr("checked", "checked");
                else
                    $("#editFuelStationForm input[name=is_authorized]").removeAttr("checked");
            } else {
                $("#edit").modal('hide');
                toastr.error("Could not get details", '', { closeButton: true });
            }
        },
        error: function (jqxhr, status, err) {
            $("#edit").modal('hide');
            toastr.error("Error getting details", '', { closeButton: true });
        }
    });
}

function updateStatus(el) { }