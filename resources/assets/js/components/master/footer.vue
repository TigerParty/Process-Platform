<template>
  <footer class="row justify-content-center py-3" :class="{'need-border-top': !isIndex}">
    <div class="col-12 col-md-10 max-content-width">
      <div class="row justify-content-between height-inherit">
        <div class="col-12 col-md-6 height-inherit text-center text-md-left">
          <div>About Transparency International</div>
          <img :src="'/images/Footer_Logo.png'">
        </div>
        <div class="col-12 col-md-6 text-center text-md-right right-block">
          <div>&#169;Transparency International 2018.</div>
          <div>Some rights reserved.</div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
  export default {
    props: {
      isIndex: {
        type: Boolean,
        default: false
      }
    }
  }
</script>

<style lang="sass" scoped>
  footer
    color: #818181
    &.need-border-top
      border-top: solid 2px #18689f
    div
      line-height: 18px
    img
      height: 30px
</style>
