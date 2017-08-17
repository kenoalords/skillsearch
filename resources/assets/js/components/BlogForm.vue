<template>
    <div class="container-fluid">
        <div id="image-warning" v-if="imageWarning">
            <div class="content">
                <h2><i class="glyphicon glyphicon-picture"></i></h2>
                <h3>Please upload an image size of 1240px by 800px</h3>
                <p><a href="#" v-on:click.prevent="imageWarning = false" class="btn btn-default btn-xs">OK! Got It</a></p>
            </div>
        </div>
        <form action="/profile/blog/add" method="post" id="blog-form">
            <div id="image-preview" v-if="isUploadingImage">
                <div class="toolbar">
                    <ul class="list-inline">
                        <li><a v-on:click.prevent="" href="#" id="save-image" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Save Image</a></li>
                        <li><a v-on:click.prevent="" href="#" id="delete-image" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Delete Image</a></li>
                    </ul>
                </div>
            </div>
            <label id="blog-image" v-if="!isUploadingImage">
                <div class="info">
                    <h2 class="bold">Upload Image</h2>
                    <h4 class="thin">Every blog post deserves a <em class="bold">Big, Bold and Beautiful</em> image</h4>
                    <p><span class="btn btn-xs btn-success">Select Image</span></p>
                </div>
                <input type="file" class="hidden" id="imageUpload" accept="image/*" v-on:change.prevent="uploadBlogImage">
            </label>
            
            <div class="container">
                <div class="col-md-8 col-md-offset-2 padded">
                    <div class="form-group">
                        <input id="title" type="text" placeholder="Title"  name="title" v-model="content.title" required autofocus>
                    </div>

                    <div class="form-group" id="editable">
                        <div class="md-editor" id="md-editor"></div>
                    </div>

                    <div class="form-group">
                        <label for="excerpt">Excerpt (Summary)</label>
                        <textarea v-model="content.excerpt" id="excerpt" rows="3" class="form-control"></textarea>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 3em">
                        <label for="">Choose category</label><br>
                        <select v-model="content.category" v-if="blogCategories" class="selectpicker show-tick">
                            <option value="0">Select</option>
                            <option :value="category.category" v-for="category in blogCategories">{{category.category}}</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 3em">
                        <label>
                            <input v-model="content.allow_comments" type="checkbox" :value="1" class="option-input checkbox"> <span style="display: inline-block; margin-left: 1em">Allow comments</span>
                        </label>
                    </div>

                    <div class="form-group clearfix">
                        <button class="btn btn-primary pull-left" type="submit" v-on:click.prevent="publishBlogPost(content)">Publish</button>
                        <button class="btn btn-default pull-right" v-on:click.prevent="saveBlogPost">Save &amp; continue later</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import MediumEditor from "medium-editor/dist/js/medium-editor.js";
    import selectpicker from "bootstrap-select/dist/js/bootstrap-select.min.js";
    import Cropper from 'cropperjs';
    export default {
        data(){
            return {
                content: (this.blog) ? JSON.parse(this.blog) : [],
                blogCategories: JSON.parse(this.categories),
                imageWarning: false,
                isUploadingImage: false,
                isEditing: !!this.edit,
            }
        },
        props:{
            blog: null,
            categories: null,
            edit: null,
        },
        methods: {
            uploadBlogImage(){
                this.isUploadingImage = true;
                var form = new FormData(),
                    image = document.getElementById('imageUpload').files[0],
                    _this = this,
                    img = new Image(),
                    _URL = window.URL || window.webkitURL,
                    body = document.getElementById('md-editor').innerHTML;
                _this.content.body = body;

                // img.file = image;
                // var el = document.getElementById('image-preview');
                // el.appendChild(img);
                // file.onload = (function(aImg){
                //     return function(e){
                //         aImg.src = e.target.result;
                //     };
                // })(img);

                // file.readAsDataURL(image);
                setTimeout(()=>{

                    img.onload = function(){
                        // if(img.width < 1200 || img.height > 800){
                        //     _this.imageWarning = true;
                        //     return;
                        // }
                        var image = document.getElementById('blog-thumbnail');
                        var cropper = new Cropper(image,{
                            aspectRatio: 16/9,
                            dragMode: 'move',
                            rotatable: false,
                            zoomable: false,
                            scalable: false,
                            cropBoxResizable: false,
                        });
                        document.getElementById('save-image').addEventListener('click', function(e){
                            cropper.getCroppedCanvas({
                                width: 1240,
                                height: 698,
                                imageSmoothingQuality: 'high',
                            }).toBlob(function(blob){
                                var form = new FormData();
                                form.append('image', blob);
                                form.append('id', _this.content.id);
                                form.append('title', _this.content.title);
                                form.append('body', _this.content.body);
                                form.append('excerpt', _this.content.excerpt);
                                form.append('allow_comments', _this.content.allow_comments);
                                form.append('category', _this.content.category);
                                axios.post('/profile/blog/add/image', form).then( (response)=> {
                                    console.log(response);
                                    _this.content = response.data;
                                    history.pushState(response.data, null, window.Laravel.url + '/profile/blog/'+response.data.uid+'/edit');
                                })
                            }, 'image/jpeg', 0.99);
                        })
                    };
                    img.src = _URL.createObjectURL(image);
                    img.setAttribute('id', 'blog-thumbnail');
                    var el = document.getElementById('image-preview');
                    el.appendChild(img);

                    return;

                },100);

                

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

            publishBlogPost(content){
                var _this = this,
                    body = document.getElementById('md-editor').innerHTML,
                    data = new FormData();
                content.body = body;

                data.append('title', (_this.content.title) ? _this.content.title : 'Draft');
                data.append('body', (_this.content.body) ? _this.content.body : '' );
                data.append('id', (_this.content.id) ? _this.content.id : '' );
                data.append('image', (_this.content.image) ? _this.content.image : '');
                data.append('category', (_this.content.category) ? _this.content.category : '');
                data.append('excerpt', (_this.content.excerpt) ? _this.content.excerpt : '');
                data.append('allow_comments', (_this.content.allow_comments) ? _this.content.allow_comments : false);
                
                axios.post('/profile/blog/add', data).then( (response) => {
                    console.log(response);
                });
            },

            saveBlogPost(){
                var data = {
                    title : this.title,
                    body : this.body,
                    id : this.blogID,
                    tags : this.tags,
                };
                axios.post('/blog/add', data).then( (response) => {
                    console.log(response);
                });
            },
        },
        mounted() {
            var editor = new MediumEditor('.md-editor', {
                buttonLabels: 'fontawesome',
                anchor: {
                    targetCheckbox: true,
                },
                toolbar: {
                    buttons: ['bold', 'italic', 'underline', 'strikethrough', 'h2', 'h3', 'anchor', 'unorderedlist', 'orderedlist', 'quote'],
                    diffLeft: 25,
                    diffTop: -25,
                },
                placeholder: {
                    text: 'Write something interesting...',
                    hideOnClick: true,
                }
            });
            $('.selectpicker').selectpicker();
            console.log(this.isEditing);
            if(this.content){
                document.getElementById('md-editor').innerHTML = (this.content.body) ? this.content.body : '';
            }
        }
    }
</script>
