$(document)
    .ready(function() {})
    .on('click', '.open_popup', function (event) {
        $('#' + $(event.currentTarget).data('target')).show(500)
    })
    .on("click", ".preview-container .upload", function (event) {
        event.preventDefault();
        $(event.target).parent().siblings('.image-upload').click();
    })
    .on('change', '.image-upload', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function() {
            let preview = $(event.target).siblings('.preview-container').find('.preview');

            if(preview.hasClass('hidden'))
                preview.removeClass("hidden")

            preview.attr('src', reader.result);
        };

        reader.readAsDataURL(file);
    })
    .on('mouseover mouseout', '.upload', function(event) {
        if(!$(".preview").attr('src'))
            return;

        let z_index = 0;
        if(event.type === 'mouseover') {
            z_index = 11;
        }

        $(".upload").css({zIndex: z_index})
    })
    .on('click', '.popup, .popup-close', function(event) {

        if(!(event.currentTarget.classList.contains('popup-close') || $(event.currentTarget).closest('.popup-close').length ||
            event.target === event.currentTarget))
            return;

        $(event.currentTarget).closest('.popup').hide(500);
    })
    .on('submit', "#photo-upload", function (event) {
        event.preventDefault();

        let form = $("#photo-upload");
        console.log(form)
        let data = new FormData(form[0]);

        if(!data.get("image").name) {
            $('.error-message').animate({opacity: 1}, 300);
            return true;
        }

        $.ajax({
            method: "POST",
            url: form.attr("action"),
            data: data,
            contentType: false,
            cache: false,
            processData: false
        })
        .done(function (response) {
            $(event.currentTarget).closest('.popup').hide(500);
            setTimeout(function () {
                form.trigger("reset");
                form.find(".preview").attr("src", "");
                $('.error-message').css({opacity: 0});
            }, 500);

            response = JSON.parse(response);

            if($('.card').length < 9 && response.success) {
                let empty_album = $('#album_empty');
                if(empty_album.length) {
                    empty_album.parent().append("<div class='cards'></div>");
                    empty_album.remove();
                }

                $('.cards').prepend(response.card);

            } else if($('.card').length >= 9) {
                location.reload();
            }
        })
    })
