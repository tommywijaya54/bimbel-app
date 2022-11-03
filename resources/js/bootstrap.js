import _ from 'lodash';
window._ = _;
window.locale = {
    code: "id-ID",
    dateFormat : { year: 'numeric', month: 'short', day: '2-digit' },
    dayFormat :  {weekday: 'long'},
    timeFormat:{hour: '2-digit', minute: '2-digit'},
    currency:{
        sign:'Rp.'
    }
};

window.dn = {
    day (date) {
        return (new Date(date)).toLocaleDateString(locale.code, { weekday: 'long' }); 
    },
    date (date) {
        return (new Date(date)).toLocaleDateString(locale.code, locale.dateFormat); 
    },
    time (value) {
        return value.substring(0,5);
    },
    month (date) {
        return (new Date(date)).toLocaleDateString(locale.code, { month: 'short' }); 
    },
    long_month (date) {
        return (new Date(date)).toLocaleDateString(locale.code, { month: 'long' }); 
    },
    remove_second (str) {
        return str.substring(0,5);
    },
    getToday (){
        const dateAnchor = new Date();
        return (new Date(dateAnchor.getFullYear(), dateAnchor.getMonth(), dateAnchor.getDate()));
    },
    justDate(date){
        const dateAnchor = new Date(date);
        return (new Date(dateAnchor.getFullYear(), dateAnchor.getMonth(), dateAnchor.getDate()));
    },
    setTime(date,time) {
        return new Date(date.getFullYear(),date.getMonth(),date.getDate(),...time.split(':'));
    },
    setDateForServer(date){
        const addZero = (d) => {
            const y = d.toString();
            return y.length == 1 ? '0'+y : y;
        }
        const year = date.getFullYear();
        const month = addZero(date.getMonth()+1);
        const day = addZero(date.getDate());
        const hours = addZero(date.getHours());
        const minutes = addZero(date.getMinutes());

        return year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":00";
    }
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

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



// Adding Capitalisation function on String 
String.prototype.cap = function (){
    return (this.charAt(0).toUpperCase() + this.slice(1));
}

