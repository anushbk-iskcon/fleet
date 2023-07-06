//To validate first name and last name
$.validator.addMethod('validName', function (value, element) {
    return (this.optional(element) || /^[a-zA-Z ]+([\'\-\.]?[a-zA-Z0-9 ]?)*$/.test(value));
}, "Please enter a valid name");

//To validate password is between 8 and 30 characters, contains at least one digit and one special character
$.validator.addMethod('validPassword', function (value, element) {
    return (this.optional(element) || /^(?=.*[0-9])(?=.*[!@#$%^&*\?\.\,\-\(\)\+=])[a-zA-Z0-9!@#$%^&*\?\.\,\-\(\)\+=]{8,30}$/.test(value));
}, "Password should contain at least one number and one special character");

//To validate input image is only JPG or PNG
$.validator.addMethod('validImage', function (value, element, param) {
    let fileName = ''; let fileExtn = '';
    if (element.files[0]) { // If profile image is present
        fileName = element.files[0].name;
        fileExtn = fileName.substr(fileName.lastIndexOf('.') + 1).toLowerCase();
    }
    return (this.optional(element) || (fileExtn === 'jpg' || fileExtn === 'jpeg' || fileExtn === 'png'));
}, "Profile image should be only JPG or PNG");

//Validate form before submission
$("#updateProfileForm").validate({
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
        let updateProfileFormData = new FormData($("#updateProfileForm")[0]);
        console.log(updateProfileFormData);
        $.ajax({
            url: form.action,
            type: 'post',
            data: updateProfileFormData,
            processData: false,
            contentType: false,
            success: function (res) {
                console.log(res);
                toastr.success(res, '', { closeButton: true });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Some error occured");
                toastr.error("Could not update your profile", '', { closeButton: true });
            }
        });
    }
});