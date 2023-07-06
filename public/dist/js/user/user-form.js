// profile picture change
function readpicture(input) {
    if (input.files && input.files[0]) {
        let fileName = input.files[0].name;
        let fileNameExtn = fileName.substr(fileName.lastIndexOf('.') + 1).toLowerCase();
        if (fileNameExtn !== 'jpg' && fileNameExtn != 'jpeg' && fileNameExtn != 'png') {
            return;
        } else {
            $("#fileExtError").html("");
        }
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#user_picture_change')
                .attr('src', e.target.result)
                .width(100)
                .height(100);
        };

        reader.readAsDataURL(input.files[0]);

    } else {

        $('#user_picture_change')
            .attr('src', defaultProfileImg)
            .width(100)
            .height(100);
    }

}