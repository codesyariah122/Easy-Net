// import Vue from 'vue';
// import Echo from 'laravel-echo';

// const echo = {};

// echo.install = function (Vue) {
//   Vue.prototype.$pusher = require('pusher-js');
//   Vue.prototype.$echo = new Echo({
//     // authEndpoint: 'http://your-domain.test/api/broadcasting/auth',
//     // auth: {
//     //   headers: {
//     //     Authorization: 'Bearer XXXXXXXXXXXX',
//     //   }
//     // },
//     broadcaster: 'pusher',
//     key: process.env.VUE_WEBSOCKET_APP_KEY,
//     wsHost: process.env.VUE_APP_WEBSOCKETS_SERVER,
//     wsPort: process.env.VUE_APP_WEBSOCKETS_PORT,
//     encrypted: true,
//     disableStats: false,
//   });
// };

import Echo from 'laravel-echo'
window.Pusher = require('pusher-js')
window.Echo =  new Echo({
  broadcaster: 'pusher',
  key: process.env.PUSHER_KEY,
  cluster: process.env.PUSHER_CLUSTER,
  useTLS: true,
  // wsHost: process.env.VUE_APP_WEBSOCKETS_SERVER,
  // wsPort: process.env.VUE_APP_WEBSOCKETS_PORT,
  // forceTLS: false,
  // disableStats: true
})