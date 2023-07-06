//To validate first name and last name
$.validator.addMethod('validName', function (value, element) {
    return (this.optional(element) || /^[a-zA-Z ]+([\'\-\.]?[a-zA-Z0-9 ]?)*$/.test(value));
}, "Please enter a valid name");

$.validator.addMethod('validPassword', function (value, element) {
    return (this.optional(element) || /^(?=.*[0-9])(?=.*[!@#$%^&*\?\.\,\-\(\)\+=])[a-zA-Z0-9!@#$%^&*\?\.\,\-\(\)\+=]{8,30}$/.test(value));
}, "Password should contain at least one number and one special character");

//To validate input image is only JPG or PNG
$.validator.addMethod('validImage', function (value, element, param) {
    let fileName = ''; let fileExtn = '';
    if (element.files[0]) {
        fileName = element.files[0].name;
        fileExtn = fileName.substr(fileName.lastIndexOf('.') + 1).toLowerCase();
    }
    return (this.optional(element) || (fileExtn === 'jpg' || fileExtn === 'jpeg' || fileExtn === 'png'));
}, "Profile image should be only JPG or PNG");

//Validate form before submission
$("#editUserForm").validate({
    rules: {
        firstname: {
            required: true,
            minlength: 2,
            maxlength: 50,
            validName: true
        },
        lastname: {
            required: true,
            maxlength: 50,
            validName: true
        },
        email: {
            required: true,
            maxlength: 100,
            email: true
        },
        password: {
            minlength: 8,
            maxlength: 30,
            validPassword: true
        },
        about: {
            maxlength: 200
        },
        image: {
            validImage: true
        }
    },
    onfocusout: false, //To keep default lazy validation
    submitHandler: function (form, ev) {
        ev.preventDefault();
        let editUserFormData = new FormData($("#editUserForm")[0]);
        $.ajax({
            url: form.action,
            method: 'post',
            data: editUserFormData,
            processData: false,
            contentType: false,
            success: function (res) {
                console.log(res);
                toastr.success(res, '', { closeButton: true });
                console.log(editUserFormData);
            },
            error: function (jqXHR, textStaus, errorThrown) {
                console.log("Some error occurred");
                toastr.error("Could not update user", '', { closeButton: true });
            }
        });
    }
});