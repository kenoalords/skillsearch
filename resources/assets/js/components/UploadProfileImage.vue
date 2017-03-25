<template>
    <div class="panel panel-default">
        <div class="panel-heading">Change profile image</div>

        <div class="panel-body">
            <label v-if="!isUploading" class="text-center" style="display:block">
                <img v-bind:src="imageSrc" class="img-circle">
                <input type="file" id="fileupload" v-on:change="uploadProfileImage" class="invisible">
                <div>
                    <span class="btn btn-default"><i class="glyphicon glyphicon-camera"></i> Upload avatar</span>
                </div>
            </label>

            <div class="progress" v-if="isUploading && !uploadingComplete">
                <div class="progress-bar" role="progressbar" v-bind:style="{ width: progress + '%'}"></div>
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
