<template>
  <div>
    <header-component :is-index="isIndex" :is-request="isRequest"></header-component>
    <router-view class="main-view"></router-view>
    <footer-component :is-index="isIndex"></footer-component>
  </div>

</template>

<script>
  import Header from '../components/master/header'
  import Footer from '../components/master/footer'
  export default {
    components: {
      'header-component': Header,
      'footer-component': Footer,
    },
    computed: {
      isIndex: function() {
        if(this.$route.name == 'index'){
          return true
        }
        return false
      },
      isRequest: function() {
        if(this.$route.name == 'request'){
          return true
        }
        return false
      }
    }
  }
</script>
