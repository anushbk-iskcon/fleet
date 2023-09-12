$(document).ready(function () {
    let fuelStationsTable = $("#stationinfo").DataTable();

    populateTable(fuelStationsTable);

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

    // Reset error messages in add form on clicking the reset button
    $("#resetAddFormBtn").click(function () {
        setTimeout(() => {
            $("#addFuelStationForm").data('validator').resetForm();
        }, 10);
    });

    // Validate and submit Edit Fuel Station Details Form
    $("#editFuelStationForm").validate({
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
            let editFuelStationId = $("#editFuelStationId").val();
            console.log(editFuelStationId);
            console.log($(form).serializeArray());

            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.successCode == 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        $("#edit").modal('hide');

                        // Populate and redraw table
                        populateTable(fuelStationsTable);
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function (jqXHR, textStatus, err) {
                    toastr.error('Error loading data. Please refresh and try again', '', { closeButton: true });
                }
            });
        }
    });

    // Remove validations, errors and reset add vehicle type form on closing modal
    $("#edit").on('hidden.bs.modal', function (ev) {
        $("#editFuelStationForm").trigger('reset');
        $("#editFuelStationForm").validate().resetForm();
        $("#editFuelStationForm .form-control.error").removeClass('error').removeAttr('aria-invalid');
        // Change ID of 'Is Authorized' checkbox to initial ID (checkbox2)
        $("#editFuelStationForm input[name=is_authorized]").attr('id', 'checkbox2');
    });

    // On clicking the reset button on the edit form,
    // remove validation errors
    $("#resetEditFormBtn").click(function () {
        setTimeout(() => {
            $("#editFuelStationForm").validate().resetForm();
        }, 10);
    });

    // For Filtering and Searching
    $("#btn-filter").click(function () {
        populateTable(fuelStationsTable);
    });

    $("#btn-reset").click(function () {
        $("#station_namesr").val("");
        $("#vendorsr").val("");
        populateTable(fuelStationsTable);
    });
});

function populateTable(table) {
    $.ajax({
        url: fuelStationsListURL,
        type: 'post',
        data: {
            _token: csrfToken,
            vendorsr: $("#vendorsr").val(),
            station_namesr: $("#station_namesr").val()
        },
        dataType: 'json',
        beforeSend: function () {
            $("#table-loader").show();
        },
        success: function (res) {
            table.clear();
            $.each(res, function (i, data) {
                // console.log(data);
                let isAuthorized = data.IS_AUTHORIZED == 'Y' ? "Yes" : "No";
                let actionBtns = '<button type="button" class="btn btn-info mr-1" title="Edit" data-id="' + data.FUEL_STATION_ID + '" onclick="editInfo(this)"><i class="ti-pencil"></i></button>';
                if (data.IS_ACTIVE == 'Y')
                    actionBtns += '<button type="button" class="btn btn-danger mr-1" title="Deactivate" data-id="' + data.FUEL_STATION_ID + '" onclick="updateStatus(this)"><i class="ti-close"></i></button>';
                else
                    actionBtns += '<button type="button" class="btn btn-success mr-1" title="Activate" data-id="' + data.FUEL_STATION_ID + '" onclick="updateStatus(this)"><i class="ti-reload"></i></button>';

                table.row.add([
                    i + 1,
                    data.FUEL_STATION_NAME,
                    data.VENDOR_NAME,
                    data.AUTHORIZE_PERSON,
                    data.CONTACT_NUMBER,
                    isAuthorized,
                    actionBtns
                ]);
            });

            table.draw(false);
        },
        error: function (jqXHR, textStatus, err) {
            console.log("Error fetching data");
        },
        complete: function () {
            $("#table-loader").hide();
        }
    });
}

function editInfo(el) {
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
        beforeSend: function () {
            $(".customloader").show();
        },
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
                // To allow changing checked state of checkbox for editing Is Authorized Value
                $("#editFuelStationForm input[name=is_authorized]").attr('id', 'is_authorized' + fuelStationId);
                $("#editFuelStationForm input[name=is_authorized]").next().attr('for', 'is_authorized' + fuelStationId);
            } else {
                $("#edit").modal('hide');
                toastr.error("Could not get details", '', { closeButton: true });
            }
        },
        error: function (jqxhr, status, err) {
            $("#edit").modal('hide');
            toastr.error("Error getting details", '', { closeButton: true });
        },
        complete: function () {
            $(".customloader").hide();
        }
    });
}

function updateStatus(el) {
    let fuelStationId = $(el).data('id');

    toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no' >No</button>", 'Are you sure?', {
        allowHtml: true,
        onclick: function (toast) {
            value = toast.target.value
            if (value == 'yes') {

                var url = updateActivationStatusURL;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": csrfToken,
                        fuel_station_id: fuelStationId
                    },
                    success: function (response) {
                        toastr.remove();

                        if (response['IS_ACTIVE'] == 'Y') {
                            $(el).removeClass('btn-success').addClass('btn-danger');
                            $(el).html('<i class="ti-close"></i>');
                            $(el).attr('title', 'Deactivate');
                        } else {
                            $(el).removeClass('btn-danger').addClass('btn-success');
                            $(el).html('<i class="ti-reload"></i>');
                            $(el).attr('title', 'Activate');
                        }

                        toastr.success('Status Updated', '', {
                            closeButton: true
                        });
                    }
                });

            } else {
                toastr.remove();
            }
        }

    });
}