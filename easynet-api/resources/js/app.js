require('./bootstrap');
import Pusher from "pusher-js"
import VueEcho from "vue-echo-laravel";
import Vue from 'vue'
import VueAxios from 'vue-axios'
import axios from 'axios'
import Home from './views/home/index'


Pusher.logToConsole = false

Vue.use(VueAxios, axios)

Vue.use(VueEcho, {
  	broadcaster: "pusher",
  	key: process.env.MIX_PUSHER_APP_KEY,
  	cluster: process.env.MIX_PUSHER_APP_CLUSTER,
  	useTLS: true
})


new Vue({
    el: '#home',
    component: {Home},
    render:h=>h(Home)
})