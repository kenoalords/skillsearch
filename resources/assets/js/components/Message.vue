<template>
    <div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="list-group" v-if="messages.length > 0">
                <div class="list-group-item">
                    <h4 v-if="messages.length > 0" class="text-muted">{{ messages.length }} {{ (messages.length > 1) ? 'Messages' : 'Message' }}</h4>
                </div>
                <a v-for="message in messages" class="list-group-item" v-on:click.prevent="getMessage(message)">
                    <div class="media">
                        <div class="media-left">
                            <img class="media-object img-circle" v-bind:src="getImage(message.sender.avatar)" width="32" height="32">
                        </div>
                        <div class="media-body">
                            <p class="pull-left">{{ message.subject }}</p>
                            <small class="text-muted pull-right"><em>{{ message.date }}</em></small>
                        </div>
                    </div>
                </a>
            </div>
            <div v-if="messages.length == 0" class="center-block">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4>You do not have any messages</h4>
                        <p>Please check back later</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default" id="messageViewer">
                <div class="panel-body">
                    <div v-if="messageInView">
                        <h1>{{ messageInView.subject }}</h1>
                        <p>{{ messageInView.date }}</p>
                        <hr>
                        <p>{{ messageInView.message }}</p>
                    </div>
                    <div v-if="!messageInView">
                        <div class="center-block">
                            <h3>Select message to read here</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div id="replies">
                <span>{{ status }}</span>
                <div v-if="replies.length > 0">
                    <h4 class="text-muted">{{ replies.length }} {{ (replies.length > 1) ? 'Replies' : 'Reply' }}</h4>
                    <hr>
                    <div class="panel panel-default" v-for="reply in replies">
                        <div class="panel-heading clearfix">
                            <img v-bind:src="getImage(reply.sender.avatar)" width="32" height="32" class="pull-left img-circle">
                            <span class="pull-left">{{ reply.sender.first_name }} {{ reply.sender.last_name }}</span>
                            <em class="pull-right text-muted"><small>{{ reply.date }}</small></em>
                        </div>
                        <div class="panel-body">
                            <p class="text-muted">{{ reply.message }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default" v-if="messageInView">
                <div class="panel-body">
                    <div class="form-group">
                        <textarea class="form-control" v-model="reply" placeholder="Send a reply"></textarea>
                    </div>
                    <button class="btn btn-default" v-on:click.prevent="submitReply(messageInView)">Submit Reply</button>
                </div>
            </div>

        </div>
    </div>
</div>
</template>

<script>
    export default {
        data () {
            return {
                messages : (this.messageList) ? JSON.parse( this.messageList ) : [],
                messageInView: null,
                reply: null,
                replies: [],
                status : null,
            }
        },
        props: {
            messageList: null
        },
        methods: {
            getMessage: function(message){
                this.status = 'loading replies...';
                this.replies = [];
                this.messageInView = message;
                axios.get('/message-replies/' + message.id)
                    .then( (response) => {
                        this.status = null;
                        this.replies = response.data;
                    })
                    .catch( (error) => {
                        this.status = null;
                    } )
            },
            getImage: function (image){
                return window.Laravel.url + '/' + image;
            },
            submitReply: function(currentMessage){
                var _this = this;
                var data = {
                    reply_id : currentMessage.id,
                    subject : 'RE: ' + currentMessage.subject,
                    receiver_id : currentMessage.user_id,
                    message : this.reply
                }
                axios.post('/message-reply', data)
                    .then( (response) => {
                        _this.reply = '';
                        _this.replies.push(response.data);
                    })
            }
        },
        mounted() {
            console.log(this.messageList);
        }
    }
</script>
