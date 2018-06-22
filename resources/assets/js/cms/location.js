import bModal from "./component/modal";

if ($('#locationIndex').length > 0) {

  new Vue({
    el: '#locationIndex',
    data: {
      data: [],
      detailData: null,
      activeKey: 0,
      modalData: {
        title: '',
        note: '',
        name: '',
        id: null,
        parent: null,
        error: null,
        disableBtn: false
      },
      searchString: '',
      currentPage: 1,
      perPage: 5,
    },
    computed: {
      filterData: function(){
        var self = this

        this.detailData = null

        var results = _.filter(this.data, function(region) {
          return region.name.toLowerCase().indexOf(self.searchString.toLowerCase()) > -1;
        })

        //-- reset current page
        this.currentPage = 1

        return results
      },
      paginatedData: function(){
        var offset = (this.currentPage - 1) * this.perPage
        return this.filterData.slice(offset, offset + this.perPage)
      },
      pageItemFrom: function(){
        return (this.currentPage - 1) * this.perPage + 1
      },
      pageItemTo: function(){
        return this.currentPage * this.perPage > this.filterData.length ? this.filterData.length : this.currentPage * this.perPage
      },
    },
    methods: {
      nextPage: function() {
        if (this.currentPage * this.perPage >= this.filterData.length) {
          return
        }

        this.currentPage += 1
      },
      prevPage: function() {
        if (this.currentPage == 1) {
          return
        }

        this.currentPage -= 1
      },
      convertDateFormate: function(date) {
          return moment(date).format('DD MMM, YYYY')
      },
      onClickRegionDetail: function(key) {
          this.activeKey = key
          this.detailData = _.find(this.data, {id: key})

          var scrollInterval = setInterval(function() {
            document.querySelector('#location').scrollIntoView({
              behavior: 'smooth',
              block: 'end',
            })
            clearInterval(scrollInterval)
          }, 100)
      },
      clearModalData: function() {
        this.modalData = {
          title: '',
          note: '',
          name: '',
          id: null,
          parent: null,
          error: null,
          disableBtn: false
        }
      },
      showCreateModal: function(levelTitle, isParent) {
          this.modalData.title = `Create New ${levelTitle}`

          if(isParent) {
            this.modalData.note = `Input new ${levelTitle} name.`
          }else {
            this.modalData.parent = this.detailData.id
            const parentName = this.detailData.name
            this.modalData.note = `Input new ${levelTitle} name to ${parentName}.`
          }

          $('#createModal').modal('show')
      },
      showRenameModal: function(item, levelTitle, isParent) {
          this.modalData.title = `Update ${levelTitle}`

          this.modalData.name = item.name
          this.modalData.id = item.id
          this.modalData.parent = item.parent_id

          if(isParent) {
            this.modalData.note = `Update the ${levelTitle} name.`
          }else {
            const parentName = this.detailData.name
            this.modalData.note = `Update the ${levelTitle} name to ${parentName}.`
          }

          $('#renameModal').modal('show')
      },
      showDeleteModal: function(item, levelTitle, isParent) {
          this.modalData.title = `Delete ${levelTitle}`
          this.modalData.name = item.name
          this.modalData.id = item.id
          this.modalData.parent = item.parent_id

          if(isParent) {
            const itemName = this.modalData.name
            this.modalData.note = `Are you sure to remove the ${levelTitle} of ${itemName}?`
          }else {
            const itemName = this.modalData.name
            const parentName = this.detailData.name
            this.modalData.note = `Are you sure to remove the ${levelTitle} of ${itemName} that belog to the ${parentName}?`
          }

          $('#deleteModal').modal('show')
      },
      hideModal: function(id) {
          $(`#${id}`).modal('hide')
          this.clearModalData()
      },
      createItem: function() {
        this.modalData.disableBtn = true
        const postData = {
          'name': this.modalData.name,
          'parent_id': this.modalData.parent
        }
        this.$http.post(`/api/admin/location`, postData)
          .then((response) => {
            const createdItem = response.data
            if(createdItem.parent_id) {
              const parentIndex = _.findIndex(this.data, {id: createdItem.parent_id})
              this.$set(this.data[parentIndex].regions, createdItem)
              this.data[parentIndex].regions.unshift(createdItem)
            }else {
              this.data.unshift(createdItem)
            }
            this.modalData.disableBtn = false
            this.hideModal('createModal')
          }).catch((ex) => {
            console.log('Fetch Create Data Fail!')
            this.modalData.disableBtn = false
            if(ex.response.status == 422) {
              this.$set(this.modalData, 'error', ex.response.data.errors)
            }
          })
      },
      updateItem: function() {
        this.modalData.disableBtn = true
        const itemID = this.modalData.id
        const putData = {
          'name': this.modalData.name,
          'parent_id': this.modalData.parent
        }
        this.$http.put(`/api/admin/location/${itemID}`, putData)
          .then((response) => {
            const updatedItem = response.data
            if(updatedItem.parent_id) {
              const parentIndex = _.findIndex(this.data, {id: updatedItem.parent_id})
              const itemIndex = _.findIndex(this.data[parentIndex].regions, {id: updatedItem.id})
              this.$set(this.data[parentIndex].regions, itemIndex, updatedItem)
            }else {
              const itemIndex = _.findIndex(this.data, {id: updatedItem.id})
              this.$delete(this.data, itemIndex)
              this.data.unshift(updatedItem)

            }
            this.modalData.disableBtn = false
            this.hideModal('renameModal')
          }).catch((ex) => {
            console.log('Fetch Update Data Fail!')
            this.modalData.disableBtn = false
            if(ex.response.status == 422) {
              this.$set(this.modalData, 'error', ex.response.data.errors)
            }
          })
      },
      removeItem: function() {
        this.modalData.disableBtn = true
        const itemID = this.modalData.id
        this.$http.delete(`/api/admin/location/${itemID}`)
          .then((response) => {
            if(this.modalData.parent) {
              const parentIndex = _.findIndex(this.data, {id: this.modalData.parent})
              const itemIndex = _.findIndex(this.data[parentIndex].regions, {id: this.modalData.id})
              this.$delete(this.data[parentIndex].regions, itemIndex)
            }else {
              const itemIndex = _.findIndex(this.data, {id: this.modalData.id})
              this.$delete(this.data, itemIndex)
            }
            this.modalData.disableBtn = false
            this.hideModal('deleteModal')
          }).catch((ex) => {
            console.log('Fetch Delete Data Fail!')
            this.modalData.disableBtn = false
            if(ex.response.status == 422) {
              this.$set(this.modalData, 'error', ex.response.data.errors)
            }
          })
      },
      fetchItems: function() {
        this.$http.get('/api/admin/location')
          .then((response) => {
            this.data = response.data.regions
          }).catch((response) => {
            console.log('Fetch Regions Data Fail!')
          });
      }
    },
    created: function() {
      this.fetchItems()
    }
  })
}