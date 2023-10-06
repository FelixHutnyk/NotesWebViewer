var converter = new showdown.Converter();

$(document).ready(function () {
    console.log('Reader Loaded');

    $.ajax({
        url: "README.md",
        cache: false,
        dataType: "html",
        success: function (data) {
            $('.preview').first().html(converter.makeHtml(data));
        },
        error: function () {
            $('.preview').first().html(converter.makeHtml($('.loading').first().text()));
        }
    });

    $("a").click(function (evt) {
        evt.preventDefault();
        var url = evt.target.href
        $.ajax({
            url: url,
            cache: false,
            dataType: "html",
            success: function (data) {
                $('.preview').empty();

                if (url.endsWith(".md")) {
                    $('.preview').first().html(converter.makeHtml(data));
                    $('#preview').addClass('md');
                    $('#preview').removeClass('txt');
                }
                else if (url.endsWith(".pdf")) {
                    $('.preview').append('<iframe src="' + url + '" type="application/pdf"></iframe>')
                    $('#preview').removeClass('md');
                    $('#preview').removeClass('txt');
                }
                else {
                    $('.preview').first().html(converter.makeHtml(data));
                    $('#preview').removeClass('md');
                    $('#preview').addClass('txt');
                }
            }
        })
    })

    $('.collapse-dir').children('ul').slideToggle();
    $('.collapse-dir').click(function (e) {
        if (e.target === this) {
            e.stopPropagation();
            $(this).children('ul').slideToggle();
        }
    });

    

    
    $('.collapse-dir').click(function (e) {
        if (e.target === this) {
            e.stopPropagation();
            var folderId = $(this).find('.folder-id').val();
            toggleFolderState(folderId, function () {
                $(this).children('ul').slideToggle();
            }.bind(this));
        }
    });

    function toggleFolderState(folderId, callback) {
        $.ajax({
            type: 'POST',
            url: 'navbar.php',
            data: {
                action: 'toggleFolder',
                folderId: folderId
            },
            success: function (data) {
                if (data === 'success') {
                } else {
                    console.error('Failed to toggle folder state');
                }
            }
        });
    }

});