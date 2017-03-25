<template>
    <label class="btn btn-default">
        <i class="glyphicon glyphicon-camera"></i> Change Background Image
        <input type="file" id="backgroundImage" class="hidden" v-on:change="uploadBackgroundImage">
    </label>
</template>

<script>
    export default {

        data(){
            return{
                status: '',
            }
        },

        methods: {
            uploadBackgroundImage(){
                var file = document.getElementById('backgroundImage').files[0],
                    form = new FormData();
                form.append('file', file);
                axios.post('/home/upload', form).then((response)=>{
                    window.location.reload();
                });
            }
        },

        mounted() {
            //console.log('Component mounted.')
        }
        
    }
</script>
