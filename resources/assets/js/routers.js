import Vue from 'vue';
import VueRouter from 'vue-router'

Vue.use(VueRouter);


let routes = [

    { path: '/', layout: 'master',component: require('./containers/master'), children: [
        { path: '', name: 'index', component: require('./containers/index')},
        { path: '/process/:id', name: 'process', component: require('./containers/process')},
        ]
    }

]


export default new VueRouter({
    routes,
})