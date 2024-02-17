console.log("JS aktif");
$('.custom-file-input').on('change', function () {
    var fileNames = [];
    var input = $(this)[0];

    if (input.files && input.files.length > 0) {
        for (var i = 0; i < input.files.length; i++) {
            fileNames.push(input.files[i].name);
        }
    }

    if (fileNames.length > 0) {
        $(this).next('.custom-file-label').text(fileNames.join(', '));
    } else {
        $(this).next('.custom-file-label').text('Choose file');
    }
});
