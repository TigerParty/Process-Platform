<template>
  <div v-if="content">
    <h4 class="sub-title" v-text="content.name"></h4>
    <div class="row description-block">
      <div class="col-12">
        <description-component
          title="Description"
          :description="content.documentation"></description-component>
      </div>
    </div>
    <div class="row function-buttons">
      <div class="col-12 mb-2">
        <button class="text-center text-white w-100 p-3 cursor-pointer function-btn"
        v-on:click="clickGaTriggerButton('report')"
        v-ga="$ga.commands.trackOnClickButton.bind(this, 'Report Corruption')">
          Report Corruption or Malpractice at this Step
        </button>
      </div>
      <div class="col-12 mb-2">
        <button class="text-center text-white w-100 p-3 cursor-pointer function-btn"
        v-on:click="clickGaTriggerButton('request')"
        v-ga="$ga.commands.trackOnClickButton.bind(this, 'Request more information')">
          Request more information
        </button>
      </div>
      <div class="col-12 mb-2">
        <button class="text-center text-white w-100 p-3 cursor-pointer function-btn" v-on:click="activeComplete()">Activity is Complete</button>
      </div>
    </div>
  </div>
</template>

<script>
import Description from './description'

export default{
  data() {
    return {
      submitPageLink: this.getSubmitUrl()
    }
  },
  props: {
    processName: {
      type: String,
      default: ''
    },
    content: {
      type: Object
    },
    activeComplete: {
      type: Function
    },
    gaButtonEvent: {
      type: Function
    }
  },
  components: {
    'description-component': Description
  },
  methods: {
    getSubmitUrl: function() {
      var param = {};
      param[window.argoConfig.step_name_field_id] = this.content.name
      param[window.argoConfig.process_name_field_id] = this.processName

      return window.argoConfig.submit_report + '?' + $.param(param)
    },
    clickGaTriggerButton: function(type) {
      this.gaButtonEvent(type)

      if(type=="report"){
        window.location.href = this.getSubmitUrl()
      }else{
        this.$router.push({ name: 'request', query: { step_id: this.content.id } })
      }
    }
  },
}
</script>

<style lang="sass" scoped>
  .function-buttons
    .function-btn
      background-color: #18689f
      font-weight: 300
      display: block
      &:hover
        text-decoration: none
</style>