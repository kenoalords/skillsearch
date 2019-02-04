<template>
    <div>
        <form action="#" id="portfolio-form" :class="{'loading' : isPosting}">
            <div class="card">
                <div class="card-content">
                    <h3 class="title is-5 bold">Work description</h3>
                    <p>Please provide an appropriate title and description.</p>
                    <div class="field">
                        <label for="title">Work title</label>
                        <input type="text" id="title" v-model="p.title" class="input">
                    </div>

                    <div class="field">
                        <label for="description bold">Work description </label>
                        <textarea rows="2" id="description" placeholder="Provide a short description about this work" v-model="p.description" class="textarea"></textarea>
                        <p class="help">Adding a description will make this work visible to Google and increase your ranking</p>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-content">
                    <div class="field" style="margin-top: 1em">
                        <h3 class="title is-5 bold">Upload thumbnail</h3>
                        <p>This is the image that represents what this work is about. Choose it wisely</p>
                        <figure>
                            <img v-bind:src="p.thumbnail" v-if="p.thumbnail" class="image portfolio-thumbnail">
                        </figure>
                        <div class="file">
                            <label class="button is-light">
                                <input type="file" style="display:none" id="thumbnail" v-on:change.prevent="uploadThumbnail()">
                                <span class="icon"><i class="fa fa-image"></i></span>
                                <span>Select thumbnail</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-content">
                    <div class="field">
                        <h3 class="title is-5 bold">Upload work files</h3>
                        <p>You can upload multiple files formats like Images(PNG, JPG, GIF), Audio(MP3) &amp; Videos(MP4)</p>
                        <div style="margin:2em 0">
                            <div class="columns is-multiline portfolio-items">
                                <div class="column is-4" v-for="file in p.files">
                                    <div class="item">
                                        <figure class="image" v-if="images.indexOf(file.file_type) !== -1">
                                            <img :src="file.file">
                                        </figure>

                                        <video style="width:100%" controls v-if="file.file_type === 'video/mp4'">
                                            <source type="video/mp4" :src="file.file"></source>
                                        </video>

                                        <audio style="width:100%" controls v-if="audio.indexOf(file.file_type) !== -1">
                                            <source :type="file.file_type" :src="file.file"></source>
                                        </audio>
                                        <div class="field delete-file">
                                            <button class="button is-danger is-small" v-on:click.prevent="deleteFile(file, p.uid)"><i class="fa fa-close"></i> <span>Delete</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <label for="files-upload" class="button is-light">
                            <span class="icon"><i class="fa fa-upload"></i></span>
                            <span>Select files</span>
                            <input type="file" id="files-upload" style="display: none" multiple v-on:change="uploadPortfolioFiles()">
                        </label>

                        <div v-if="errors.length > 0" style="margin-top: 1em">
                            <p class="has-text-danger has-text-weight-bold" v-for="error in errors">{{ error }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="field">
                        <h3 class="title is-5 bold">Select the skill relevant to this work</h3>
                        <div class="ui relaxed horizontal list" v-if="skills">
                            <div class="item" v-for="skill in skills">
                                <label :for="skill.skill">
                                    <input type="radio" v-model="checkedSkills" :value="skill.skill" :id="skill.skill" > {{ skill.skill }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="field white-boxed">
                <button class="button is-info" v-on:click.prevent="publishPortfolio('publish')" :disabled="(p.thumbnail && p.files.length > 0) ? false : true" :class="{'is-loading' : isPublishing}">Publish work</button>
                <button class="button is-light" v-on:click.prevent="publishPortfolio('save')"  >Save &amp; continue later</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                p: (this.portfolio) ? JSON.parse(this.portfolio) : {files:[], thumbnail: null},
                errors: [],
                audio: ['audio/mp3', 'audio/mpga', 'audio/wav', 'audio/mpeg'],
                images: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'],
                caption: null,
                skills: (this.userSkills) ? JSON.parse(this.userSkills) : false,
                checkedSkills: (this.portfolio && JSON.parse(this.portfolio).skills) ? JSON.parse(this.portfolio).skills.split(",") : [],
                action: null,
                isPosting: false,
                isPublishing: false,
                files: [],
                formData: new FormData(),
            }
        },

        props: {
            portfolio: null,
            userSkills: null,
            isEditing: Boolean,
        },

        methods: {

            uploadThumbnail: function(){
                var thumbnail = document.getElementById('thumbnail').files[0],
                    _this = this;
                if ( _this.images.indexOf(thumbnail.type) !== -1 ){
                    var file = new FileReader();
                    file.onload = function(e){
                        _this.p.thumbnail = file.result;
                    }   
                    file.readAsDataURL(thumbnail);
                } else {
                    return false;
                }
            },

            uploadPortfolioFiles: function()
            {
                var files = document.getElementById('files-upload').files;
                if(files.length > 0){
                    var formats = [ 'image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'video/mp4', 'audio/mp3' ];
                    for(var i=0; i < files.length; i++){
                        // check file type
                        if(formats.indexOf(files[i].type) !== -1){                           
                            // check image file size
                            if ( files[i].size > 2000000 && ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'].indexOf(files[i].type) !== -1 ){
                                this.errors.push(files[i].name + ' is more than the allowed 2MB size limit for Images');
                                return;
                            }
                            // check audio file size
                            if ( files[i].size > 5000000 && ['audio/mp3'].indexOf(files[i].type) !== -1 ){
                                this.errors.push(files[i].name + ' is more than the allowed 5MB size limit for Audio files');
                                return;
                            }
                            // check video file size
                            if ( files[i].size > 20000000 && ['video/mp4'].indexOf(files[i].type) !== -1 ){
                                this.errors.push(files[i].name + ' is more than the allowed 10MB size limit for Video files');
                                return;
                            }
                            this.files.push(files[i]);
                            this.uploadFile(files[i]);
                        } else {
                            this.errors.push(files[i].name + ' is an invalid file format');
                        }
                    }
                } else {
                    return false;
                }
            },

            uploadFile: function(file){
                var _this = this;
                var filereader = new FileReader();
                filereader.readAsDataURL(file);
                filereader.onload = function(e){
                    _this.p.files.push({ file: filereader.result, file_type: file.type });  
                }
            },

            deleteFile: function(file, uid=null){
                var _this = this;
                if(window.confirm("Do you really want to delete this file?")){
                    _this.isPosting = true;
                    if ( _this.isEditing === true ){
                        var url = /^(https?):\/\//;
                        if ( url.test(file.file) ){
                            axios.delete('/dashboard/portfolio/'+uid+'/'+file.id+'/delete').then( response => {
                                _this.isPosting = false;
                                iziToast.success({
                                    title: 'File deleted!',
                                });
                                _this.p.files.splice(_this.p.files.indexOf(file), 1);
                            });
                        } else {
                            _this.isPosting = false;
                            _this.p.files.splice(_this.p.files.indexOf(file), 1);
                            _this.files.splice(_this.files.indexOf(file), 1);
                        }
                    }
                    
                } else {
                    _this.isPosting = false;
                    return;
                }
            },

            publishPortfolio: function(action){
                var _this = this,
                    url = null;

                _this.formData.append('title', _this.p.title);
                _this.formData.append('description', _this.p.description);
                _this.formData.append('skills', _this.checkedSkills);
                _this.formData.append('uid', _this.p.uid);
                
                _this.formData.append('action', action);
                for ( let i = 0; i < this.files.length; i++ ){
                    _this.formData.append('files[]', this.files[i]);
                }
                _this.isPosting = true;
                var config = {
                    headers: {'Content-Type' : 'multipart/form-data'},
                }

                // Check to see if we are editing then set the url accordingly
                if ( _this.isEditing === true ){
                    // Set the post url for axios
                    url = '/dashboard/portfolio/'+ _this.p.uid +'/edit';

                    // Set the form method to PUT
                    _this.formData.append('_method', 'put');

                    // Check if a new thumbnail was uploaded
                    if ( document.getElementById('thumbnail').files.length > 0 ){
                        _this.formData.append('thumbnail', document.getElementById('thumbnail').files[0]);
                    }
                } else {
                    _this.formData.append('thumbnail', document.getElementById('thumbnail').files[0]);
                    url = '/dashboard/portfolio/new';
                }

                axios.post(url, _this.formData, config).then( (response) => {
                    _this.isPosting = false;
                    console.log(response);
                    if(_this.action === 'save'){
                        if ( _this.isEditing === true ){
                            iziToast.success({
                                title: 'Portfolio updated successfully!',
                            });
                        } else {
                            iziToast.success({
                                title: 'Portfolio saved successfully!',
                            });
                        }
                        
                    } else {
                        if ( _this.isEditing === true ){
                            iziToast.success({
                                title: 'Portfolio changes published successfully!',
                            });
                        } else {
                            iziToast.success({
                                title: 'Portfolio published successfully!',
                            });
                        }
                    }
                    window.location.href = window.Laravel.url + '/dashboard/portfolio';
                }).catch( (error) => {
                    _this.isPosting = false;
                    // console.log(error);
                });
            },
        },

        mounted() {
            if ( this.isEditing === true ){
                // Check the portfolio description for "undefined" and remove it
                if ( this.p.description == 'undefined' ){
                    this.p.description = '';
                }
            }
        },
    }
</script>
