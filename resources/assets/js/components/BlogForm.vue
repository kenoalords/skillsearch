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
                        <vue-editor v-model="content.body" useCustomImageHandler id="editor" @imageAdded="handleImageAdded" placeholder="Write something interesting..."></vue-editor>
                        <!-- <textarea  rows="5" class="textarea" placeholder="Write something interesting..."></textarea> -->
                    </div>

                    <div class="field">
                        <label for="excerpt">Provide a brief summary</label>
                        <textarea v-model="content.excerpt" id="excerpt" rows="2" class="textarea" maxlength="150"></textarea>
                        <p class="help">This will help people understand what your blog post is about. Maximum of 150 characters.</p>
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
    import Cropper from 'cropperjs';
    import { VueEditor } from 'vue2-editor';
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
        components: {
            VueEditor
        },
        props:{
            blog: {},
            categories: null,
        },
        methods: {
            handleImageAdded(image, Editor, cursorLocation, resetUploader){
                $('body').addClass('is-loading');
                var form = new FormData();
                form.append('image', image);
                axios.post('/dashboard/blog/image-upload', form).then( (response)=>{
                    $('body').removeClass('is-loading');
                    var url = response.data.url;
                    Editor.insertEmbed(cursorLocation, 'image', url);
                    resetUploader();
                    // console.log(response.data);
                } ).catch ( (error) => {
                    $('body').removeClass('is-loading');
                    iziToast.error({ title: 'Sorry we couldn\'t upload your image' });
                } )
            },
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
            },
            submitBlogPost(e){
                e.preventDefault();
                $('body').addClass('is-loading');
                var _this = this,
                    allow_comments = (this.content.allow_comments === true) ? true : false;

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

                if ( this.content.excerpt.length > 150 ){
                    this.errors.push( 'The summary shouldn\'t be more than 150 characters' );
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
                payload.append('allow_comments', allow_comments);

                if ( this.isEditing === false ){
                    axios.post('/dashboard/blog/new', payload).then( (response) => {
                        iziToast.success({ title: 'Success!', message: 'Your blog post was successful.' });
                        $('body').removeClass('is-loading');
                        window.location.href = '/dashboard/blog';
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
                        window.location.href = '/dashboard/blog';
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
                    $('#submit-button').text('Publish update');
                    this.isEditing = true;
                    this.blogId = blog.id;
                }
            }
        }
    }
</script>
