<template>
    <div>
        <div v-if="user" class="whiteCard">
            <div class="form-group">
                <textarea v-model="comment" class="form-control" rows="3" placeholder="Share a comment..."></textarea>
            </div>
            <button class="btn btn-primary" v-on:click.prevent="submitComment()" :disabled="isSubmitting">{{isSubmitting ? 'Submitting...' : 'Submit Comment'}}</button>
        </div>
        <div v-if="comments"  id="comments">
            <h3 class="bold">{{comments.length}} {{comments.length > 1 ? 'Comments' : 'Comment'}}</h3>
            <div class="media" v-for="comment in comments">
                <div class="media-left">
                    <a :href="'/'+comment.profile.data.username">
                        <img :src="comment.profile.data.avatar" :alt="comment.profile.data.first_name" width="48" height="48" class="img-circle">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading bold">
                        <a v-bind:href="'/'+comment.profile.data.username">{{comment.profile.data.first_name}} {{comment.profile.data.last_name}} <span v-html="isVerifiedUser(comment.profile.data.verified)"></span></a>
                         <small class="">{{ comment.date }}</small>
                    </h4>
                    <p v-html="comment.comment"></p>
                    <ul class="list-inline">
                        <li>
                            <a href="#" class="bold " v-on:click.prevent="submitCommentLike(comment)" v-bind:class="{ active : isLiking }"><i class="fa fa-heart"></i> <span :id="'comment-'+comment.id">{{ comment.likes }} {{ comment.likes > 1 ? 'Likes' : 'Like' }}</span></a>
                        </li>
                        <li v-if="user">
                           <a href="#" v-on:click.prevent="toggleReplyField(comment.id)" class="bold "><i class="fa fa-comments"></i> {{comment.replies.data.length}} {{comment.replies.data.length > 1 ? 'Replies' : 'Reply'}} </a>
                        </li>
                        <li v-if="user && comment.user_id === user_id">
                           <a href="#" v-on:click.prevent="deleteComment(comment)" class="bold "><i class="fa fa-close"></i> Delete</a>
                        </li>
                    </ul>
                    <div v-if="isReplyActive === comment.id">
                        <div class="form-group">
                            <textarea v-model="reply" rows="2" placeholder="Reply..." class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-default" v-on:click.prevent="submitReply(comment.id)" :disabled="isReplySubmitting">Submit Reply</button>
                            <small><a href="#" class="btn btn-basic " v-on:click.prevent="closeReply()">Close</a></small>
                        </div>
                    </div>
                    <div v-if="comment.replies.data" class="replies">
                        <div v-if="comment.replies.data.length > 0">
                            <h4 class="bold text-muted" style="font-size: 1em">{{ comment.replies.data.length }} {{ comment.replies.data.length > 1 ? 'Replies' : 'Reply'}}</h4>
                        </div>
                        <div class="media" v-for="reply in comment.replies.data">
                            <div class="media-left">
                                <a v-bind:href="'/'+reply.profile.data.username">
                                    <img :src="reply.profile.data.avatar" :alt="reply.profile.data.first_name" width="36" height="36" class="img-circle">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading bold">
                                    <a v-bind:href="'/'+reply.profile.data.username">{{reply.profile.data.first_name}} {{reply.profile.data.last_name}} <span v-html="isVerifiedUser(reply.profile.data.verified)"></span></a> <small class="">{{ reply.date }}</small>
                                </h4>
                                <p v-html="reply.comment"></p>
                                <ul class="list-inline">
                                    <li>
                                        <a href="#" class="bold " v-on:click.prevent="submitCommentLike(reply)" v-bind:class="{ active : isLiking }"><i class="fa fa-heart"></i> {{ reply.likes }} {{ reply.likes > 1 ? 'Likes' : 'Like' }}</a>
                                    </li>
                                    <li v-if="user && reply.user_id === user_id">
                                       <a href="#" v-on:click.prevent="deleteReply(reply, comment.id)" class="bold "><i class="fa fa-close"></i> Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
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
            }
        },
        props: {
            uid: null
        },
        methods: {
            getComments(){
                var _this = this;
                axios.get('/portfolio/'+this.uid+'/comments').then((response)=>{
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
        }
    }
</script>
