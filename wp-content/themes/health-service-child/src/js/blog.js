var page = 2;
jQuery(function($) {
    $('body').on('click', '.loadmore', function() {
        var data = {
            'action': 'load_posts_by_ajax',
            'page': page,
            'security': blog.security
        };
 
        $.post(blog.ajaxurl, data, function(response) {
            if($.trim(response) != '') {
                $('.blogposts').append(response);
                page++;
            } else {
                $('.loadmore').hide();
            }
        });
    });
});


