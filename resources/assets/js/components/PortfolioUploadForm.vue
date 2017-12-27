<template>
    <div>
        <form action="#" class="ui form" id="portfolio-form" :class="{'loading' : isPosting}">
            <div class="white-boxed">
                <div class="field">
                    <label for="title">Portfolio title</label>
                    <input type="text" id="title" v-model="p.title">
                </div>

                <div class="field">
                    <label for="description">Portfolio description (optional) </label>
                    <textarea rows="3" id="description" placeholder="Provide a short description about this portfolio" v-model="p.description"></textarea>
                </div>
            </div>
            <div class="field white-boxed">
                <h3 class="ui header">Upload thumbnail</h3>
                <label for="thumbnail" class="thumbnail-image">
                    <input type="file" style="display:none" id="thumbnail" 
                        v-on:change.prevent="uploadThumbnail()">
                    <img v-bind:src="p.thumbnail" v-if="p.thumbnail" class="ui fluid image">
                </label>
            </div>
            
            <div class="field white-boxed">
                <h3 class="ui header">
                    Upload portfolio files
                    <div class="sub header">You can upload multiple files formats like Images(PNG, JPG, GIF), Audio(MP3) &amp; Videos(MP4)</div>
                </h3>

                <div v-if="p.files && p.files.length > 0" style="margin:2em 0">
                    <div class="ui grid">
                        <div class="sixteen wide mobile ten wide tablet eight wide computer column">
                            <div class="ui divided items">
                                <div class="item" v-for="file in p.files">
                                    <div class="content">
                                        <img :src="file.file" v-if="images.indexOf(file.file_type) !== -1" class="ui fluid image">

                                        <video style="width:100%" controls v-if="file.file_type === 'video/mp4'">
                                            <source type="video/mp4" :src="file.file"></source>
                                        </video>

                                        <audio style="width:100%" controls v-if="audio.indexOf(file.file_type) !== -1">
                                            <source :type="file.file_type" :src="file.file"></source>
                                        </audio>
                                        <div class="field" style="margin-top: 1em">
                                            <button class="ui mini red icon labeled button" v-on:click.prevent="deleteFile(file, p.uid)"><i class="icon delete"></i>Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <label for="files-upload" class="ui green icon labeled button" style="display: inline-block; color: #fff">
                    <i class="icon upload"></i>Choose files
                    <input type="file" id="files-upload" style="display: none" multiple v-on:change="uploadPortfolioFiles()">
                </label>

                <div v-if="errors.length > 0">
                    <h4 class="ui red header">{{errors.length}} {{ (errors.length == 1) ? ' file' : ' files' }} failed!</h4>
                </div>
            </div>
            
            <div class="field white-boxed">
                <h4 class="ui header">
                    What category does this portfolio belong to?
                </h4>
                <div class="ui relaxed horizontal list" v-if="skills">
                    <div class="item" v-for="skill in skills">
                        <label :for="skill.skill">
                            <input type="checkbox" v-model="checkedSkills" :value="skill.skill" :id="skill.skill" > {{ skill.skill }}
                        </label>
                    </div>
                </div>
                <div><small>Please select at least on skill</small></div>
            </div>
            
            <div class="field white-boxed">
                <button class="ui green button" v-on:click.prevent="publishPortfolio('publish')" :disabled="(p.thumbnail && p.files.length > 0) ? false : true">Publish work</button>
                <button class="ui button" v-on:click.prevent="publishPortfolio('save')"  >Save &amp; continue later</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                p: (this.portfolio) ? JSON.parse(this.portfolio) : {},
                errors: [],
                audio: ['audio/mp3', 'audio/mpga', 'audio/wav', 'audio/mpeg'],
                images: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'],
                caption: null,
                skills: (this.userSkills) ? JSON.parse(this.userSkills) : false,
                checkedSkills: (this.portfolio && JSON.parse(this.portfolio).skills) ? JSON.parse(this.portfolio).skills.split(",") : [],
                action: null,
                isPosting: false,
            }
        },

        props: {
            portfolio: null,
            userSkills: null,
        },

        methods: {

            uploadThumbnail: function()
            {
                if(!this.p.hasOwnProperty('title')){
                    iziToast.error({
                        title: 'Oops!!!',
                        message: 'Please enter your portfolio title',
                        position: 'center',
                        transitionOut: 'fadeOutUp',
                    });
                    return false;
                }
                var thumbnail = document.getElementById('thumbnail').files[0],
                    formData = new FormData(),
                    _this = this,
                    uid = (this.p.uid) ? this.p.uid : '';
                    _this.isPosting = true;
                formData.append('file', thumbnail);
                formData.append('uid', uid);
                formData.append('title', this.p.title);
                formData.append('description', this.p.description);

                axios({
                    method: "POST",
                    data: formData,
                    url: '/profile/portfolio/add-thumbnail',
                    headers: {
                        'Content-Type'  : 'multipart/form-data',
                    }
                }).then((response)=>{
                    _this.isPosting = false;
                    _this.p = response.data;
                    // console.log(response.data);
                    iziToast.success({
                        title: 'Thumbnail uploaded!',
                    });
                }).catch((error)=>{
                    _this.isPosting = false;
                });
            },

            uploadPortfolioFiles: function()
            {
                if(!this.p.hasOwnProperty('title')){
                    iziToast.error({
                        title: 'Oops!!!',
                        message: 'Please enter your portfolio title',
                        position: 'center',
                        transitionOut: 'fadeOutUp',
                    });
                    return false;
                }

                var files = document.getElementById('files-upload').files;


                if(files.length > 0){
                    var formats = [
                                        'image/jpg', 
                                        'image/jpeg', 
                                        'image/gif',
                                        'image/png',
                                        'video/mp4',
                                        'audio/mp3',
                                    ];
                    for(var i=0; i < files.length; i++){
                        if(formats.indexOf(files[i].type) !== -1){
                            this.uploadFile(files[i]);
                        } else {
                            this.errors.push(files[i].name);
                        }
                    }
                } else {
                    return false;
                }
            },

            uploadFile: function(file){
                var formData = new FormData(),
                    _this = this,
                    uid = (this.p.uid) ? this.p.uid : '';
                _this.isPosting = true;
                formData.append('uid', uid);
                formData.append('file', file);
                formData.append('type', file['type']);
                axios({
                    method: "POST",
                    data: formData,
                    url: '/profile/portfolio/file-upload',
                    headers: {
                        'Content-Type' : 'multipart/form-data',
                    }

                }).then( (response) => {
                    _this.isPosting = false;
                    iziToast.success({
                        title: 'File uploaded!',
                    });
                    _this.p = response.data;
                }).catch( (error) => {
                    _this.isPosting = false;
                });
            },

            deleteFile: function(file, uid){
                var _this = this;
                _this.isPosting = true;
                if(window.confirm("Do you really want to delete this file?")){
                    axios.delete('/profile/portfolio/file-upload/'+uid+'/'+file.id+'/delete').then( (response) => {
                        _this.isPosting = false;
                        iziToast.success({
                            title: 'File deleted!',
                        });
                        _this.p.files.splice(_this.p.files.indexOf(file), 1);
                    });
                }
            },

            publishPortfolio: function(action){
                var formData = new FormData(),
                    _this = this;
                    formData.append('title', _this.p.title);
                    formData.append('description', _this.p.description);
                    formData.append('skills', _this.checkedSkills);
                    formData.append('uid', _this.p.uid);
                    formData.append('action', action);
                _this.isPosting = true;
                axios.post('/profile/portfolio/add', formData).then( (response) => {
                    _this.isPosting = false;
                    if(_this.action === 'save'){
                        iziToast.success({
                            title: 'Portfolio saved successfully!',
                            message: 'You rock!'
                        });
                    } else {
                        iziToast.success({
                            title: 'Portfolio published successfully!',
                            message: 'You rock!'
                        });
                    }
                    window.location.href = window.Laravel.url + '/profile/portfolio';
                }).catch( (error) => {
                    _this.isPosting = false;
                    // console.log(error);
                });
            },
        },

        mounted() {
            // console.log(this.portfolio);
        },
    }
</script>
