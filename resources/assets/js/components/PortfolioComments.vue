<template>
    <div>
        <div v-if="user" class="box is-raised is-radiusless" style="padding: 1em;">
            <div class="media">
                <div class="media-left">
                    <div class="image is-64x64">
                        <img :src="userImage" alt="Avatar" class="image is-rounded">
                    </div>
                </div>
                <div class="media-content">
                    <div class="content">
                        <div class="field">
                            <textarea v-model="comment" class="textarea" rows="2" placeholder="Leave your comment here..."></textarea>
                        </div>
                        <button class="button is-info is-small" v-on:click.prevent="submitComment()" :disabled="isSubmitting" :class="{'is-loading': isSubmitting}">Comment</button>  
                    </div>
                </div>
            </div>
        </div>
        <div v-if="comments"  id="comments">
            <h4 class="title is-5 loading-icon" v-if="isLoading"><img :src="loadingGif"> Loading comments...</h4>
            <h4 class="title is-5" v-if="!isLoading">{{comments.length}} {{comments.length > 1 ? 'Comments' : 'Comment'}}</h4>
            <div class="comments">
                <div class="media box is-raised is-radiusless" :class="{'new' : newComment}" v-for="comment in comments">
                    <div class="media-left">
                        <a :href="'/'+comment.profile.data.username" class="image is-48x48">
                            <img :src="comment.profile.data.avatar" :alt="comment.profile.data.first_name" class="image is-rounded">
                        </a>
                    </div>
                    <div class="media-content">
                        <div class="content">
                            <p>
                                <a v-bind:href="'/'+comment.profile.data.username" class="has-text-weight-bold has-text-grey-dark" :class="{'verified' : comment.profile.data.verified }">{{comment.profile.data.first_name}} {{comment.profile.data.last_name}}</a> <small v-html="comment.date"></small> <br>
                                {{ comment.comment  }}
                            </p>
                        </div> 

                        <!-- Comment action links -->
                        <div class="level is-mobile">
                            <div class="level-left">
                                <div class="level-item">
                                    <a href="#" class="has-text-danger has-text-weight-bold is-size-7" v-on:click.prevent="submitCommentLike(comment)" v-bind:class="{ active : isLiking }"><i class="fa fa-heart"></i> <span :id="'comment-'+comment.id">{{ comment.likes }}</span></a>
                                </div>
                                <div class="level-item">
                                    <a href="#" v-on:click.prevent="toggleReplyField(comment.id)" class="has-text-weight-bold is-size-7 has-text-info" v-if="user"><i class="fa fa-reply"></i> Reply</a>
                                </div>
                                <div class="level-item">
                                    <a href="#" v-on:click.prevent="deleteComment(comment)" class="has-text-grey-light has-text-weight-bold is-size-7 " v-if="user && comment.user_id === user_id"><i class="fa fa-close"></i> Delete</a>
                                </div>
                            </div>
                        </div> <!-- Comment action link end -->


                        <!-- Comment reply form -->
                        <div v-if="isReplyActive === comment.id" class="media">
                            <div class="media-left">
                                <div class="image is-48x48">
                                    <img :src="userImage" alt="Avatar" class="image is-rounded">
                                </div>
                            </div>
                            <div class="media-content">
                                <div class="content">
                                    <div class="field">
                                        <textarea v-model="reply" rows="1" placeholder="Reply..." class="textarea"></textarea>
                                    </div>
                                    <div class="field">
                                        <button class="button is-info is-small" :class="{ 'is-loading' : isReplySubmitting }" v-on:click.prevent="submitReply(comment.id)" :disabled="isReplySubmitting || reply == null">Reply</button>
                                        <small><a href="#" class="button is-white is-small" v-on:click.prevent="closeReply()"><i class="fa fa-close"></i></a></small>
                                    </div>  
                                </div>
                            </div>
                        </div> <!-- Comment form end -->
                        
                        <!-- Comment replies -->
                        <div v-if="comment.replies.data">
                            <div v-if="comment.replies.data.length > 0">
                                <h4 class="title is-7" style="margin-bottom: 10px;">{{ comment.replies.data.length }} {{ comment.replies.data.length > 1 ? 'Replies' : 'Reply'}}</h4>
                            </div>
                            <div class="media" v-for="reply in comment.replies.data">
                                <div class="media-left">
                                    <a v-bind:href="'/'+reply.profile.data.username" class="image is-48x48">
                                        <img :src="reply.profile.data.avatar" :alt="reply.profile.data.first_name" class="image is-rounded">
                                    </a>
                                </div>
                                <div class="media-content">
                                    <div class="content">
                                        <p>
                                            <a v-bind:href="'/'+reply.profile.data.username" :class="{ 'verified' : reply.profile.data.verified }" class="has-text-weight-bold has-text-grey-dark">{{reply.profile.data.first_name}}</a> <small>{{ reply.date }}</small>
                                            <br>
                                            <span v-html="reply.comment" class="text"></span>
                                        </p>
                                        
                                        <div class="level is-mobile">
                                            <div class="level-left">
                                                <a href="#" class="level-item has-text-danger is-size-7 has-text-weight-bold" v-on:click.prevent="submitCommentLike(reply)" v-bind:class="{ active : isLiking }"><span class="icon"><i class="fa fa-heart"></i></span> <span>{{ reply.likes }}</span></a>
                                                <a href="#" v-on:click.prevent="deleteReply(reply, comment.id)" class="level-item has-text-grey is-size-7 has-text-weight-bold " v-if="user && reply.user_id === user_id"><span class="icon"><i class="fa fa-close"></i></span> <span>Delete</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- Comment replies end -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // import Echo from "laravel-echo";
    export default {
        data(){
            return{
                comments: [],
                comment: null,
                user: window.Laravel.userLoggedIn,
                user_id: window.Laravel.user_id,
                isSubmitting: false,
                isReplyActive: null,
                isReplySubmitting: false,
                reply: null,
                isLiking: false,
                userImage: this.avatar,
                newComment: false,
                isLoading: true,
                loadingGif: window.Laravel.url + '/images/loading.gif',
            }
        },
        props: {
            uid: null,
            avatar: null
        },
        methods: {
            getComments(){
                var _this = this;
                axios.get('/portfolio/'+this.uid+'/comments').then((response)=>{
                    _this.isLoading = false;
                    _this.comments = response.data.data;
                });
            },
            submitComment(){
                if(this.comment === null){
                    alert('Please enter a comment');
                    return;
                }
                var data = {
                    comment : this.comment
                }
                var _this = this;
                _this.isSubmitting = true;
                axios.post('/portfolio/'+this.uid+'/comment/add', data).then((response)=>{
                    _this.comment = null;
                    _this.isSubmitting = false;
                    iziToast.success({ title : 'Comment posted!'});
                    _this.comments.unshift(response.data.data);
                    
                });
            },
            deleteComment(comment){
                var _this = this;
                if(window.confirm('Do you really want to delete this comment?')){
                    axios.delete('/comment/' + comment.id + '/delete').then((response)=>{
                        // console.log(response);
                        _this.comments.splice(_this.comments.indexOf(comment), 1);
                    });
                }
            },
            deleteReply(reply, commentId){
                var _this = this;

                if(window.confirm('Do you really want to delete this reply?')){
                    axios.delete('/comment/' + reply.id + '/delete').then((response)=>{
                        // console.log(response);
                        // _this.comments.splice(_this.comments.indexOf(comment), 1);
                        iziToast.success({ title : 'Reply deleted!'});
                        _this.comments.map((comment, index)=>{
                            if(comment.id === commentId){
                                _this.comments[index].replies.data.splice(_this.comments[index].replies.data.indexOf(reply), 1);
                            }
                        })
                    });
                }
            },
            submitCommentLike(comment){
                var _this = this;
                _this.isLiking = true;
                if(!_this.user){
                    alert('Please login to like this comment');
                    _this.isLiking = false;
                    return;
                }
                var data = {
                    comment_id : comment.id
                };
                axios.post('/comment/' + comment.id + '/like', data).then((response)=>{
                    _this.isLiking = false;
                    comment.likes = response.data.likes;
                    iziToast.success({ title : 'Liked!'});
                })
            },
            submitReply(commentId){
                var data = {
                    comment : this.reply,
                    id: commentId,
                }
                var _this = this;
                _this.isReplySubmitting = true;
                axios.post('/portfolio/'+this.uid+'/comment/add', data).then((response)=>{
                    _this.reply = null;
                    _this.isReplySubmitting = false;
                    _this.isReplyActive = null;
                    iziToast.success({ title : 'Reply posted!'});
                    _this.comments.map((comment, index)=>{
                        if(comment.id === commentId){
                            _this.comments[index].replies.data.push(response.data.data)
                        }
                    })
                });
            },
            toggleReplyField(commentID){
                this.isReplyActive = commentID;
            },

            closeReply(){
                this.isReplyActive = null;
            },

            isVerifiedUser(verified){
                if(verified === true){
                    return '<img src="'+window.Laravel.url+'/public/verified.svg" width="14" height="14">';
                }
            }
        },
        mounted() {
            this.getComments();
            // Echo.channel('portfolio.'+this.uid).listen('CommentPostedEvent', (e)=>{
            //     // console.log(e);
            //     this.comments.unshift(e.comment.data);

            // });
        }
    }
</script>
