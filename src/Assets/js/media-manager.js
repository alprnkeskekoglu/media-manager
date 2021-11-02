var current_id;
$('body').delegate('.mediaManagerBtn', 'click', function () {
    current_id = $(this).attr('data-id');
    var max_count = $(this).attr('data-maxCount');
    var selectable = $(this).attr('data-selectable');
    var selected_media_ids = $('#' + current_id).val();

    window.open(
        '/dawnstar/media-manager?maxCount=' + max_count + '&selectable=' + selectable + (selected_media_ids ? '&selectedMediaIds=' + selected_media_ids : ''),
        'Dawnstar Media Manager', 'width=1280,height=880'
    );
});

$('body').delegate('.removeMediaBtn', 'click', function () {
    var media_id = $(this).attr('data-id');
    var selected_media_ids = $(this).closest('.mediaBox').find('input').val();
    selected_media_ids = selected_media_ids.split(',');

    var index = selected_media_ids.indexOf(media_id);
    if (index !== -1) {
        selected_media_ids.splice(index, 1);
    }

    $(this).closest('.mediaBox').find('input').val(selected_media_ids.join(','))
    $(this).closest('.avatar-xl').remove();
});

function handleMediaManager(medias) {
    var ids = '';
    var mediaHtml = '';

    if (medias.length) {
        $.each(medias, function (index, data) {
            ids += data.id + ',';
            mediaHtml += '' +
                '<div class="avatar-xl position-relative" style="background-color: #efefef;">' +
                '<img src="' + data.image + '" class="img-fluid mh-100">' +
                '<span class="d-block text-center text-muted">' + data.full_name + '</span>' +
                '<div class="d-grid end-0 mb-n1 me-n2 position-absolute bottom-0">'+
                '<a href="javascript:void(0);" class="removeMediaBtn" data-id="' + data.id + '">' +
                '<span class="badge bg-white rounded-pill shadow-sm">' + '<i class="font-14 mdi mdi-close text-danger"></i>' + '</span>' +
                '</a>' +
                '</div>' +
                '</div>';
        });
    } else {
        mediaHtml += '' +
            '<div class="avatar-xl position-relative">' +
            '<img src="https://via.placeholder.com/150" class="img-fluid mh-100">' +
            '</div>';
    }

    ids = ids.replace(/,\s*$/, "")
    $('#' + current_id).val(ids);
    $('#' + current_id).closest('.mediaBox').find('.mediaList').html(mediaHtml);
}
