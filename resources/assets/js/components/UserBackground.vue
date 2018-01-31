<template>
    <label class="button is-white is-small" id="change-user-background">
        <span class="icon"><i class="fa fa-camera" :class="{ 'fa-camera' : !status, 'fa-circle-o-notch fa-spin' : status }"></i></span> <span>Change Background Image</span>
        <input type="file" id="backgroundImage" style="display:none" v-on:change="uploadBackgroundImage">
    </label>
</template>

<script>
    export default {

        data(){
            return{
                status: false,
            }
        },

        methods: {
            uploadBackgroundImage(){
                let $this = this;
                $this.status = true;
                var file = document.getElementById('backgroundImage').files[0],
                    form = new FormData();
                form.append('file', file);
                axios.post('/dashboard/upload', form).then((response)=>{
                    // window.location.reload();
                    const url = response.data;
                    $('#profile-image-wrapper').css({
                        'background-image' : 'url('+url+')'
                    });
                    $this.status = false;
                });
            }
        },

        mounted() {
            //console.log('Component mounted.')
        }
        
    }
</script>
