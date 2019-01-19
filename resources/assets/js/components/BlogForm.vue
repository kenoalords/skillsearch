<template>
    <div class="container">
        <div id="image-warning" v-if="imageWarning">
            <div class="content">
                <h2><i class="fa fa-warning-sign"></i></h2>
                <h3>Please upload an image size of 1240px by 800px</h3>
                <p><a href="#" v-on:click.prevent="imageWarning = false" class="button is-small is-danger">OK! Got It</a></p>
            </div>
        </div>
        <form action="#" id="blog-form"> 
            <ul class="errors" v-if="errors.length">
                <li v-for="error in errors">{{ error }}</li>
            </ul>         
            <label id="blog-image">
                <div class="info">
                    <i class="fa fa-image"></i>
                </div>
                <input type="file" class="is-hidden" id="imageUpload" accept="image/*" v-on:change.prevent="uploadBlogImage">
            </label>
            
            <div>
                <div>
                    <div class="field">
                        <input id="title" type="text" class="input" placeholder="Title"  name="title" v-model.trim="content.title" required autofocus>
                    </div>

                    <div class="field">
                        <textarea v-model="content.body" rows="5" class="textarea" placeholder="Write something interesting..."></textarea>
                    </div>

                    <div class="field">
                        <label for="excerpt">Provide a brief summary</label>
                        <textarea v-model="content.excerpt" id="excerpt" rows="2" class="textarea"></textarea>
                        <p class="help">This will help people understand what your blog post is about</p>
                    </div>
                    
                    <div class="field">
                        <label for="">Choose category</label>
                        <div class="control">
                            <div class="select">
                                <select v-model="content.category" v-if="blogCategories">
                                    <option value="0">Select</option>
                                    <option :value="category.category" v-for="category in blogCategories">{{category.category}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label>Tags</label>
                        <input type="text" v-model="content.tags" class="tags input" placeholder="e.g Fashion, Makeup etc.">
                        <small class="help">A comma seperated list of tags.</small>
                    </div>

                    <div class="field">
                        <label class="checkbox">
                            <input v-model="content.allow_comments" type="checkbox" class="checkbox" v-bind:value="true">
                                Allow comments
                        </label>
                    </div>

                    <div class="field">
                        <div class="level is-mobile">
                            <div class="level-left">
                                <div class="level-item">
                                    <button id="submit-button" class="button is-info" type="submit" v-model="content.status" value="publish" @click.prevent="submitBlogPost">Publish</button>
                                </div>
                                <div class="level-item">
                                    <button class="button is-light" type="submit" v-model="content.status" value="save">Save &amp; continue later</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import Quill from "quilljs/dist/quill";
    import Cropper from 'cropperjs';

    export default {
        data(){
            return {
                content: {},
                blogCategories: JSON.parse(this.categories),
                imageWarning: false,
                isUploadingImage: false,
                isEditing: false,
                image: null,
                errors: [],
                blogId: null,
                data: new FormData(),
            }
        },
        props:{
            blog: {},
            categories: null,
        },
        methods: {
            uploadBlogImage(){
                $('body').addClass('is-loading');
                this.isUploadingImage = true;
                var form = new FormData(),
                    image = document.getElementById('imageUpload').files[0],
                    imageContainer = document.getElementById('blog-image'),
                    _this = this,
                    _URL = window.URL || window.webkitURL;

                if ( image ) {
                    var file = new FileReader();
                    file.readAsDataURL(image);
                    file.onload = function(e){
                        $('body').removeClass('is-loading');
                        imageContainer.style.background = 'url(' + file.result + ') no-repeat center';
                        imageContainer.style.backgroundSize = 'cover';
                        _this.content.image = image;
                    }

                    file.onerror = function(e){
                        $('body').removeClass('is-loading');
                        iziToast.error({ title: 'Failed!', message: 'A problem occured while uploading the file, please try again.' })
                    }
                } else {
                    $('body').removeClass('is-loading');
                }
                
                // setTimeout(()=>{

                //     img.onload = function(){
                //         // if(img.width < 1200 || img.height > 800){
                //         //     _this.imageWarning = true;
                //         //     return;
                //         // }
                //         var image = document.getElementById('blog-thumbnail');
                //         var cropper = new Cropper(image,{
                //             aspectRatio: 16/9,
                //             dragMode: 'move',
                //             rotatable: false,
                //             zoomable: false,
                //             scalable: false,
                //             cropBoxResizable: false,
                //         });
                //         document.getElementById('save-image').addEventListener('click', function(e){
                //             cropper.getCroppedCanvas({
                //                 width: 1240,
                //                 height: 698,
                //                 imageSmoothingQuality: 'high',
                //             }).toBlob(function(blob){
                //                 var form = new FormData();
                //                 form.append('image', blob);
                //                 form.append('id', _this.content.id);
                //                 form.append('title', _this.content.title);
                //                 form.append('body', _this.content.body);
                //                 form.append('excerpt', _this.content.excerpt);
                //                 form.append('allow_comments', _this.content.allow_comments);
                //                 form.append('category', _this.content.category);
                //                 axios.post('/profile/blog/add/image', form).then( (response)=> {
                //                     console.log(response);
                //                     _this.content = response.data;
                //                     history.pushState(response.data, null, window.Laravel.url + '/profile/blog/'+response.data.uid+'/edit');
                //                 })
                //             }, 'image/jpeg', 0.99);
                //         })
                //     };
                //     img.src = _URL.createObjectURL(image);
                //     img.setAttribute('id', 'blog-thumbnail');
                //     var el = document.getElementById('image-preview');
                //     el.appendChild(img);

                //     return;

                // },100);

                

                // form.append('image', image);
                // form.append('title', _this.content.title);
                // form.append('body', _this.content.body);
                // form.append('category', _this.content.category);
                // form.append('excerpt', _this.content.excerpt);
                // form.append('id', _this.content.id);

                // axios.post('/profile/blog/add/image', form).then( (response)=> {
                //     _this.content = response.data;
                // })
            },
            submitBlogPost(e){
                e.preventDefault();
                $('body').addClass('is-loading');
                var _this = this;

                // Reset errors array
                this.errors = [];

                // Check blog title
                if ( !this.content.title ){
                    this.errors.push( 'Title is required' );
                }

                // Check if blog content is empty
                if ( !this.content.body ){
                    this.errors.push( 'Content is required' );
                }

                // Check blog category
                if ( !this.content.category ){
                    this.errors.push( 'Please select a category' )
                }

                // Check blog excerpt
                if ( !this.content.excerpt ){
                    this.errors.push( 'Please provide a summary of your blog post' );
                }

                if ( this.errors.length > 0 ){
                    alert('Please check for errors in your form');
                    window.scrollTo(0, 0);
                    $('body').removeClass('is-loading');
                    return false;
                }
                var payload = new FormData();
                payload.append('title', this.content.title);
                payload.append('body', this.content.body);
                payload.append('id', (this.content.id) ? this.content.id : '' );
                payload.append('image', (this.content.image) ? this.content.image : '');
                payload.append('category', this.content.category);
                payload.append('excerpt', this.content.excerpt);
                payload.append('tags', (this.content.tags) ? this.content.tags : '');
                payload.append('is_public', true);
                payload.append('status', 'publish');
                payload.append('allow_comments', (this.content.allow_comments) ? this.content.allow_comments : false);

                if ( this.isEditing === false ){
                    axios.post('/dashboard/blog/new', payload).then( (response) => {
                        iziToast.success({ title: 'Success!', message: 'Your blog post was successful.' });
                        $('body').removeClass('is-loading');
                        return;
                    }).catch( (e)=>{
                        iziToast.error({ title: 'Error', message: 'An error occured while processing your request' });
                        $('body').removeClass('is-loading');
                        return;
                    } );
                }

                if ( this.isEditing === true ){
                    payload.append('_method', 'PUT');
                    axios.post('/dashboard/blog/'+ this.blogId +'/edit', payload).then( (response) => {
                        iziToast.success({ title: 'Success!', message: 'Your blog post was edited successful.' });
                        $('body').removeClass('is-loading');
                        console.log(response.data);
                        return;
                    }).catch( (e)=>{
                        iziToast.error({ title: 'Error', message: 'An error occured while editing your request' });
                        $('body').removeClass('is-loading');
                        return;
                    } );
                }
                
            },
        },
        mounted() {
            var toolbarOptions = [
                [{ header: [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                ['image', 'code-block']
            ];

            if(this.blog !== undefined){
                var blog = JSON.parse(this.blog);
                this.content = blog;
                if ( blog.hasOwnProperty('image') && blog.image !== null ){
                    $('#blog-image').css({
                        background: 'url('+ window.Laravel.url +'/'+ blog.image +') no-repeat center',
                        backgroundSize: 'cover',
                    });
                }

                if ( blog.hasOwnProperty('id') ){
                    $('#submit-button').text('Publish edit');
                    this.isEditing = true;
                    this.blogId = blog.id;
                }
            }
        }
    }
</script>
