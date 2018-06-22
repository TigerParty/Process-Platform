import Vue from 'vue'
import Vuex from 'vuex'
import { state, mutations } from './mutations'
import * as getters from './getters'
import request from './modules/request'
import process from './modules/process'


Vue.use(Vuex);


export default new Vuex.Store({
    state,
    mutations,
    getters,
    modules: {
        request,
        process
    },
    strict: true
})