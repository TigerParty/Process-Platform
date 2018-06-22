<template>
	<div class="row">
    <div class="col-6 region-block pr-0">
      <select class="form-control border-0"
              v-model="location.province"
              :class="{'text-primary': location.province, 'text-second': !location.province}">
        <option :value="null">- Select Province -</option>
        <option v-for="(item, idx) in locations" :key="idx" :value="item.id" v-text="item.name"></option>
      </select>
    </div>
    <div class="col-6 region-block pl-0">
      <select class="form-control border-0"
              v-model="location.district"
              :disabled="!location.province"
              :class="{'text-primary': location.district, 'text-second': !location.district}">
        <option :value="null">- Select District -</option>
        <option v-for="(item, idx) in subLocations" :key="idx" :value="item.id" v-text="item.name"></option>
      </select>
    </div>
  </div>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex'

	export default {
		props: {
			location: {
				type: Object,
			}
		},
		methods: {
			...mapActions([
        'actionGetLocation',
      ])
		},
		computed: {
      ...mapGetters({
        locations: 'getLocations',
      }),
      subLocations: function() {
        const province = _.find(this.locations, {'id': this.location.province})
        return province? province.regions: null
      },
    },
    mounted () {
    	if(!this.locations || this.locations.length == 0) {
    		this.actionGetLocation()
    	}
    }
	}
</script>

<style lang="sass" scoped>
  .form-control:focus
    -webkit-box-shadow: none
    box-shadow: none
  .region-block
    select
      height: 55px!important
  .region-block:first-child
    border-right: 1px #000 solid
</style>
