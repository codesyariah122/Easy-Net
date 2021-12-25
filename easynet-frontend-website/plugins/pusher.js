import Vue from  'vue'
import VuePusher from 'vue-pusher'

Vue.use(VuePusher, {
    api_key: '665c797be7862b9b448c',
    options: {
        cluster: 'ap1',
        encrypted: true,
    }
});