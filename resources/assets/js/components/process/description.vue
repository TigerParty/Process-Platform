<template>
  <div class="description-item px-3 py-2 mb-2" v-if="description.length > 0">
    <strong>{{ title }}:</strong>
    <div v-if="isAttachments">
      <div v-for="file in description">
        <a class="text-dark" :href="attachmentURL+file.id"><u>{{ file.name }} [ {{formatBytes(file.size)}} ]</u></a>
      </div>
    </div>
    <pre v-html="description" class="mb-0" v-else v-linkified></pre>
  </div>
</template>

<script>
  export default{
    props: {
      title: {
        type: String,
        default: ''
      },
      description: {
        type: [String, Array],
        default: ''
      },
      isAttachments: {
        type: Boolean,
        default: false
      }
    },
    data() {
      return {
        attachmentURL: '/attachment/'
      }
    },
    methods: {
      formatBytes: function(bytes,decimals) {
         if(bytes == 0) return '0 Bytes';
         var k = 1024,
             dm = decimals || 2,
             sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
             i = Math.floor(Math.log(bytes) / Math.log(k));
         return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
      }
    }
  }
</script>

<style lang="sass" scoped>
  .description-item
    background-color: #f8f8f8
    border: solid 1px #979797
    pre
      white-space: pre-line

</style>