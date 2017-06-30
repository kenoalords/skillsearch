<template> 

<div class="container">
    <div class="col-md-8 col-md-offset-2">
    <div class="clearfix">
        <h3 class="pull-left bold" style="margin-top:0">Add Portfolio Item</h3>
        <a href="/home" class="btn btn-basic pull-right bold text-muted"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
    <hr>
    <div class="row">
        <div>
            <h4 class="text-center bold">Upload Cover Image</h4>
            <label class="thumbnail-image" v-bind:class="{ saving : savingThumbnail }">
                <input type="file" id="thumbnailImage" class="hidden" v-on:change="uploadThumbnail()" :disabled="savingThumbnail">
                <img v-bind:src="thumbnail" v-if="thumbnail" class="img-responsive" id="thumbnail">
            </label>
            <p class="text-center"><small>Tip: select the best image to use as a thumbnail</small></p>
        </div>
        <div>
            <div class="form-wrapper whiteCard">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" v-model="title" placeholder="Portfolio title">
                </div>
                <div class="form-group">
                    <label>Description (Optional)</label>
                    <textarea class="form-control" rows="3" v-model="description" placeholder="Description"></textarea>
                </div>
                <div class="form-group" v-if="userSkills">
                    <label>What skill/skills is this portfolio item associated with?</label><br>
                    <label v-for="skill in userSkills" style="margin-right:1em;" class="thin">
                        <input type="checkbox" v-model="portfolioSkills" v-bind:value="skill.skill"> {{ skill.skill }}
                    </label>
                </div>
            </div>
            <hr>
            <div class="form-wrapper whiteCard">
                
                <label>Portfolio type</label>

                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <label class="btn btn-default btn-block">
                            <input type="radio" v-model="type" value="images" :disabled="uploadedImages.length > 0 ? true : false"> Images
                        </label>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <label class=" btn btn-default btn-block">
                            <input type="radio" v-model="type" value="video" :disabled="uploadedImages.length > 0 ? true : false"> Video
                        </label>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <label class=" btn btn-default btn-block">
                            <input type="radio" v-model="type" value="audio" :disabled="uploadedImages.length > 0 ? true : false"> Audio
                        </label>
                    </div>
                </div>
            </div>

            <div class="alert alert-danger" role="alert" v-if="formErrors" v-for="error in formErrors">
                {{error[0]}}
            </div>

            <div class="form-wrapper whiteCard" v-if="type == 'images'">
                <h4 class="bold">Upload Images</h4>
                <p>You can upload up to 10 images. <span class="text-warning"><em>** Supported file formats are JPEG, JPG, PNG and GIF's</em></span></p>
                <div class="" v-if="type == 'images'">
                    <div class="progress" v-if="isUploading && !uploadingComplete">
                        <div class="progress-bar" role="progressbar" v-bind:style="{ width: progress + '%'}"></div>
                    </div>
                    <label class="btn btn-primary btn-block" v-if="uploadedImages.length < 10 && !isUploading">
                        <i class="glyphicon glyphicon-plus"></i> Select image
                        <input type="file" id="fileUpload" style="display:none" v-on:change="uploadImage">
                    </label>
                    <p class="bold"><small>{{ uploadedImages.length }} out of 10 Images</small></p>
                    <div class="list-group" v-if="uploadedImages" style="margin-top:2em">
                        <div class="list-group-item" v-for="image in uploadedImages">
                            <img v-bind:src=" image.link " style="width:auto; height: 70px;">
                            <div class="pull-right">
                                <a href="#" class="btn btn-basic" v-on:click.prevent="deleteFile(image)">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-wrapper whiteCard" v-if="type == 'audio'">
                <h4 class="bold">Upload Audio</h4>
                <p>You can upload 1 audio file. <span class="text-warning"><em>** Supported file format is MP3</em></span></p>
                <div class="" v-if="type == 'audio'">
                    <div class="progress" v-if="isUploading && !uploadingComplete">
                        <div class="progress-bar" role="progressbar" v-bind:style="{ width: progress + '%'}"></div>
                    </div>
                    <label class="btn btn-primary btn-block" v-if="uploadedImages.length == 0 && !isUploading">
                        <i class="glyphicon glyphicon-music"></i> Select Audio
                        <input type="file" id="fileUpload" style="display:none" v-on:change="uploadImage">
                    </label>
                    <div class="list-group" v-if="uploadedImages" style="margin-top:2em">
                        <div class="list-group-item" v-for="audio in uploadedImages">
                            <audio controls preload="auto">
                                <source type="audio/mp3" v-bind:src="audio.link"></source>
                            </audio>
                            <div class="pull-right">
                                <a href="#" v-on:click.prevent="deleteFile(audio)">
                                    <i class="glyphicon glyphicon-trash"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-wrapper whiteCard" v-if="type == 'video'">
                <h4 class="bold">Upload Video</h4>
                <p>You can upload 1 video file per portfolio item. <span class="text-warning"><em>** Supported file formats are MP4 &amp; MPEG</em></span></p>
                <div class="" v-if="type == 'video'">
                    <div class="progress" v-if="isUploading && !uploadingComplete">
                        <div class="progress-bar" role="progressbar" v-bind:style="{ width: progress + '%'}"></div>
                    </div>
                    <label class="btn btn-primary btn-block" v-if="uploadedImages.length == 0 && !isUploading">
                        <i class="glyphicon glyphicon-facetime-video"></i> Upload video
                        <input type="file" id="fileUpload" style="display:none" v-on:change="uploadImage">
                    </label>
                    <div v-if="uploadedImages.length == 1">
                        <p>You can change the video by deleting the currently uploaded video and uploading a new video</p>
                    </div>
                    <div class="list-group" v-if="uploadedImages" style="margin-top:2em">
                        <div class="list-group-item" v-for="video in uploadedImages">
                            <div class="embed-responsive embed-responsive-16by9">
                            <video id="video">
                                <source type="video/mp4" v-bind:src="video.link"></source>
                            </video>
                            </div>
                            <hr>
                            <div class="">
                                <a href="#" v-on:click.prevent="deleteFile(video)" class="btn btn-danger btn-block">
                                    <i class="glyphicon glyphicon-trash"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div  class="form-wrapper whiteCard">
                <div class="">
                    <div class="row">                        
                        <div class="col-sm-6">
                            <label for="url">Portfolio link <span class="text-muted">(optional)</span></label>
                            <input type="url" v-model="portfolioUrl" class="form-control" placeholder="http://example.com">
                            <small>Enter an external url this portfolio links to</small>
                        </div>
                        <div class="col-sm-6">
                            <label for="url">Completion date <span class="text-muted">(optional)</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input type="date" v-model="portfolioDate" class="form-control">
                            </div>
                            <small>Enter portfolio completion date</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-wrapper">
                <div class="">
                    <div>
                        <label>
                            <input type="checkbox" v-model="isPublic" value="1"> &nbsp; Make My Portfolio Public
                        </label>
                    </div>
                    <hr>
                    <div>
                        <button class="btn btn-primary" v-on:click.prevent="savePortfolio" :disabled="!canSave">Save Portfolio</button>
                        <span class="text-muted">{{ statusText }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    
</template>

<script>
    // import videojs from "video.js";
    export default {
        data()  {
            var portfolio = this.portfolio ? JSON.parse(this.portfolio) : '',
                files = (this.files) ? JSON.parse(this.files) : '',
                skills = (this.skills) ? JSON.parse(this.skills) : '';
            return {
                title: (portfolio.title) ? portfolio.title : 'Untitled',
                description: (portfolio.description) ? portfolio.description : '',
                type: (portfolio.type) ? portfolio.type : null,
                isPublic : (portfolio.is_public) ? portfolio.is_public : 0,
                uid : (portfolio.uid) ? portfolio.uid : null,
                progress : 0,
                isUploading: false,
                uploadingComplete: false,
                uploadedImages : (files) ? files : [],
                statusText : null,
                userSkills : skills, 
                portfolioSkills: [],
                canSave: (portfolio.uid) ? true : false,
                portfolioUrl: (portfolio.url) ? portfolio.url : null,
                portfolioDate: (portfolio.completion_date) ? portfolio.completion_date : null,
                savingThumbnail: false,
                thumbnail : (portfolio.thumbnail) ?  window.skillsearch.s3images +'/'+ portfolio.thumbnail : null,
                isNew: false,
                player: null,
                formErrors : null,
            }
        },
        props: {
            portfolio : null,
            files : null,
            skills: null,
        },
        methods: {
            savePortfolio() {
                this.statusText = 'Saving Changes...';
                if(this.isPublic !== 0 && this.uploadedImages.length === 0){
                    alert('You cannot make your portfolio public without uploading at least one file');
                    return;
                }

                if(this.thumbnail === null){
                    alert('Please upload a thumbnail for your portfolio item');
                    return;
                }
                var data = {
                    uid : this.uid,
                    title: this.title,
                    description: this.description,
                    is_public: this.isPublic,
                    skills: this.portfolioSkills,
                    url: this.portfolioUrl,
                    type: this.type,
                    completion_date: this.portfolioDate
                };

                axios({
                    method: 'PUT',
                    url: '/profile/portfolio/'+ this.uid +'/update',
                    data: data,
                }).then( (response) => {
                    this.statusText = 'Saved!';
                    setTimeout(()=>{
                        window.location.href = '/profile/portfolio';
                    }, 600)
                })
            },

            uploadThumbnail(){
                var _this = this;
                var thumbnail = document.getElementById('thumbnailImage').files[0];
                _this.savingThumbnail = true;
                if(thumbnail && (thumbnail.type == 'image/jpeg' 
                    || thumbnail.type == 'image/jpg' 
                    || thumbnail.type == 'image/png' 
                    || thumbnail.type == 'image/gif')){

                
                var form = new FormData();
                    form.append('title', this.title);
                    form.append('thumbnail', thumbnail);
                    form.append('uid', _this.uid);
                axios({
                        method: 'post',
                        url: '/profile/portfolio/thumbnail',
                        data: form,
                        headers : {'Content-Type' : 'multipart/form-data'},
                        onUploadProgress: function (e){
                            if(e.lengthComputable){
                                // _this.progress = (e.loaded/e.total) * 100;
                            }
                        },
                    }).then((response)=>{
                        _this.savingThumbnail = false;
                        _this.isNew = true;
                        if(response.data.uid){
                            _this.uid = response.data.uid
                        }
                        _this.thumbnail = response.data.thumbnail;
                    }).catch((error)=>{
                        _this.savingThumbnail = false;
                    })
                }else {
                    alert('Please select an image file');
                    _this.savingThumbnail = false;
                    return;
                }
            },

            getFile(image){
                if(this.isNew === false){
                    return window.skillsearch.s3images + '/' + image;
                } else {
                    return window.Laravel.url + '/' + image;
                }
                
            },
            uploadImage() {
                var file = document.getElementById('fileUpload').files[0],
                    _this = this,
                    images = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'],
                    video = ['video/mp4', 'video/mpeg'],
                    audio = ['audio/mp3', 'audio/wav', 'audio/mpeg'];
                
                // check if there is a file uploaded
                if(!file){
                    return false;
                }
                
                if( _this.type === 'images' && images.indexOf(file.type) === -1 ){
                    alert('Please select an image file');
                    return false;
                }

                // if( _this.type === 'video' && video.indexOf(file.type) === -1 ){
                //     alert('Please select a video file to upload');
                //     return false;
                // }

                if( _this.type === 'audio' && audio.indexOf(file.type) === -1 ){
                    alert('Please select an audio file to upload');
                    return false;
                }

                _this.isUploading = true;
                if(_this.uid == null) {
                    var form = new FormData();
                    form.append('title', this.title);
                    form.append('description', this.description);
                    form.append('type', this.type);
                    form.append('is_public', this.isPublic);
                    form.append('file', file);

                    axios({
                        method: 'post',
                        url: '/profile/portfolio/add',
                        data: form,
                        headers : {'Content-Type' : 'multipart/form-data'},
                        onUploadProgress: function (e){
                            if(e.lengthComputable){
                                _this.progress = (e.loaded/e.total) * 100;
                            }
                        },
                    })
                    .then((response)=>{
                        _this.isNew = true;
                        _this.isUploading = false;
                        _this.uploadingComplete = true;
                        _this.uid = response.data.uid;
                        _this.uploadedImages.push(response.data.file);
                        _this.canSave = true;
                        
                    })
                    .catch( (e) => {
                        _this.isUploading = false;
                        _this.uploadingComplete = true;
                        _this.formErrors = e.response.data;
                        // console.log(error)
                    }); 
                } else {
                    _this.progress = 0;
                    _this.isUploading = true;
                    _this.uploadingComplete = false;
                    _this.canSave = true;
                    
                    var form = new FormData();
                        form.append('file', file);
                        form.append('uid', _this.uid);
                        form.append('type', _this.type);
                    axios({
                        method: 'post',
                        url: '/profile/portfolio/add',
                        data: form,
                        headers : {'Content-Type' : 'multipart/form-data'},
                        onUploadProgress: function (e){
                            if(e.lengthComputable){
                                _this.progress = (e.loaded/e.total) * 100;
                            }
                        },
                    })
                    .then((response)=>{
                        _this.isNew = true;
                        _this.isUploading = false;
                        _this.uploadingComplete = true;
                        _this.uploadedImages.push(response.data.file);
                        
                    })
                    .catch( (e) => {
                        // console.log(error)
                        _this.isUploading = false;
                        _this.uploadingComplete = true;
                        _this.formErrors = e.response.data;
                    });
                }
            },
            deleteFile ( image ) {
                var file_id = image.id,
                    verify = confirm("Are you sure you want to delete this file"),
                    _this = this;
                var i = _this.uploadedImages.indexOf(image);
                if ( verify ){
                    axios.delete('/profile/files/' + file_id)
                    .then( (response) => {
                        _this.uploadedImages.splice(i, 1);
                    })
                }
                
            },
        },
        mounted() {

        }
    }
</script>
