<template> 

<div class="ui form">
    <h2 class="ui header">Add Portfolio</h2>
    <div class="ui divider"></div>
    <div class="row">
        <div class="field">
            <h3 class="ui header">Upload Cover Image</h3>
            <label class="thumbnail-image" v-bind:class="{ 'saving' : savingThumbnail }">
                <input type="file" id="thumbnailImage" style="display: none" v-on:change="uploadThumbnail()" :disabled="savingThumbnail">
                <img v-bind:src="thumbnail" v-if="thumbnail" class="ui fluid image" id="thumbnail">
            </label>
            <p>Tip: select the best image to use as a thumbnail</p>
        </div>
        <div>
            <div class="field">
                <h4 class="ui header">Title</h4>
                <input type="text" v-model="title" placeholder="Portfolio title">
            </div>
            <div class="field">
                <h4 class="ui header">Description (Optional)</h4>
                <textarea rows="3" v-model="description" placeholder="Description"></textarea>
            </div>

            <h4 class="ui header">What skill/skills is this portfolio item associated with?</h4>
            <div class="inline fields" v-if="userSkills">
                <div class="field" v-for="skill in userSkills">
                    <div class="ui checkbox">
                        <label>{{ skill.skill }}</label>
                        <input name="skill" type="checkbox" v-model="portfolioSkills" v-bind:value="skill.skill">
                    </div>
                </div>
            </div>

            <div class="field">
                <h4 class="ui header">Portfolio type</h4>
                <div class="fields">
                    <div class="field">
                        <label><input type="radio" v-model="type" value="images" :disabled="uploadedImages.length > 0 ? true : false"> Images</label>
                    </div>
                    <div class="field">
                        <label><input type="radio" v-model="type" value="video" :disabled="uploadedImages.length > 0 ? true : false">
                            Video</label>
                    </div>
                    <div class="field">
                        <label><input type="radio" v-model="type" value="audio" :disabled="uploadedImages.length > 0 ? true : false"> Audio</label>
                    </div>
                </div>
            </div>

            <div class="alert alert-danger" role="alert" v-if="formErrors" v-for="error in formErrors">
                {{error[0]}}
            </div>
            
            <div class="field">
                <div class="" v-if="type == 'images'" class="white-boxed bordered">
                    <div class="ui info icon message">
                        <i class="icon image"></i>
                        <div class="content">
                            <h4 class="header">Upload Images</h4>
                            You can upload up to 10 images. ** Supported file formats are JPEG, JPG, PNG and GIF's
                        </div>
                    </div>
                    <div class="" v-if="type == 'images'">
                        <div class="progress" v-if="isUploading && !uploadingComplete">
                            <div class="progress-bar" role="progressbar" v-bind:style="{ width: progress + '%'}"></div>
                        </div>
                        
                        <label class="ui icon labeled green button" v-if="uploadedImages.length < 10 && !isUploading">
                            <i class="icon download"></i> Select image
                            <input type="file" id="fileUpload" style="display:none" v-on:change="uploadImage">
                        </label>
                        <p><small>{{ uploadedImages.length }} out of 10 Images</small></p>
                        <div class="ui middle aligned divided list" v-if="uploadedImages" style="margin-top:2em">
                            <div class="item" v-for="image in uploadedImages">
                                <img v-bind:src=" image.link " style="width:auto; height: 70px;">
                                <div class="right floated content">
                                    <a href="#" class="ui icon circular mini button" v-on:click.prevent="deleteFile(image)">
                                        <i class="icon delete"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="" v-if="type == 'audio'" class="white-boxed bordered">
                    <div class="ui info icon message">
                        <i class="icon music"></i>
                        <div class="content">
                            <h4 class="header">Upload Audio</h4>
                            You can upload 1 audio file in <strong>.MP3</strong> format
                        </div>
                    </div>
                    
                    <div class="" v-if="type == 'audio'">
                        <div class="progress" v-if="isUploading && !uploadingComplete">
                            <div class="progress-bar" role="progressbar" v-bind:style="{ width: progress + '%'}"></div>
                        </div>
                        <label class="ui teal icon labeled button" v-if="uploadedImages.length == 0 && !isUploading">
                            <i class="icon music"></i> Select Audio
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

                <div class="" v-if="type == 'video'" class="white-boxed bordered">
                    <div class="ui info icon message">
                        <i class="icon video"></i>
                        <div class="content">
                            <h4 class="header">Upload Video</h4>
                            You can upload 1 video file per portfolio item in <strong>.MP4 &amp; .MPEG</strong> format.
                        </div>
                    </div>                
                    <div class="" v-if="type == 'video'">
                        <div class="progress" v-if="isUploading && !uploadingComplete">
                            <div class="progress-bar" role="progressbar" v-bind:style="{ width: progress + '%'}"></div>
                        </div>
                        <label class="ui icon labeled red button" v-if="uploadedImages.length == 0 && !isUploading">
                            <i class="icon upload"></i> Upload video
                            <input type="file" id="fileUpload" style="display:none" v-on:change="uploadImage">
                        </label>
                        <div v-if="uploadedImages.length == 1">
                            <p>You can change the video by deleting the currently uploaded video and upload a new video</p>
                        </div>
                        <div v-if="uploadedImages" style="margin-top:2em" v-for="video in uploadedImages">
                            <video id="video" style="width:100%;" controls>
                                <source type="video/mp4" :src="video.link"></source>
                            </video>
                            <div class="">
                                <a href="#" v-on:click.prevent="deleteFile(video)" class="ui mini red button">
                                    <i class="icon trash"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div  class="two fields">
                <div class="field">
                    <h4 class="ui header">Portfolio link <span class="text-muted">(optional)</span></h4>
                    <input type="url" v-model="portfolioUrl" placeholder="http://example.com">
                    <small>Enter an external url this portfolio links to</small>
                </div>
                <!-- <div class="field">
                    <h4 class="ui header">Completion date <span class="text-muted">(optional)</span></h4>
                    <div class="ui input labeled">
                        <span class="ui label">MM/DD/YYY</span>
                        <input type="date" v-model="portfolioDate">
                    </div>
                </div> -->
            </div>
            
            <div class="field">
                <div class="ui checkbox">
                    <input type="checkbox" v-model="isPublic" value="1">
                    <label>Make My Portfolio Public</label>
                </div>
            </div>
            <button class="ui primary button" v-on:click.prevent="savePortfolio" :disabled="!canSave">Submit</button>
            <span class="text-muted">{{ statusText }}</span>
        </div>
    </div>
</div>
</div>
    
</template>

<script>
    import videojs from "video.js";
    export default {
        data()  {
            var portfolio = this.portfolio ? JSON.parse(this.portfolio) : '',
                files = (this.files) ? JSON.parse(this.files) : '',
                skills = (this.skills) ? JSON.parse(this.skills) : '';
            return {
                title: (portfolio.title) ? portfolio.title : this.name + ' Portfolio',
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
                selectedSkills:(portfolio.skills !== null) ? portfolio.skills.split(", ") : null,
                canSave: (portfolio.uid) ? true : false,
                portfolioUrl: (portfolio.url) ? portfolio.url : null,
                portfolioDate: (portfolio.completion_date) ? portfolio.completion_date : null,
                savingThumbnail: false,
                thumbnail : (portfolio.thumbnail) ? portfolio.thumbnail : null,
                isNew: false,
                player: null,
                formErrors : null,
                progressEl: document.getElementById('#progress'),
            }
        },
        props: {
            portfolio : null,
            files : null,
            skills: null,
            name: null,
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

                if( _this.type === 'video' && video.indexOf(file.type) === -1 ){
                    alert('Please select a video file to upload');
                    return false;
                }

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
                        console.log(e)
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
                        console.log(e);
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
            // this.player = videojs("video");
        }
    }
</script>
