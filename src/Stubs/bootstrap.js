try {
    window.$ = window.jQuery = require('jquery');
    window.$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': window.$('meta[name="csrf-token"]').attr('content')
        }
    });
    window.$(document).ajaxStart(function () {
        window.$('body').addClass('loading');
    });
    window.$(document).ajaxStop(function () {
        window.$('body').removeClass('loading');
    });
    window.$(document).ajaxError(function (event, jqxhr, settings, thrownError) {
        if (thrownError !== undefined && thrownError === 'Unauthorized') {
            window.location.reload();
        }
    });
} catch (e) {
}

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
