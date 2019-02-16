<template>
    <div>

        <div class="profile-image">
            <label id="user-avatar-upload" :class="{ 'is-uploading-avatar' : isUploading }" class="has-text-centered">
                <img v-bind:src="imageSrc" class="image is-128x128 is-rounded">
                <input type="file" id="fileupload" v-on:change="uploadProfileImage" style="display: none">
            </label>
        
            <div class="progress" v-if="isUploading && !uploadingComplete">
                <div class="progress-bar" role="progressbar" v-bind:style="{ width: progress + '%'}"></div>
            </div>

            <h4 class="title is-5 has-text-white">
                Profile image
            </h4>
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
                    url : '/dashboard/profile/upload-image',
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
                    iziToast.success({ title: "Profile picture changed successfully" });
                    $('.is-user-profile').attr('src', response.data.filename)
                })
                .catch( error => {
                    iziToast.error({ title: "An error occured while changing your profile picture" });
                    return false;
                } )
            },

        }
    }
</script>
