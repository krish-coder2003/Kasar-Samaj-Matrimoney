import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

const broadcaster = window.laravelBroadcaster ?? import.meta.env.VITE_BROADCASTER ?? 'reverb';

if (broadcaster === 'pusher') {
    const key = window.laravelPusherKey ?? import.meta.env.VITE_PUSHER_APP_KEY;
    if (key) {
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: key,
            cluster: window.laravelPusherCluster ?? import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
            forceTLS: true
        });
    } else {
        console.warn("Pusher app key is missing. Echo real-time chat cannot be initialized.");
    }
} else {
    const key = window.laravelReverbKey ?? import.meta.env.VITE_REVERB_APP_KEY;
    if (key) {
        window.Echo = new Echo({
            broadcaster: 'reverb',
            key: key,
            wsHost: window.laravelReverbHost ?? import.meta.env.VITE_REVERB_HOST ?? window.location.hostname,
            wsPort: window.laravelReverbPort ?? import.meta.env.VITE_REVERB_PORT ?? 80,
            wssPort: window.laravelReverbPort ?? import.meta.env.VITE_REVERB_PORT ?? 443,
            forceTLS: (window.laravelReverbScheme ?? import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
            enabledTransports: ['ws', 'wss'],
        });
    } else {
        console.warn("Reverb app key is missing. Echo real-time chat cannot be initialized.");
    }
}

