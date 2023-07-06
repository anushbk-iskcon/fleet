$("#createRoleForm").validate({
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
            type: form.method,
            data: formData,
            success: function (res) {
                console.log(res);
                toastr.success("New role successfully created", "Success", { closeButton: true });
                $(form).trigger('reset');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Could not add role");
                toastr.error("Could not create role", "Error", { closeButton: true });
            }
        });
    }
});