import * as types from "./mutations_type"

export const state = {
  loading: false,
  UUID: null,
};


export const mutations = {
  [types.DO_LOADING] (state) {
    state.loading = true
  },
  [types.DONE_LOADED] (state) {
    state.loading = false
  },
  [types.INITIAL_UUID] (state) {
    if(localStorage.getItem('visitorID')) {
      state.UUID = localStorage.getItem('visitorID')
    }else {
      const UUIDMeta = document.head.querySelector('meta[name="uuid"]')
      if(UUIDMeta){
        const newUUID = UUIDMeta.content
        localStorage.setItem('visitorID', newUUID)
        state.UUID = newUUID
      }
    }
  }
}