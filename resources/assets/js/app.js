
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')
window.Vue = require('vue')




/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import router from './routers'
import store from './store/index'
import * as types from './store/mutations_type'
import VueSweetAlert from 'vue-sweetalert'
import VueAnalytics from 'vue-analytics'
import linkify from 'vue-linkify'

Vue.use(VueSweetAlert)

Vue.use(VueAnalytics, {
  id: window.argoConfig.ga_tracking_id,
  debug: {
    enabled: false,
    trace: false,
    sendHitTask: true
  },
  commands: {
    trackOnClickButton(name = 'unknown') {
        this.$ga.event('button', 'click', name)
    }
  }
})

Vue.directive('linkified', linkify)

router.beforeEach((to, from, next) => {
  if(to.name=='process' && !to.query.step){
    next({ path: to.path, query: {step: 1} })
  } else {
    next()
  }
})

const app = new Vue({
    el: '#app',
    router,
    store,
    beforeCreate() {
      this.$store.commit(types.INITIAL_UUID);
    }
});
