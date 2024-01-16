
// download.js
function download(){
    $(document).ready(function () {
        $('#downloadform').submit(function (e) {
            e.preventDefault();
            $('#successMessage').hide();
            $('#errorMessage').hide();
            // Mostrar el bloque de carga
            $('#loadingMessage').show();
            const downloadType = $('#type').val()

            const respose_type = downloadType == 'excel'? 'blob': '';
            // Realiza la solicitud AJAX
            $.ajax({
                type: 'POST',
                url: '/local/users_courses/download.php',
                data: {
                    type: downloadType 
                },
                xhrFields: {
                    responseType: respose_type
                },
                success: function (response, textStatus, xhr) {
                    $('#loadingMessage').hide();
                    // Procesa la respuesta según el tipo de descarga
                    switch (downloadType) {
                        case 'excel':

                            var filename = 'file.xlsx';
    
                            var disposition = xhr.getResponseHeader('Content-Disposition');
                            if (disposition && disposition.indexOf('attachment') !== -1)
                            {
                                var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                                var matches = filenameRegex.exec(disposition);
                                if (matches != null && matches[1])
                                { 
                                    filename = matches[1].replace(/['"]/g, '');
                                }
                            }
    
                            // Download file 
                            var a = document.createElement('a');
                            var url = window.URL.createObjectURL(response);
                            a.href = url;
                            a.download = filename;
                            document.body.append(a);
                            a.click();
                            a.remove();
                            window.URL.revokeObjectURL(url);

                            $('#successMessage').show();
                            break;
    
                        case 'json':
                            // Crea un enlace de descarga para el archivo JSON
                            var blobJson = new Blob([JSON.stringify(response)], { type: 'application/json' });
                            var linkJson = document.createElement('a');
                            linkJson.href = window.URL.createObjectURL(blobJson);
                            linkJson.download = 'users_data_json.json';
                            linkJson.click();

                            $('#successMessage').show();
                            break;

                        case 'ods':
                            // Descarga el archivo ODS
                            var blobOds = new Blob([response], { type: 'application/vnd.oasis.opendocument.spreadsheet' });
                            var linkOds = document.createElement('a');
                            linkOds.href = window.URL.createObjectURL(blobOds);
                            linkOds.download = 'users_data_ods.ods';
                            linkOds.click();

                            $('#successMessage').show();
                            break;

                        case 'csv':
                        case 'html':
                            
                            // Crea un enlace de descarga para el archivo
                            var blob = new Blob([response], { type: 'application/octet-stream' });
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = 'users_data_'+downloadType+'.' + downloadType;
                            link.click();
                            $('#successMessage').show();
                            break;
    
                        default:
                            // Manejar otros tipos si es necesario
                            $('#errorMessage').show();
                            break;

                        
                    }
                },
                error: function (error) {
                    console.error('Error:', error);
                    $('#loadingMessage').hide();
                    $('#errorMessage').show();
                }
            });
        });
    });
}

jQuery(function() {

    download();

});