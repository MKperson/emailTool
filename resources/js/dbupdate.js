

jQuery(document).ready(function($){

    function update() {
        alert('Running update.');
        var ph = $('#phase').value();

        $.ajax({
            url: '/update',
            type: 'POST',
            data: {
                phase: ph
            },
            success: function(response) {
                console.log('Success: ' + response);
            },
            error: function(xhr, errorCode, errorThrown) {
                console.log(xhr.responseText);
            }
        })
    }
    });
