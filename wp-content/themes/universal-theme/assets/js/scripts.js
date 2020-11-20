var mySwiper = new Swiper('.swiper-container', {
    // Optional parameters
    loop: true,
    spaceBetween: 100,
    autoplay: {
        delay: 5000,
    },
    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
    },
})
let menuToggle = $('.header-menu-toggle');
menuToggle.on('click', function(event){
    event.preventDefault();
    $('.header-nav').slideToggle(200);
});

$(function(){
    $("a[href^='#']").click(function(){
            var _href = $(this).attr("href");
            $("html, body").animate({scrollTop: $(_href).offset().top+"px"});
            return false;
    });
});

let contactsForm = $('.contacts-form');

contactsForm.on('submit', function (event) {
    event.preventDefault();
    var formData = new FormData(this);
    formData.append('action', 'contacts_form');
    $.ajax({
        type: "POST",
        url: adminAjax.url,
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log('Ответ сервера: ' + response)
        },
        error : function (data) {
            alert (data);
        }
    });
});