$(document).ready(function () {
    let maintenAuthoritiesTable = $("#authinfo").DataTable();

    $("#addMaintenAuthorityForm").validate({
        rules: {
            phase: 'required',
            department: 'required',
            employee: 'required'
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-sm-]').append(error);
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();
        }
    });

    $("#add0").on('hidden.bs.modal', function () {
        $("#addMaintenAuthorityForm").trigger('reset');
        $("#addMaintenAuthorityForm").data('validator').resetForm();
        $("#addMaintenAuthorityForm select").removeClass('error');
        $("#addMaintenAuthorityForm").removeAttr('aria-invalid');

        // To prevent select2 boxes still displaying previously selected value on resetting form
        $('#department').val('').trigger('change');

        // Empty and reset employee list if populated by selecting/changing department
        //$("#employeeSelect").html("").append("<option value='' selected>Please Select Employee</option>");
    });
});

function populateTable(table) {

}

function loadEmployees() {
    if ($("#department").val()) {
        $.ajax({
            url: loadEmployeesURL,
            type: 'post',
            data: {
                department: $("#department").val(),
                _token: csrfToken
            },
            success: function (res) {
                if (res.successCode == 1) {
                    $("#employeeSelect").html("").append("<option value='' selected>Please Select Employee</option>");
                    if (res.data.length >= 1) {
                        $.each(res.data, function (i, data) {
                            $("#employeeSelect").append('<option value="' + data.employeeId + '|' + data.employeeName + '">' +
                                data.employeeName + '</option>');
                        });
                    }
                } else {
                    $("#employeeSelect").html("").append("<option value='' selected>Please Select Employee</option>");
                    toastr.error("No results found", '', { closeButton: true });
                }
            },
            error: function (jqXHR, textStatus, err) {
                toastr.error("Error getting details. Please try again", "", { closeButton: true });
            }
        });
    }
}