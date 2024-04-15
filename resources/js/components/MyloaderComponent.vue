<template>
    <div class="d-flex justify-content-center align-items-center" v-if="loader_status">
 
        <radar-spinner
  :animation-duration="2000"
  :size="60"
  color="#ff1d5e"
/>
    </div>
</template>

<script>
  
  import { RadarSpinner } from 'epic-spinners'
    export default {

        components: {
            RadarSpinner,
    },
        data() {
            return {
                loader_status: false,
            }
        },
        mounted() {
            this.$emitter.on('mychangeLoaderStatus', (status) => {
                this.loader_status = status
            })
        }
    }
</script>

<style scoped>
   
</style>