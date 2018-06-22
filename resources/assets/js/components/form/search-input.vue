<template>
  <div class="row">
    <div class="col-11">
      <div class="bg-white row m-0">
        <div class="input-group search-block col-12 px-0">
          <span class="input-group-addon border-0">
            <i class="fa fa-search" aria-hidden="true"></i>
          </span>
          <input type="text" class="form-control form-control-lg px-1 border-0" v-model="searchStr" @input="debounceInput" :placeholder="placeholderStr">
        </div>
      </div>
    </div>
    <div class="col-1 align-self-center">
      <label class="text-white mb-0" v-on:click="clear">Clear</label>
    </div>
  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  window._ = require('lodash')

  export default {
    props: {
      placeholderStr: {
        type: String,
        default: ''
      },
      onClick: {
          type: Function
      }
    },
    computed: {
      ...mapGetters({
          search: 'getProcessSearch'
      }),
    },
    data() {
      return {
        searchStr: ''
      }
    },
    methods: {
      ...mapActions([
        'actionGetProcessList',
        'actionUpdateSearchString',
        'actionCleanSearch'
      ]),
      debounceInput: _.debounce(function (e) {
          this.searchChanged()
      }, 1000),
      searchChanged: function() {
        this.actionUpdateSearchString(this.searchStr)
        this.$emit('searchChanged')
      },
      clear: function() {
        if(this.searchStr.length) {
          this.actionCleanSearch()
          this.searchStr = '',
          this.$emit('searchChanged')
        }
      }
    },
    beforeMount: function() {
      this.searchStr = this.search.searchStr
    }
  }
</script>

<style lang="sass" scoped>
  .search-block
    cursor: pointer
    .input-group-addon, input
      background-color: #ffffff
      border-radius: 0px
    .input-group-addon
      border-right: none
      i
        color: #3c3c3c
        opacity: 0.8
        font-size: 1.2rem
    input
      border-left: none
      height: 55px
      font-size: 14px
      &:focus
        box-shadow: none
  .region-block
    border-left: 1px #000 solid
    select
      height: 55px!important
</style>