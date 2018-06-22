import axios from 'axios'
import { API_POST_REQUEST_URL } from '../consts'

// initial state
const state = {
}

// mutations
const mutations = {
}

// actions
const actions = {
  actionUpdateRequestForm ({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.post(API_POST_REQUEST_URL, data)
      .then((response) => {
          resolve(response)
      }).catch((error) => {
          reject(error.response.data)
      })
    })
  }
}

// getters
const getters = {
}

export default {
  state,
  mutations,
  actions,
  getters
}
