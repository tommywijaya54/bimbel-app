import _ from 'lodash';
window._ = _;

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

String.prototype.toDisplayElement = function (){
    const entityname = this.split(",")[0];
    let label = this.split(',')[1] || entityname.cap();
    
    if(entityname === "id"){
        label = "ID"
    }
    if(entityname.includes('_')){
        label = (entityname.split('_')).map((str) => {
            return str.cap()
        }).join(" ");
    }

    return {
        entityname : entityname,
        label : label
    }
}


// Adding Current App & Current User 
class CurrentApp{
    constructor (el_id = 'app') {
        this.el = document.getElementById(el_id);
        this.data = JSON.parse(this.el.dataset.page);
    }
}
window.current_app = new CurrentApp();


class CurrentUser{
    constructor () {
        this._app = window.current_app || new CurrentApp();
        this._data = this._app.data.props.auth.user;
        this.name = this._data.name;
        this.type = this._data.type;
        this.permissions = this._app.data.props.auth.permissions;
        this.roles = this._app.data.props.auth.roles;
    }

    hasPermission(prm){
        return this.permissions.includes(prm);
    }
    hasRole(rl){
        return this.roles.includes(rl);
    }
}
window.current_user = new CurrentUser();
    