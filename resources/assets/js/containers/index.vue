<template>
  <div>
    <div class="row justify-content-center banner pt-2 pt-md-4 pt-lg-5  pb-4">
      <div class="col-12 col-md-10 max-content-width">
        <p>
            Step by step guide to Buying, Selling & <br/>
            Acquiring Land in Zambia
        </p>
        <div class="row">
          <div class="col-12 col-sm-10 col-md-8">
            <search-component
            v-on:searchChanged="fetchProcess"
            placeholder-str="Search for the land process you need help with"
            :onClick="toResult"></search-component>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center py-5 category-block">
      <div class="col-12 col-md-10 max-content-width" >
        <div class="summary mb-4">WHAT PROCESS DO YOU NEED HELP WITH?</div>
        <loader-component  v-if="isLoading"></loader-component>
        <div class="row" v-else>
          <div class="col-12 col-sm-4 col-md-3 py-1" v-for="(process, idx) in processes" :key="idx" v-if="processes.length">
            <router-link :to="{name: 'process', params: { id: process.id }}" class="category-item">
              <span>
                {{ process.name?process.name: process.key }}
              </span>
            </router-link>
          </div>
          <h4 class="col-12 text-secondary text-center" v-if="!processes.length"> There is no process to show. </h4>
          <nav class="col-12 mt-4" v-if="processes.length">
            <ul class="pagination justify-content-center">
              <li class="page-item" :class="{'disabled': currentPage==0}">
                <label class="page-link" v-on:click="onClickPage(currentPage-1)">Previous</label>
              </li>
              <li class="page-item" v-for="pageNum in totalPage" :key="pageNum" :class="{'active': currentPage==(pageNum-1)}">
                <label class="page-link" v-on:click="onClickPage(pageNum-1)">{{pageNum}}</label>
              </li>
              <li class="page-item" :class="{'disabled': currentPage==(totalPage-1)}" >
                <label class="page-link" v-on:click="onClickPage(currentPage+1)">Next</label>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <div class="row justify-content-center py-5 submit-report-block">
      <div class="col-12 col-md-10 height-100-percent max-content-width">
        <div class="row justify-content-between height-inherit">
          <div class="col-12 col-sm-8 col-md-9 height-inherit submit-report-subscription">
            <h2>Report Corruption, Inefficiency or Land-Grabbing</h2>
            <span>Your information will kept private and comfidential</span>
          </div>
          <div class="col-12 col-sm-4 col-md-3 text-right">
            <a :href="submitPageLink" class="submit-report-link height-100-percent" v-ga="$ga.commands.trackOnClickButton.bind(this, 'Report Corruption')">
              <span>SUBMIT REPORT</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  import Search from "../components/form/search-input"
  import Loader from "../components/loader"

  export default {
    data() {
      return {
        submitPageLink: window.argoConfig.submit_report,
        currentPage: 0
      }
    },
    components: {
      'search-component': Search,
      'loader-component': Loader,
    },
    computed: {
        ...mapGetters({
            processes: 'getProcesses',
            isLoading: 'checkLoading',
            perCount: 'getNumPerPageProcesse',
            totalProcesse: 'getNumTotalProcesse'
        }),
        totalPage: function () {
          return Math.ceil(this.totalProcesse / this.perCount)
        }

    },
    methods: {
      ...mapActions([
        'actionGetProcessList',
      ]),
      toResult: function(value){
        this.$router.push({ name: 'search', query: {
          keyword: value
        }})
      },
      onClickPage: function(goToPage) {
        if(this.currentPage != goToPage) {
          this.fetchProcess(goToPage)
        }
      },
      fetchProcess: function(pageNum=0) {
        this.actionGetProcessList(pageNum).then(() => {
          this.currentPage = pageNum
        }).catch((error) => {
          console.log(error)
        })
      }
    },
    mounted: function() {
      this.fetchProcess()
    }
  }

</script>

<style lang="sass" scoped>
    .banner
      background-color: #3e9ada
      border: solid 1px #979797
      border-top: none
      p
        font-size: 1rem
        font-weight: 500
        color: #fff
        @media (min-width: 576px)
          font-size: 1.2rem
        @media (min-width: 768px)
          font-size: 1.5rem
    .category-block
      .summary
        font-family: 'Roboto'
        font-size: 1rem
        font-weight: 400
        color: #3c3c3c
        @media (min-width: 576px)
          font-size: 1.3rem
      .category-item
        background-color: #18689f
        width: 100%;
        min-height: 80px
        text-align: center
        position: relative
        display: block
        overflow: hidden
        @media (min-width: 576px)
          min-height: 150px
        span
          color: #fff
          width: 80%
          font-family: 'Roboto'
          font-size: 1rem
          font-weight: 400
          position: absolute
          left: 50%
          top: 50%
          line-height: 28px
          transform: translate(-50%,-50%)
    .submit-report-block
      background-color: #3e9ada
      border: solid 1px #979797
      .submit-report-subscription
        h2, span
          color: #fff
        h2
          font-size: 1.3rem
          @media (min-width: 768px)
            font-size: 1.5rem
      .submit-report-link
        background-color: #18689f
        width: 100%;
        text-align: center
        position: relative
        display: block
        min-height: 50px
        margin-top: 20px
        @media (min-width: 576px)
          margin-top: 0px
        span
          color: #fff
          width: 100%
          font-family: 'Roboto'
          font-size: 1rem
          font-weight: 400
          position: absolute
          left: 50%
          top: 50%
          line-height: 28px
          transform: translate(-50%,-50%)
          @media (min-width: 768px)
            font-size: 1.2rem
</style>