<template>
    <div>
        <div v-if="user">
            <div class="ui unstackable items">
                <div class="item">
                    <div class="ui mini image">
                        <img :src="userImage" alt="Avatar" class="avatar">
                    </div>
                    <div class="content">
                        <div class="ui form">
                            <div class="field">
                                <textarea v-model="comment" class="form-control" rows="2" placeholder="Leave your comment here..."></textarea>
                            </div>
                            <button class="ui primary button" v-on:click.prevent="submitComment()" :disabled="isSubmitting" :class="{'loading': isSubmitting}">Comment</button>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="comments"  id="comments">
            <h4 class="ui medium header">{{comments.length}} {{comments.length > 1 ? 'Comments' : 'Comment'}}</h4>
            <div class="ui comments">
                <div class="comment" :class="{'new' : newComment}" v-for="comment in comments">
                    <div class="avatar">
                        <a :href="'/'+comment.profile.data.username">
                            <img :src="comment.profile.data.avatar" :alt="comment.profile.data.first_name">
                        </a>
                    </div>
                    <div class="content">
                        <a v-bind:href="'/'+comment.profile.data.username" class="author">{{comment.profile.data.first_name}} {{comment.profile.data.last_name}} <span v-html="isVerifiedUser(comment.profile.data.verified)"></span></a>
                        <div class="metadata">
                            <div class="date">{{ comment.date }}</div>
                        </div>
                        <p v-html="comment.comment" class="text"></p>
                        <div class="actions">
                            <a href="#" class="bold" v-on:click.prevent="submitCommentLike(comment)" v-bind:class="{ active : isLiking }"><i class="fa fa-heart"></i> <span :id="'comment-'+comment.id">{{ comment.likes }}</span></a>
                            <a href="#" v-on:click.prevent="toggleReplyField(comment.id)" class="bold" v-if="user"><i class="fa fa-reply"></i> Reply</a>
                            <a href="#" v-on:click.prevent="deleteComment(comment)" class="bold " v-if="user && comment.user_id === user_id"><i class="fa fa-close"></i> Delete</a>
                        </div>
                        <div v-if="isReplyActive === comment.id" class="ui unstackable items">
                            <div class="item">
                                <div class="ui mini image">
                                    <img :src="userImage" alt="Avatar" class="avatar">
                                </div>
                                <div class="content">
                                    <div class="ui form">
                                        <div class="field">
                                            <textarea v-model="reply" rows="1" placeholder="Reply..." class="form-control"></textarea>
                                        </div>
                                        <div class="">
                                            <button class="ui primary mini button" v-on:click.prevent="submitReply(comment.id)" :disabled="isReplySubmitting">Reply</button>
                                            <small><a href="#" class="ui mini icon button" v-on:click.prevent="closeReply()"><i class="icon close"></i></a></small>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="comment.replies.data" class="ui comments">
                            <div v-if="comment.replies.data.length > 0">
                                <h4 class="bold" style="font-size: 1em">{{ comment.replies.data.length }} {{ comment.replies.data.length > 1 ? 'Replies' : 'Reply'}}</h4>
                            </div>
                            <div class="comment" v-for="reply in comment.replies.data">
                                <div class="avatar">
                                    <a v-bind:href="'/'+reply.profile.data.username">
                                        <img :src="reply.profile.data.avatar" :alt="reply.profile.data.first_name">
                                    </a>
                                </div>
                                <div class="content">
                                    <a v-bind:href="'/'+reply.profile.data.username" class="author">{{reply.profile.data.first_name}} {{reply.profile.data.last_name}} <span v-html="isVerifiedUser(reply.profile.data.verified)"></span></a>

                                    <div class="metadata">
                                        <div class="date">{{ reply.date }}</div>
                                    </div>
                                    <p v-html="reply.comment" class="text"></p>
                                    <div class="actions">
                                        <a href="#" class="bold" v-on:click.prevent="submitCommentLike(reply)" v-bind:class="{ active : isLiking }"><i class="fa fa-heart"></i> {{ reply.likes }}</a>
                                        <a href="#" v-on:click.prevent="deleteReply(reply, comment.id)" class="bold " v-if="user && reply.user_id === user_id"><i class="fa fa-close"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                    // _this.comments.unshift(response.data.data);
                    
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
            // Echo.channel('portfolio.'+this.uid).listen('CommentPostedEvent', (e)=>{
            //     // console.log(e);
            //     this.comments.unshift(e.comment.data);

            // });
        }
    }
</script>
