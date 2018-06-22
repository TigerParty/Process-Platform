<template>
  <div class="step-item p-2" :class="{'active': isActive, 'success': isSuccess&&!isActive}">
   Step {{ stepIndex }}
   <i class="fa fa-check float-right" :class="{'text-white': isSuccess&&!isActive, 'text-darker':  isSuccess&&isActive}" aria-hidden="true" v-show="isSuccess"></i>
  </div>
</template>

<script>
  export default{
    props: {
      stepIndex: {
        type: String,
        default: 0
      },
      stepNumber: {
        type: Number,
        default: 1
      },
      isActive: {
        type: Boolean,
        default: false
      },
      isSuccess: {
        type: Boolean,
        default: false
      },
    }
  }
</script>

<style lang="sass" scoped>
  .step-item
    background-color: #18689f
    border: solid 1px #979797
    color: #fff
    font-weight: 300
    font-size: 0.8rem
    &.active
      background-color: #fff
      border-color: #18689f
      color: #3e9ada
      font-weight: 400
    &.success
      background-color: #3e9ada
      color: #fff
      font-weight: 400
    i
      font-size: 1.2rem
</style>