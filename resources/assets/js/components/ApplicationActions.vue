<template>
    <div>
        <div class="ui horizontal list">
            <div v-if="isResponseActive === null || !isAccepting" class="item"><a href="#" v-on:click.prevent="showMessageForm(currentApplication)" class="btn btn-default btn-xs"><i class="fa fa-comments"></i> Reply</a></div>
            <div v-if="isResponseActive != null" class="item"><a href="#" v-on:click.prevent="closeReply()" class="text-muted btn btn-default btn-xs"><i class="fa fa-close"></i> Close</a></div>
            <div v-if="isOwner" class="item"><a href="#" v-on:click.prevent="acceptApplication(currentApplication)" class="btn btn-default btn-xs" v-if="!isAccepting"><i class="fa fa-check-circle"></i> Accept</a></div>
        </div>
        <div class="ui form" v-if="isAccepting">
            <div class="field">
                <h4 class="text-success bold">Accept {{currentApplication.profile.fullname}}'s Application</h4>
                <label for="">Please provide some contact information to get the ball rolling</label>
                <textarea v-model="message" class="form-control" rows="2" placeholder="e.g Your Phone Number or Email address" v-on:keyup="checkAcceptanceMessage()"></textarea>
            </div>
            <div class="field">
                <button class="ui green button" v-on:click.prevent="submitAcceptance(currentApplication)" :disabled="hasAcceptanceMessage"><i class="fa fa-check-circle"></i> Accept</button>
                <button class="ui button" v-on:click.prevent="cancelAcceptance()"><i class="fa fa-close"></i> Cancel</button>
            </div>
        </div>
        <div class="responses">
            <div v-if="currentApplication.responses.length > 0" class="ui comments thread">
                <div class="comment" v-for="response in currentApplication.responses">
                    <div class="avatar">
                        <img :src="response.profile.avatar" :alt="response.profile.fullname" class="media-object img-circle" width="32" height="32">
                    </div>
                    <div class="content" :class="{ 'is-owner' :  currentApplication.user_id === response.user_id}">
                        <span class="author">{{response.profile.fullname}}</span>
                        <div class="metadata">{{response.date}}</div>
                        <p v-html="response.response" class="text"></p>
                    </div>
                </div>
            </div>
            <form action="#" v-if="isResponseActive === currentApplication.id" class="ui form">
                <div class="field">
                    <textarea v-model="response.message" id="" class="form-control" rows="2" placeholder="Your reply here..."></textarea>
                </div>
                <div class="field">
                    <button class="ui primary mini button" v-on:click.prevent="submitResponse(currentApplication)" :disabled="isSending">Submit</button>
                    <span v-if="isResponseActive != null"><a href="#" v-on:click.prevent="closeReply()" class="ui mini button"><i class="fa fa-close"></i> Close</a></span>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                response: {},
                isResponseActive: null,
                currentApplication: JSON.parse(this.application),
                isSending: false,
                url: window.Laravel.url + '/profile/jobs/application/response',
                acceptUrl: window.Laravel.url + '/profile/jobs/application/accept',
                isOwner: false,
                isAccepting: false,
                hasAcceptanceMessage: true,
                message: null,
            }
        },

        props: {
            application: null,
        },

        methods: {
            showMessageForm(currentApplication){
                this.isResponseActive =  currentApplication.id;
            },

            closeReply(){
                this.isResponseActive = null;
                this.isAccepting = false;
            },

            submitResponse(currentApplication){
                var data = {
                        application_id: currentApplication.id,
                        user_id: currentApplication.user_id,
                        task_id: currentApplication.task_id,
                        response: this.response.message
                    },
                    _this = this;
                _this.isSending = true;
                axios.post(_this.url, data).then((response)=>{
                    _this.isSending = false;
                    _this.response = {};
                    _this.isResponseActive = null;
                    currentApplication.responses.push(response.data);
                }).catch((error)=>{

                });
            },

            acceptApplication(currentApplication){
                this.isAccepting = true;
            },

            cancelAcceptance(){
                this.isAccepting = false;
                this.isResponseActive = null;
            },

            submitAcceptance(currentApplication){
                var _this = this;
                _this.hasAcceptanceMessage = true;
                currentApplication.message = _this.message;
                // console.log(_this.currentApplication);
                if(window.confirm('Are you sure you want to accept this application?')){
                    axios.post(_this.acceptUrl, currentApplication).then( (response)=>{
                        _this.hasAcceptanceMessage = false;
                        window.location.reload(true);
                    } )
                }
            },

            checkAcceptanceMessage(){
                if(this.message.length > 3){
                    this.hasAcceptanceMessage = false;
                } else {
                    this.hasAcceptanceMessage = true;
                }
            }
        },
        mounted() {
            // console.log('Component mounted.')
            this.isOwner = (window.Laravel.user_id === this.currentApplication.task[0].user_id) ? true : false;
        }
    }
</script>
