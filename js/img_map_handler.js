
let classes = document.getElementsByClassName('area-content');

let baseurl = location.protocol+"\/\/toolbox.test/";

let ajaxurl = baseurl+'wp-admin/admin-ajax.php';

$(document).ready(function(){
    $('img[usemap]').rwdImageMaps();
});
't'
for(var i = 0; i < classes.length; i++) {
    classes[i].addEventListener('click',function(e){

        e.preventDefault();
       
        let id = e.currentTarget.id;
        let title = e.currentTarget.title;
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: { action : 'my_action', post_id: id},
            success: function (response) {
                let w = $('#image-dimension').width();
                $('#overlay').width(w);
                $('#overlay').fadeIn().show();
                $("html, #overlay").animate({ scrollTop: "330px" },1000);
                document.getElementById('text-wrapper').innerHTML = '<div id = "close" class = "menu-button menu-button--close2"></div>'+response;
                document.getElementById('close').addEventListener('click',function(){
                    $('#overlay').fadeOut();
                });
            }
        });
    })

    classes[i].addEventListener('mouseover', function(e){
        e.currentTarget.classList.add('hover-class');
    })
}


