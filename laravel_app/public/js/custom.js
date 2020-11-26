(function () {
    'use strict';

    const mainImg = document.getElementsByClassName('main-img')[0];
    const thumbItemImgs = document.getElementsByClassName('thumb-item-img');

    [...thumbItemImgs].forEach(thumbItemImg => {
        thumbItemImg.onmouseover = (e) => {
            const newImgSrc = e.currentTarget.getAttribute('src');
            mainImg.setAttribute('src', newImgSrc);
            document.getElementsByClassName('is-active')[0].classList.remove('is-active');
            e.currentTarget.classList.add('is-active');
        };
    });

    $('#file').change(function(){
        var files = $('#file').prop("files")
        var names = $.map(files, function(val) { return val.name; });
        var anyWindow = window.URL || window.webkitURL;
        for (var i = 0; i < names.length; i++) {
            var objectUrl = anyWindow.createObjectURL(files[i]);
            $('#imagePreview').append('<img src="' + objectUrl + '" name="'+ names[i] +'" class="img-list-item"/>');
        }
    })

    $('#imagePreview').on('click', 'img', function() {
        var images = $('#imagePreview img').removeClass('selected'),
            img = $(this).addClass('selected');
        
        $('#thumbnail').val(images.index(img));
        $('#thumbnail_image').val($('img.img-list-item.selected').attr('name'));
    });
})();
