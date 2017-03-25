<template>
    <div>
        <div v-if="user">
            <div class="form-group">
                <textarea v-model="comment" class="form-control" rows="3" placeholder="Share a comment..."></textarea>
            </div>
            <button class="btn btn-default" v-on:click.prevent="submitComment()" :disabled="isSubmitting">{{isSubmitting ? 'Submitting...' : 'Submit comment'}}</button>
        </div>
        <div v-if="comments"  id="comments">
            <h4 class="bold">{{comments.length}} {{comments.length > 1 ? 'Comments' : 'Comment'}}</h4>
            <hr>
            <div class="media" v-for="comment in comments">
                <div class="media-left">
                    <a :href="'/'+comment.profile.data.username">
                        <img :src="comment.profile.data.avatar" :alt="comment.profile.data.first_name" width="50" height="50" class="thumbnail">
                    </a>
                </div>
                <div class="media-body">
                    <h5 class="media-heading bold">
                        <a v-bind:href="'/'+comment.profile.data.username">{{comment.profile.data.first_name}} {{comment.profile.data.last_name}}</a>
                         <small class="text-muted"><em>{{ comment.date }}</em></small>
                    </h5>
                    
                    <p v-html="comment.comment"></p>
                    <ul class="list-inline">
                        <li v-if="user">
                           <small><a href="#" v-on:click.prevent="toggleReplyField(comment.id)" class="bold">Reply</a></small>
                        </li>
                    </ul>
                    <div v-if="isReplyActive === comment.id">
                        <div class="form-group">
                            <textarea v-model="reply" rows="2" placeholder="Reply..." class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-default" v-on:click.prevent="submitReply(comment.id)" :disabled="isReplySubmitting">Submit Reply</button>
                            <a href="#" class="btn btn-basic text-muted" v-on:click.prevent="closeReply()">Close</a>
                        </div>
                    </div>
                    <div v-if="comment.replies.data">
                        <div v-if="comment.replies.data.length > 0">
                            <hr>
                        </div>
                        <div class="media" v-for="reply in comment.replies.data">
                            <div class="media-left">
                                <a v-bind:href="'/'+reply.profile.data.username">
                                    <img  :src="reply.profile.data.avatar" :alt="reply.profile.data.first_name" width="50" height="50" class="thumbnail">
                                </a>
                            </div>
                            <div class="media-body">
                                <h5 class="media-heading bold">
                                    <a v-bind:href="'/'+reply.profile.data.username">{{reply.profile.data.first_name}} {{reply.profile.data.last_name}}</a> 
                                    <small class="text-muted"><em>{{ reply.date }}</em></small>
                                </h5>
                                <p v-html="reply.comment"></p>
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
                isSubmitting: false,
                isReplyActive: null,
                isReplySubmitting: false,
                reply: null,
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
            }
        },
        mounted() {
            this.getComments();
        }
    }
</script>
