<template>
  <div class="row justify-content-center py-4 header" :class="{'none-bottom-border': isIndex}">
    <div class="col-12 col-md-10 height-100-percent max-content-width">
      <div class="row justify-content-between height-inherit">
        <div class="col-12 col-sm-8 logo-block height-inherit">
          <img class="cursor-pointer" :src="'/images/Zambia_Logo.svg'" v-on:click="toHomePage">
          <span class="logo-title mb-0 ml-4 align-middle">Land of Zambia</span>
          <a v-if="isIndex"  :href="submitPageLink" class="report-link d-block d-sm-none float-right"><i class="fa fa-paper-plane  mt-3" aria-hidden="true" v-ga="$ga.commands.trackOnClickButton.bind(this, 'Report Corruption')"></i></a>
          <i v-else class="fa fa-reply float-right mt-3 d-block d-sm-none cursor-pointer" aria-hidden="true" v-on:click="goBack"></i>
        </div>
        <div class="col-12 col-sm-4 text-right d-none d-sm-block">
          <a :href="submitPageLink" v-if="isIndex" class="report-link" v-ga="$ga.commands.trackOnClickButton.bind(this, 'Report Corruption')">Report Corruption</a>
          <div v-else class="report-link cursor-pointer" v-on:click="goBack"> < Back </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        submitPageLink: window.argoConfig.submit_report
      }
    },
    props: {
      isIndex: {
        type: Boolean,
        default: false
      },
      isRequest: {
        type: Boolean,
        default: false
      }
    },
    methods: {
      toHomePage: function() {
        this.$router.push({name: 'index'})
      },
      goBack: function() {
        this.$router.go(-1)
      }
    }
  }
</script>

<style lang="sass" scoped>
  .header
    background-color: #3e9ada
    border: solid 1px #979797
    &.none-bottom-border
      border-bottom: none
    @media (min-width: 576px)
      height: 120px
    @media (min-width: 768px)
      height: 150px
    .logo-block
      height: 50px
      @media (min-width: 576px)
        height: inherit
      img
        height: 100%
        width: auto
      span.logo-title
        color: #fff
        font-size: 1.2rem
        font-weight: 500
        @media (min-width: 576px)
          font-size: 1.4rem
        @media (min-width: 768px)
          font-size: 1.8rem
      i
        color: #fff
    .report-link
      text-decoration: underline
      color: #fff
      display: inline-block
      @media (min-width: 576px)
        font-size: 1rem
        line-height: 70px
      @media (min-width: 768px)
        font-size: 1.4rem
        line-height: 100px
</style>
