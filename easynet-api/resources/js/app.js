require('./bootstrap');

import Vue from 'vue'
import Home from './views/home/index'

new Vue({
    el: '#home',
    component: {Home},
    render:h=>h(Home)
})