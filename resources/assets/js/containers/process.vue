<template>
  <div class="row justify-content-center py-4">
    <div class="col-12 col-md-10 height-100-percent max-content-width">
      <div class="row">
        <div class="col-12 order-sm-1 col-sm-8">
          <h4 class="sub-title" v-text="process.name" v-if="process"></h4>
        </div>
      </div>
      <div class="row mt-5"  v-if="process">
        <div class="col-12" v-if="isLoading">
          <loader-component></loader-component>
        </div>
        <div class="col-12" v-else-if="openForm">
          <div class="my-3">
            Please select your region to continue the process
          </div>
          <div class="col-12 col-md-8 px-0 region-block">
            <region-selector
              :location="location"
            ></region-selector>
            <div class="row my-3">
              <div class="col-12">
                <button class="btn btn-primary"
                  v-on:click="goToNext"
                >GO</button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12" v-else>
          <step-content-component :content="process.currentTask"
            :active-complete="nextTaskCheck"
            :process-name="process.name"
            :ga-button-event="sendGAEventWithRequestButton"
          ></step-content-component>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  import Step from '../components/process/step'
  import StepConent from '../components/process/step-content'
  import Loader from "../components/loader"
  import RegionSelector from "../components/process/region-selector"

  export default{
    data() {
      return{
        processId: 1,
        location: {
          province: null,
          district: null
        },
        goingToStart: false,
        goingToNext: false,
      }
    },
    methods: {
      ...mapActions([
        'actionGetProcessModelAndInstance',
        'actionCleanProcess',
        'actionCreateProcessInstance',
        'actionGetTask',
        'actionCompletedTask'
      ]),
      isActive: function(index){
        if(this.curStep == index){
          return true
        }
        return false
      },
      isSuccess: function(index){
        if(index < this.curStep){
          return true
        }
        return false
      },
      nextTaskCheck: function() {
        if(this.process.currentTask && this.process.currentTask.hasOwnProperty('formProperties')) {
          let that = this
          _.forEach(this.process.currentTask.formProperties, function(formProperty) {
            if(!that.location[formProperty.id]) {
              that.goingToNext = true
              return false
            }
          })
          this.goingToNext = that.goingToNext
        }
        if(!this.openForm) {
          this.goingToNext = false
          return this.activityComplete()
        }
      },
      activityComplete: function(){
        let data = {
          formValues: {}
        }
        if(this.location.province || this.location.district) {
          data.formValues.province = this.location.province ? this.location.province : null
          data.formValues.district = this.location.district ? this.location.district : null
        }
        this.actionCompletedTask(data).then(()=> {
          const allStepCompeleted = this.process.nextTask.id == this.process.endTask.id
          this.sendGAEvent(allStepCompeleted)
          if(allStepCompeleted){
            return Promise.reject('finish the process')
          }else{
            return this.actionGetTask()
          }
        }).then(()=> {
          return this.sendGAPageView()
        }).catch((error) => {
          console.log(error)
          this.goToIndex()
        })

      },
      goToIndex: function() {
        return this.$router.push({name: 'index'})
      },
      sendGAPageView: function() {
        return this.$ga.query(
          'send',
          'pageview',
          {
            'title': this.process.name+'-'+(this.process.currentTask ?
              this.process.currentTask.name :
              'start'),
            'location': window.location.href,
            'dimension1': this.process.name,
            'dimension2': this.process.currentTask ? this.process.currentTask.name : 'start',
        })
      },
      sendGAEvent: function(isProcessCompleted) {
        return this.$ga.event(
          'Process',
          this.process.name,
          isProcessCompleted? 'processComplete': 'stepComplete',
          {
            'title': this.process.name+'-'+(this.process.currentTask.name),
            'location': window.location.href,
            'dimension1': this.process.name,
            'dimension2': this.process.currentTask.name,
            'metric1': 1,
            'metric2': isProcessCompleted? 1:0
          }
        )
      },
      sendGAEventWithRequestButton: function(type) {
        return this.$ga.event(
          'Process',
          this.process.name,
          'processButtonActive',
          {
            'title': this.process.name+'-'+(this.process.currentTask.name),
            'location': window.location.href,
            'dimension1': this.process.name,
            'dimension2': this.process.currentTask.name,
            'metric3': type=='request'? 1: 0,
            'metric4': type=='report'? 1: 0
          }
        )
      },
      fetchProcess: function () {
        this.processId = this.$route.params.id
        this.actionGetProcessModelAndInstance(this.processId)
          .then(() => {
            if(!this.processInstance){
              this.goingToStart = true
              if(!this.openForm) {
                this.goToNext()
              }
            } else {
              return this.actionGetTask()
            }
          })
          .then(()=> {
            return this.sendGAPageView()
          })
          .catch((error) => {
            this.goToIndex()
            console.log(error)
          })
      },
      goToNext: function () {
        let data = {
          processDefinitionId: this.processId,
          formValues: {}
        }
        if(this.location.province || this.location.district) {
          data.formValues.province = this.location.province ? this.location.province : null
          data.formValues.district = this.location.district ? this.location.district : null
        }
        if(!this.processInstance) {
          this.actionCreateProcessInstance(data)
            .then(() => {
              this.goingToStart = false
              return this.actionGetTask()
            })
        } else {
          this.goingToNext = false
          return this.activityComplete()
        }
      }
    },
    computed: {
        ...mapGetters({
            process: 'getProcess',
            processInstance: 'getProcessInstance',
            activeStepId: 'getActiveTaskId',
            isLoading: 'checkLoading',
        }),
        curStep: function () {
          return _.findIndex(this.process.steps, ['id', this.activeStepId])
        },
        openForm: function () {
          if(this.process.startTask && this.process.startTask.hasOwnProperty('formProperties') && this.goingToStart) {
            return this.process.startTask.formProperties.length > 0
          } else if(this.process.currentTask && this.process.currentTask.hasOwnProperty('formProperties') && this.goingToNext) {
            return this.process.currentTask.formProperties.length > 0
          }
          return false
        }
    },
    components: {
      'step-component': Step,
      'step-content-component': StepConent,
      'loader-component': Loader,
      'region-selector': RegionSelector,
    },
    created: function() {
      this.fetchProcess()
    },
    destroyed: function() {
      this.actionCleanProcess()
    }
  }
</script>

<style lang="sass" scoped>
  .steps-block
    border-right: solid 2px #979797
  .locaion-icon
    font-size: 1.5rem!important
</style>