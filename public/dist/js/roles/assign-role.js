$(document).ready(function () {
    $("#assignRoleForm").validate({
        rules: {
            user_id: 'required',
            assigned_role: 'required'
        },
        errorPlacement: function (error, element) {
            $(element).closest('div').append(error);
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();
            let assignedRoleData = $(form).serialize();
            console.log(assignedRoleData);

            $.ajax({
                url: assignUserRoleURL,
                type: 'post',
                data: assignedRoleData,
                success: function (res) {
                    console.log(res);
                    toastr.success(res, '', { closeButton: true });
                },
                error: function (jqXHR, textStatus, errThrown) {
                    console.log("Error in assigning role. Please try again");
                    toastr.error("Error in assigning role. Please try again", '', { closeButton: true });
                }
            });
        }
    });
});