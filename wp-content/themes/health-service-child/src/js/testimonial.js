var page = 2;
jQuery(function($) {
    $('body').on('click', '.loadmore_testimonial', function() {
        var data = {
            'action': 'load_testimonial_by_ajax',
            'page': page,
            'security': testimonial.security
        };
 
        $.post(testimonial.ajaxurl, data, function(response) {
            if($.trim(response) != '') {
                $('.testimonial-list').append(response);
                page++;
            } else {
                $('.loadmore_testimonial').hide();
            }
        });
    });
});


