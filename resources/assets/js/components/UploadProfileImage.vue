<template>
    <div>

        <div class="" style="margin:1em 0;">
            <label id="user-avatar-upload" v-if="!isUploading" class="text-center">
                <img v-bind:src="imageSrc" class="ui circular fluid image">
                <input type="file" id="fileupload" v-on:change="uploadProfileImage" style="display: none">
            </label>
        
            <div class="progress" v-if="isUploading && !uploadingComplete">
                <div class="progress-bar" role="progressbar" v-bind:style="{ width: progress + '%'}"></div>
            </div>

            <div class="ui small header">
                Change profile image
                <span class="sub header">Click image above to change profile picture</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            // console.log('Component mounted.')
        },

        data() {
            return {

                fileupload : null,
                isUploading : false,
                progress : 0,
                uploadingComplete : false,
                file : null,
                imageSrc : this.imgSrc,
            }
        },

        props: {

            imgSrc : null,

        },

        methods: {

            uploadProfileImage: function(event){
                var image = document.getElementById('fileupload').files[0];
                    this.isUploading = true;

                var data = new FormData(),
                    _this = this;

                data.append('image', image);

                axios({
                    method : 'post',
                    url : '/profile/upload-image',
                    headers : {'Content-Type' : 'multipart/form-data'},
                    data : data,
                    onUploadProgress: function (e){
                        if(e.lengthComputable){
                            _this.progress = (e.loaded/e.total) * 100;
                        }
                    },
                })
                .then((response) => {
                    _this.uploadingComplete = true;
                    _this.isUploading = false;
                    _this.progress = 0;
                    _this.imageSrc = response.data.filename;
                })
            },

        }
    }
</script>
