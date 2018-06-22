Vue.component('modal', {
    template: `
        <div class="modal fade"  :id="modalId" tabindex="-1" role="dialog"  aria-hidden="true">
          <div class="modal-dialog" :class="{'modal-lg': isLargeModal}" role="document">
            <div class="modal-content rounded-0">
              <div class="modal-header border-0 text-center  justify-content-center pb-0">
                <h4 class="modal-title  font-weight-light" v-text="title"></h4>
              </div>
              <div class="modal-body pb-0">
                <slot name="body"></slot>
              </div>
              <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary" :class="{'mr-auto': deactiveAlighLeft}" data-dismiss="modal" v-text="deactiveBtnString" v-on:click="cancelFunction"></button>
                <button v-if="showPrevBtn" type="button" class="btn btn-secondary" @click="prevFunction">PREV</button>
                <button type="button" class="btn btn-second" v-text="activeBtnString" v-on:click="activeFunction" :disabled="disableBtn">Save</button>
              </div>
            </div>
          </div>
        </div>
    `,
    props: {
      modalId: {
        type: String,
        default: 'mainModal'
      },
      title: {
        type: String
      },
      activeBtnString: {
        type: String,
        default: 'SAVE'
      },
      activeFunction: {
        type: Function
      },
      prevFunction: {
        type: Function
      },
      deactiveBtnString: {
        type: String,
        default: 'CANCEL'
      },
      deactiveAlighLeft: {
        type: Boolean,
        type: false
      },
      disableBtn: {
        type: Boolean,
        default: false
      },
      isLargeModal: {
        type: Boolean,
        default: false
      },
      showPrevBtn: {
        type: Boolean,
        default: false
      },
      cancelFunction: {
        type: Function,
        default: function(){
          return
        }
      }
    }
})