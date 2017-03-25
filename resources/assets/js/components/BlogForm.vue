<template>
    <div>
        
        <form action="/blog/add" method="post" id="blog-form">

            <label id="blog-image">
                <input type="file" class="hidden" id="imageUpload" v-on:change.prevent="uploadBlogImage">
            </label>
            
            <div class="form-group">
                <input id="title" type="text" placeholder="Title"  name="title" v-model="title" required autofocus>
            </div>

            <div class="form-group">
                <textarea name="body" placeholder="Write something interesting..." rows="10" v-model="body"></textarea>
            </div>

            <div class="form-group">
                <input id="tags" type="text" placeholder="Comma seperated tags"  name="tags" v-model="tags">
            </div>

            <div class="form-group clearfix">
                <button class="btn btn-primary pull-left" type="submit">Publish</button>
                <button class="btn btn-default pull-right" v-on:click.prevent="saveBlogPost">Save &amp; continue later</button>
            </div>

        </form>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                title: null,
                body: null,
                tags: null,
                image: null,
                blogID: null,
            }
        },
        methods: {
            uploadBlogImage(){
                var form = new FormData(),
                    image = document.getElementById('imageUpload').files[0],
                    _this = this;
                form.append('image', image);
                form.append('id', this.blogID);
                form.append('body', this.body);
                form.append('title', this.title);
                form.append('tags', this.tags);

                axios.post('/blog/add/image', form).then( (response)=> {
                    _this.blogID = response.data.id;
                    _this.image = response.data.image;
                })
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
            // console.log(this.title)
        }
    }
</script>
