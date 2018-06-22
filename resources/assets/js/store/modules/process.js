import axios from 'axios'
import TaskList from '../tasklist'
import * as types from '../mutations_type'
import {
  API_FETCH_ACTIVITI,
  API_GET_LOCATION_URL,
  API_POST_ACTIVITI } from '../consts'

// initial state
const state = {
  numPerPageProcesse: window.argoConfig.process_perpage_count,
  totalProcesses: 0,
  processes: [],
  process: {},
  locations: [],
  processInstance: null,
  taskUnderProcessInstance: null,
  search: {
    searchLocation: {
      regionId: null,
      provinceId: null
    },
    searchStr: ''
  },
  formValues: {}
}

// mutations
const mutations = {
  [types.FETCH_PROCESS_LIST_SUCCESS] (state, data) {
    state.processes = data.data
    state.totalProcesses = data.total
  },
  [types.CLEAN_PROCESS_LIST] (state) {
    state.processes = []
    state.totalProcesses = 0
  },
  [types.FETCH_PROCESS_SUCCESS] (state, data) {
    let processObj = {
      name: data.hasOwnProperty('mainProcess') ? data.mainProcess.name:'',
      currentTask: null,
      startTask: null,
      nextTask: null,
      endTask: null,
      mainProcess: null,
    }
    if (data.hasOwnProperty('mainProcess') && data.mainProcess.hasOwnProperty('flowElements')) {
      const taskList = new TaskList(data.mainProcess)
      processObj.startTask = taskList.getStartElement()
      processObj.endTask = taskList.getEndElement()
      processObj.mainProcess = data.mainProcess
    }
    state.process = processObj
  },
  [types.CLEAN_PROCESS] (state) {
    state.process = null
    state.processInstance = null
    state.taskUnderProcessInstance = null
  },
  [types.FETCH_LOCATIOM_LIST_SUCCESS] (state, data) {
    state.locations = data.regions
  },
  [types.CLEAN_LOCATION_LIST](state) {
    state.process = null
  },
  [types.CREATE_PROCESS_INSTANCE] (state, data) {
    const taskList = new TaskList(state.process.mainProcess)
    state.processInstance = data
    state.process.currentTask = taskList.getElementByID(state.processInstance.activityId)
    state.process.nextTask = taskList.getNextElementByID(state.processInstance.activityId)
  },
  [types.FETCH_PROCESS_INSTANCE_BY_UUID_SUCCESS] (state, data) {
    const taskList = new TaskList(state.process.mainProcess)
    if (data.data.length > 0) {
      state.processInstance = data.data[0]
      state.process.currentTask = taskList.getElementByID(state.processInstance.activityId)
      state.process.nextTask = taskList.getNextElementByID(state.processInstance.activityId)
    } else {
      state.processInstance = null
      state.process.nextTask = taskList.getStartElement()
    }
  },
  [types.CLEAN_PROCESS_INSTANCE] (state, data){
    state.processInstance = null
  },
  [types.FETCH_TASK_UNDER_PROCESS_INSTANCE] (state, data) {
    if (data.data.length > 0) {
      state.taskUnderProcessInstance = data.data[0]
      const taskList = new TaskList(state.process.mainProcess)
      state.process.currentTask = taskList.getElementByID(state.taskUnderProcessInstance.taskDefinitionKey)
      state.process.nextTask = taskList.getNextElementByID(state.taskUnderProcessInstance.taskDefinitionKey)
    } else {
      state.taskUnderProcessInstance = null
      state.process.currentTask = null
    }
  },
  [types.CLEAN_TASK_UNDER_PROCESS_INSTANCE] (state, data) {
    state.taskUnderProcessInstance = null
  },
  [types.UPDATE_SEARCH_LOCATION] (state, data) {
    state.search['searchLocation'] = {
      regionId: data.regionId,
      provinceId: data.provinceId
    }
  },
  [types.UPDATE_SEARCH_STRING] (state, data) {
    state.search['searchStr'] = data
  },
  [types.CLEAN_SEARCH] (state) {
    state.search = {
      searchLocation: {
        regionId: null,
        provinceId: null
      },
      searchStr: ''
    }
  }
}

// actions
const actions = {
  actionUpdateSearchLocation({commit}, data) {
    commit(types.UPDATE_SEARCH_LOCATION, data)
  },
  actionUpdateSearchString({ commit }, data) {
    commit(types.UPDATE_SEARCH_STRING, data)
  },
  actionCleanSearch({commit}) {
    commit(types.CLEAN_SEARCH)
  },
  actionCleanProcess({commit}) {
    commit(types.CLEAN_PROCESS)
  },
  actionGetProcessModelAndInstance({ commit, rootState}, id) {
    return new Promise((resolve, reject) => {
      commit(types.DO_LOADING, { root: true })
      const processDefinitionId = id
      var fetchProcessModel = ()=> {
        return axios.get(API_FETCH_ACTIVITI, {
          params: {
            url: `repository/process-definitions/${processDefinitionId}/model`
          }
        })
      }

      var fetchExistProcessInstance = ()=> {
        return axios.get(API_FETCH_ACTIVITI, {
          params: {
            url: 'runtime/process-instances/',
            processDefinitionId: processDefinitionId,
            businessKey: rootState.UUID,
            suspended: false
          }
        })
      }
      axios.all([fetchProcessModel(), fetchExistProcessInstance()])
      .then(axios.spread(function (processModelResponse, processInstanceResponse) {
          commit(types.FETCH_PROCESS_SUCCESS, processModelResponse.data)
          commit(types.FETCH_PROCESS_INSTANCE_BY_UUID_SUCCESS, processInstanceResponse.data)
          commit(types.DONE_LOADED, { root: true })
          resolve()
        })).catch((error) => {
          commit(types.CLEAN_PROCESS)
          commit(types.CLEAN_PROCESS_INSTANCE)
          commit(types.DONE_LOADED, { root: true })
          console.log(error)
          reject(error.response.data)
        })
    })
  },
  actionGetLocation({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(API_GET_LOCATION_URL)
        .then((response) => {
          commit(types.FETCH_LOCATIOM_LIST_SUCCESS, response.data)
          resolve()
        }).catch((error) => {
          commit(types.CLEAN_LOCATION_LIST)
          reject(error.response.data)
        })
    })
  },
  actionGetProcessList({ commit, state}, page=0) {
    return new Promise((resolve, reject) => {
      commit(types.DO_LOADING, { root: true })

      const parseLocationStr = function(data) {
        let locationStr = null
        if (data.regionId) {
          const regionId = data.regionId
          const provinceId = data.provinceId
          const locationObj = _.find(state.locations, { id: data.provinceId })
          const locationSubObj = _.find(locationObj.regions, { id: data.regionId })
          locationStr = locationObj.name + ' ' + locationSubObj.name
        } else if (data.provinceId) {
          const provinceId = data.provinceId
          const locationObj = _.find(state.locations, { id: data.provinceId })
          locationStr = locationObj.name
        }
        return locationStr
      }

      const searchKey = []
      if (parseLocationStr(state.search.searchLocation)) { searchKey.push(parseLocationStr(state.search.searchLocation)) }
      if (state.search.searchStr.length) { searchKey.push(state.search.searchStr) }

      axios.get(API_FETCH_ACTIVITI, {
        params: {
          url: '/repository/process-definitions',
          suspended: false,
          nameLike: `%${searchKey.join('%')}%`,
          start: state.numPerPageProcesse * page,
          size: state.numPerPageProcesse}
      })
      .then((response) => {
        commit(types.FETCH_PROCESS_LIST_SUCCESS, response.data)
        commit(types.DONE_LOADED, { root: true })
        resolve()
      }).catch((error) => {
        commit(types.CLEAN_PROCESS_LIST)
        commit(types.DONE_LOADED, { root: true })
        reject(error.response.data)
      })
    })
  },
  actionCreateProcessInstance({ commit, rootState, state }, data) {
    return new Promise((resolve, reject) => {
      commit(types.DO_LOADING, { root: true })
      let variables = []
      if(state.process.startTask.formProperties.length > 0) {
        _.forEach(state.process.startTask.formProperties, function(formProperty) {
          variables.push({
            name: formProperty.id,
            value: data.formValues.hasOwnProperty(formProperty.id) ? data.formValues[formProperty.id] : null
          })
        })
      }
      axios.post(API_POST_ACTIVITI, {
          url: 'runtime/process-instances/',
          processDefinitionId: data.processDefinitionId,
          businessKey: rootState.UUID,
          variables: variables
      })
      .then((response) => {
        commit(types.CREATE_PROCESS_INSTANCE, response.data)
        commit(types.DONE_LOADED, { root: true })
        resolve()
      })
      .catch((error) => {
        commit(types.DONE_LOADED, { root: true })
        console.log(error)
        reject(error.response.data)
      })
    })
  },
  actionGetTask({ commit, state }) {
    return new Promise((resolve, reject) => {
      commit(types.DO_LOADING, { root: true })
      axios.get(API_FETCH_ACTIVITI, {
        params: {
          url: 'runtime/tasks',
          processInstanceId: state.processInstance.id}
      })
      .then((response) => {
        commit(types.FETCH_TASK_UNDER_PROCESS_INSTANCE, response.data)
        commit(types.DONE_LOADED, { root: true })
        resolve()
      })
      .catch((error) => {
        commit(types.DONE_LOADED, { root: true })
        reject(error.response.data)
      })
    })
  },
  actionCompletedTask({commit, state}, data) {
    return new Promise((resolve, reject) => {
      commit(types.DO_LOADING, { root: true })
      let variables = []
      if(state.process.currentTask.formProperties.length > 0) {
        _.forEach(state.process.currentTask.formProperties, function(formProperty) {
          variables.push({
            name: formProperty.id,
            value: data.formValues.hasOwnProperty(formProperty.id) ? data.formValues[formProperty.id] : null
          })
        })
      }
      const taskId = state.taskUnderProcessInstance.id
      axios.post(API_POST_ACTIVITI, {
        url: `runtime/tasks/${taskId}`,
        action: 'complete',
        variables: variables,
      })
      .then((response) => {
        resolve()
      })
      .catch((error) => {
        console.log(error)
        reject(error.response.data)
      })
    })
  }
}

// getters
const getters = {
  getProcess: (state) => {
    return state.process
  },
  getNumPerPageProcesse: (state) => state.numPerPageProcesse,
  getNumTotalProcesse: (state) => state.totalProcesses,
  getProcesses: (state) => state.processes,
  getLocations: (state) => state.locations,
  getProcessInstance: (state) => state.processInstance,
  getActiveTaskId: (state) => {
    if (state.taskUnderProcessInstance || state.processInstance) {
      return state.taskUnderProcessInstance ? state.taskUnderProcessInstance.taskDefinitionKey : state.processInstance.activityId
    }
    return null
  },
  getProcessSearch: (state) => state.search
}

export default {
  state,
  mutations,
  actions,
  getters
}
