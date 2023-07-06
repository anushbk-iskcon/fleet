$("#updateRoleForm").validate({
    rules: {
        role_name: {
            required: true,
            maxlength: 50
        }
    },
    submitHandler: function (form, ev) {
        ev.preventDefault();
        let formData = $(form).serialize();
        // console.log(formData);
        // console.log(form.action);
        // console.log(form.method);

        $.ajax({
            url: form.action,
            type: 'put',
            data: formData,
            success: function (res) {
                console.log(res);
                toastr.success(res, "Success", { closeButton: true });
                // $(form).trigger('reset');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Could not update role");
                toastr.error("Could not update role, please try again", "Error", { closeButton: true });
            }
        });
    }
});