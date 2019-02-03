<template>
    <span>
        <div class="comment-form">


            <div class="panel-loader" v-if="loading">
                <span class="spinner"></span>
            </div>


            <div v-if="!loading">
                <span v-if="count == 0">
                    <h3 class="title is-4">Be the first to leave a comment</h3>
                </span>
                <h3 class="title is-4" v-if="count == 1">One comment</h3>
                <h3 class="title is-4" v-if="count > 1">{{ count }} comments</h3>
            </div>
            


            <div class="media" v-if="!loading && userLoggedIn">
                <!-- <div class="media-left">
                    <p class="image is-48x48">
                        <img src="https://bulma.io/images/placeholders/128x128.png">
                    </p>
                </div> -->
                <div class="media-content">
                    <form action="#" @submit.prevent="submitComment">
                        <div class="field">
                            <textarea v-model="body" rows="2" class="textarea" @keyup="checkCommentCount"></textarea>
                        </div>
                        <div class="field">
                            <button type="submit" :class="{ 'is-loading' : isSubmitting }" class="button is-info" :disabled="isDisabled">Comment</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="notification is-info" v-if="!userLoggedIn">
                Please <a href="/login">login</a> to share your comment.
            </div>
        </div>


        <div class="comments" v-if="comments.length > 0">
            <div class="media" v-for="comment in comments" :id="'comment-' + comment.id">
                <div class="media-left">
                    <p class="image is-rounded is-48x48">
                        <a :href="comment.profile.url"><img :src="comment.profile.avatar" :alt="comment.profile.fullname"></a>
                    </p>
                </div>
                <div class="media-content card">
                    <div class="card-content">
                        <strong><a :href="comment.profile.url">{{ comment.profile.fullname }}</a></strong> <span class="date">{{ comment.date }}</span>
                        <p>{{ comment.comment }}</p>

                        <div class="level is-mobile meta" v-if="userLoggedIn">
                            <div class="level-left">
                                <div class="level-item">
                                    <a href="#" v-on:click.prevent="likeComment(comment.id, comment, $event)" class="button is-small is-white" :class="{ 'is-loading' : isLikingComment }">
                                        <span class="icon"><i class="fa fa-thumbs-up"></i></span> {{ comment.likes }} <span style="margin-left: 5px;">Like</span>
                                    </a>
                                </div>
                                <div class="level-item">
                                    <a href="#" v-on:click.prevent="replyComment(comment.id)" class="button is-white is-small">
                                        <span class="icon"><i class="fa fa-reply"></i></span> <span>Reply</span>
                                    </a>
                                </div>
                                <div class="level-item">
                                    <!-- <a href="#" v-on:click.prevent="replyComment(comment.id)">
                                        <span class="icon"><i class="fa fa-eye-slash"></i></span> <span>Hide comment</span>
                                    </a> -->
                                </div>
                            </div>
                        </div>

                        <!-- Replies -->
                        <div class="replies" v-if="comment.replies.length">
                            <h4 class="title is-7">{{ comment.replies.length }} {{ comment.replies.length > 1 ? 'Replies' : 'Reply' }}</h4>
                            <div class="reply" v-for="reply in comment.replies">
                                <strong><a :href="reply.profile.url">{{ reply.profile.fullname }}</a></strong> <span class="date">{{ reply.date }}</span>
                                <p>{{ reply.comment }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="reply-comment-form" v-show="isReplying">
            <form action="#">
                <div class="field">
                    <textarea v-model="reply" rows="2" class="textarea" v-on:keyup="checkCommentReply"></textarea>
                </div>
                <div class="field">
                    <button type="submit" class="button is-info is-small" :disabled="isReplyButtonDisabled" v-on:click.prevent="submitCommentReply"><span class="icon"><i class="fa fa-reply"></i></span> <span>Reply</span></button> 
                    <button class="button is-light is-small" v-on:click.prevent="isReplying = false">Cancel</button>
                </div>
            </form>
        </div>

    </span>
</template>

<script>
    import $ from "jquery";
    export default {
        data(){
            return {
                body: null,
                isDisabled: true,
                count: 0,
                loading: true,
                userLoggedIn: window.Laravel.userLoggedIn,
                isSubmitting: false,
                comments: [],
                reply: null,
                isReplying: false,
                replyCommentID: null,
                isReplyButtonDisabled: true,
                isLikingComment: false,
            }
        },
        props: {
            blogid: Number,
        },
        methods: {
            submitComment: function(e){
                let _this = this,
                    data = {
                        comment: this.body,
                    };
                _this.isSubmitting = true;
                _this.isDisabled = true;
                axios.post('/dashboard/blog/' + this.blogid + '/comment', data).then( (response)=>{
                    _this.isSubmitting = false;
                    _this.isDisabled = false;
                    _this.body = null;
                    _this.count += 1;
                    iziToast.success({ title: 'Comment posted successfully!' });
                    _this.comments.unshift(response.data)
                } ).catch( (e)=>{
                    _this.isSubmitting = false;
                    _this.isDisabled = false;
                    alert('An error occured while submitting your comment');
                    iziToast.error({ title: 'An error occured!' });
                    return;
                } );
            },
            checkCommentCount: function(e){
                if ( this.body.length > 0 ){
                    this.isDisabled = false;
                } else {
                    this.isDisabled = true;
                }
            },
            getCommentCount: function(){
                var _this = this;
                axios.get('/blog/' + this.blogid + '/comments/count').then(function(response){
                    _this.count = response.data.count;
                    _this.comments = response.data.comments;
                    _this.loading = false;
                }).catch(function(e){
                    console.log('Couldn\'t retrieve blog count', e);
                });
            },
            likeComment: function(id, comment, event){
                let _this = this,
                    target = event.target,
                    button;
                // _this.isLikingComment = true;
                if ( target.tagName.toLowerCase() === 'i' || target.tagName.toLowerCase() === 'span' ){
                    button = $(target).closest('a');
                } else {
                    button = $(target);
                }
                button.addClass('is-loading');
                axios.post('/dashboard/blog/' + this.blogid + '/comment/' + id + '/like').then( (response) => {
                    
                    if ( response.data.status === true ){
                        iziToast.success({ title: 'Comment liked!' });
                        let index = _this.comments.indexOf(comment);
                        _this.comments[index].likes = response.data.count;
                        button.removeClass('is-loading');
                    }
                    if ( response.data.status === 'liked' ){
                        iziToast.info({ title: 'You already like this comment' });
                        button.removeClass('is-loading');
                    }
                    _this.isLikingComment = false;
                }).catch( (error) => {
                    console.log(error);
                    _this.isLikingComment = false;
                    iziToast.error({ title: 'An error occured.' });
                    button.removeClass('is-loading');
                });
            },
            replyComment: function(id){
                this.isReplying = true;
                this.replyCommentID = id;
                setTimeout(function(){
                    $('#comment-' + id).find('.card-content').append($('.reply-comment-form'));
                });
            },
            hideComment: function(id){

            },
            submitCommentReply: function(){
                let _this = this,
                    data = {
                        reply: this.reply,
                        comment_id: this.replyCommentID,
                    };
                    this.isReplyButtonDisabled = true;
                axios.post('/dashboard/blog/' + this.blogid + '/comment/reply', data).then( (response) => {
                    _this.comments.map((comment, index)=>{
                        if(comment.id === _this.replyCommentID){
                            _this.comments[index].replies.push(response.data);
                        }
                    });
                    iziToast.success({ title: 'Reply posted successfully!' });
                    _this.isReplyButtonDisabled = false;
                    _this.reply = null;
                    _this.replyCommentID = null;
                    _this.isReplying = false;
                } ).catch( (error) => {
                    alert('An error occured while posting your reply');
                    iziToast.error({ title: 'An error occured!' });
                    this.isReplyButtonDisabled = false;
                    return;
                } )
            },
            checkCommentReply: function(){
                if ( this.reply.length > 3 ){
                    this.isReplyButtonDisabled = false;
                } else {
                    this.isReplyButtonDisabled = true;
                }
            }
        },
        mounted() {
            this.getCommentCount()
        }
    }
</script>
