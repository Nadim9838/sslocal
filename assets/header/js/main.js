$('#fileupload').fileupload({
    url: '../imageUploads/'
}).on('fileuploadsubmit', function (e, data) {
    data.formData = data.context.find(':input').serializeArray();
});