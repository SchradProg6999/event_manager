
    function replaceData(link, id){
        $.ajax({
            url : link,
            type : 'post',
            success: function(data) {
                $('.' + id).html(data);
            },
            error: function() {
                $('.' + id).text('An error occurred');
            }
        });
    }
