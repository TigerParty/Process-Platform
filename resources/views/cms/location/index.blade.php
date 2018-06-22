@extends('cms.master.app')

@section('content')
<div id="locationIndex" v-cloak>
 <div class="row pt-4">
    <div class="col">
        <span class="font-size-1-5 text-secondary font-weight-light">{{ __('location.level-1-title') }}s Management</span>
        <hr class="mt-0">
    </div>
 </div>

 <div class="row px-3">
     <div class="col-12 col-sm-7 col-md-8 col-xl-9">
        <div class="d-flex">
            <label class="rounded-circle  box-shadow bg-white center-box padding-4-5 cursor-pointer" data-target="#createModal" v-on:click.stop="showCreateModal('{{ __('location.level-1-title') }}', true)">
              <i class="fa fa-plus font-size-1-5 center-item absolute-center text-primary"></i>
            </label>
            <span class="align-self-center ml-2">Add New {{ __('location.level-1-title') }} </span>
        </div>
     </div>
     <div class="col-12 col-sm-5 col-md-4 col-xl-3 align-self-center">
        <div class="input-group mt-3 mt-sm-0">
          <span class="input-group-addon bg-white fa fa-search pt-2 rounded-0 border-second" id="search-addon"></span>
          <input type="text" class="form-control border-left-0 pl-0 rounded-0 border-second text-lowercase"  placeholder="Search {{ __('location.level-1-title') }}..."  aria-describedby="search-addon" v-model="searchString">
        </div>
     </div>
 </div>
 <div class="row m-3">
    <table class="table table-hover table-responsive-md">
        <thead>
            <tr>
              <th scope="col" class=" text-uppercase font-weight-normal text-nowrap vertical-middle">{{ __('location.level-1-title') }} name</th>
              <th scope="col" class=" text-uppercase font-weight-normal text-nowrap vertical-middle">last updated</th>
              <th class="text-nowrap">
                <div class="same-height-col float-right">
                    <div class="same-height-item vertical-middle pr-2">
                        <span class="font-weight-normal">@{{ pageItemFrom }} - @{{ pageItemTo }} of @{{ filterData.length }}</span>
                    </div>
                    <div class="same-height-item vertical-middle">
                        <label class="border-second bg-white p-3 center-box" v-on:click="prevPage()"><i class="fa  fa-caret-left center-item absolute-center text-primary font-size-1-5"></i></label>
                        <label class="border-second bg-white p-3 center-box" v-on:click="nextPage()"><i class="fa  fa-caret-right center-item absolute-center text-primary font-size-1-5"></i></label>
                    </div>
                </div>
              </th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <tr v-for="item in paginatedData" class="cursor-pointer" :class="{'bg-light-active': detailData&&detailData.id==item.id}" v-on:click="onClickRegionDetail(item.id)">
                <td class="py-3 vertical-middle" v-text="item.name"></td>
                <td class="py-3 vertical-middle" v-text="convertDateFormate(item.updated_at)"></td>
                <td class="py-3  text-right">
                    <div class="btn-group">
                      <label class="btn btn-primary text-white text-uppercase border-right mb-0"  data-target="#renameModal" v-on:click.stop="showRenameModal(item, '{{ __('location.level-1-title') }}', true)">
                        rename
                      </label>
                      <label class="btn btn-primary text-white text-uppercase px-4 mb-0"  data-target="#deleteModal" v-on:click.stop="showDeleteModal(item, '{{ __('location.level-1-title') }}', true)">
                        del
                      </label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <span class="text-lowercase">* click on the row to check the {{ __('location.level-2-title') }}s of {{ __('location.level-1-title') }}.</span>
 </div>
 <div class="row pt-5"  ref="districtRow">
    <div class="col">
        <span class="font-size-1-5 text-secondary font-weight-light text-capitalize">
            the {{ __('location.level-2-title') }}s of
           <span v-if="!detailData">{{ __('location.level-1-title') }}</span>
           <span v-else v-text="detailData.name"></span>
       </span>
        <hr class="mt-0">
    </div>
 </div>
 <div v-if="detailData" id="location">
     <div class="row px-3">
         <div class="col-12">
            <div class="d-flex float-right">
                <label class="rounded-circle  box-shadow bg-white center-box padding-4-5 cursor-pointer" data-target="#createModal" v-on:click.stop="showCreateModal('{{ __('location.level-2-title') }}', false)">
                  <i class="fa fa-plus font-size-1-5 center-item absolute-center text-primary"></i>
                </label>
                <span class="align-self-center ml-2 text-capitalize">Add New {{ __('location.level-2-title') }}s To
                    <span v-text="detailData.name"></span>
                </span>
            </div>
         </div>
     </div>
     <div class="row m-3" v-if="detailData.regions.length">
        <table class="table table-hover table-responsive-md">
            <thead>
                <tr>
                  <th scope="col" class=" text-uppercase font-weight-normal text-nowrap vertical-middle">{{ __('location.level-2-title') }} name</th>
                  <th scope="col" class=" text-uppercase font-weight-normal text-nowrap vertical-middle">last updated</th>
                  <th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <tr v-for="item in detailData.regions">
                    <td class="py-3 vertical-middle" v-text="item.name"></td>
                    <td class="py-3 vertical-middle" v-text="convertDateFormate(item.updated_at)"></td>
                    <td class="py-3  text-right">
                        <div class="btn-group">
                          <label class="btn btn-primary text-white text-uppercase border-right mb-0"  data-target="#renameModal" v-on:click.stop="showRenameModal(item, '{{ __('location.level-2-title') }}', false)">
                            rename
                          </label>
                          <label class="btn btn-primary text-white text-uppercase px-4 mb-0" data-target="#deleteModal" v-on:click.stop="showDeleteModal(item, '{{ __('location.level-2-title') }}', false)">
                            del
                          </label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
     </div>
 </div>


<!-- createModal -->
<modal
 modal-id="createModal"
 :title="modalData.title"
 :active-function="createItem"
 :disable-btn="modalData.disableBtn"
 :cancel-function="clearModalData">
 <div slot="body">
   <div class="bg-light-primary p-3">
      <span class="font-weight-normal text-lowercase" v-text="modalData.note"></span>
      <input type="text"  class="mt-2 form-control bg-white box-shadow rounded-0" :class="{'is-invalid': modalData.error}" v-model="modalData.name">
      <div class="invalid-feedback" v-if="modalData.error">
        <span v-if="modalData.error.hasOwnProperty('name')"
          v-for="msg in modalData.error.name"> @{{msg}}</span>
      </div>
   </div>
 </div>
</modal>

<!-- RenameModal -->
<modal
 modal-id="renameModal"
 :title="modalData.title"
 :active-function="updateItem"
 :disable-btn="modalData.disableBtn"
 :cancel-function="clearModalData">
 <div slot="body">
   <div class="bg-light-primary p-3">
      <span class="font-weight-normal text-lowercase" v-text="modalData.note"></span>
      <input type="text"  class="mt-2 form-control bg-white box-shadow rounded-0" :class="{'is-invalid': modalData.error}" v-model="modalData.name">
      <div class="invalid-feedback" v-if="modalData.error">
        <span v-if="modalData.error.hasOwnProperty('name')"
          v-for="msg in modalData.error.name"> @{{msg}}</span>
      </div>
   </div>
 </div>
</modal>

<!-- DeleteModal -->
<modal
 modal-id="deleteModal"
 :title="modalData.title"
 :active-btn-string="'DEL'"
 :active-function="removeItem"
 :disable-btn="modalData.disableBtn">
 <div slot="body">
   <div class="bg-light-primary p-3">
      <span class="font-weight-normal text-capitalize text-danger" v-text="modalData.note"></span>
      <div class="invalid-feedback" v-if="modalData.error">
        <span v-text="modalData.error"></span>
      </div>
   </div>
 </div>
</modal>

</div>
@endsection
