try {
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}})
    $(document).ajaxStart(() => body.addClass('loading'))
    $(document).ajaxStop(() => body.removeClass('loading'))
    $(document).ajaxError(function (event, jqxhr, settings, thrownError) {
        if (thrownError !== undefined && thrownError === 'Unauthorized') {
            window.location.reload();
        }
    });
} catch (e) {
    console.log('jquery was not loaded')
}

import './bootstrap';
