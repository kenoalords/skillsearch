<template>
    <span>
    <div class="level is-mobile">
        <div class="level-left">
            <a v-if="isResponseActive === null || !isAccepting" href="#" v-on:click.prevent="showMessageForm(currentApplication)" class="level-item button is-primary is-small">
                <span class="icon"><i class="fa fa-comments"></i></span> 
                <span>Reply</span>
            </a>
            <a v-if="isResponseActive != null" href="#" v-on:click.prevent="closeReply()" class="level-item button is-small is-primary">
                <span class="icon"><i class="fa fa-close"></i></span> <span>Close</span>
            </a>
            <div class="level-item" v-if="isOwner">
                <span v-if="!isAccepting" class="level-item button is-small is-primary"><a href="#" v-on:click.prevent="acceptApplication(currentApplication)" >
                    <span class="icon"><i class="fa fa-check-circle"></i></span> 
                    <span>Accept</span>
                </a></span>
            </div>
        </div>
    </div>
    <div>
        <div class="card is-raised" v-if="isAccepting">
            <div class="field">
                <h4 class="title is-5">Accept {{currentApplication.profile.fullname}}'s Application</h4>
                <label class="label">Please provide some contact information to get the ball rolling</label>
                <textarea v-model="message" class="textarea" rows="2" placeholder="e.g Your Phone Number or Email address" v-on:keyup="checkAcceptanceMessage()"></textarea>
            </div>
            <div class="field">
                <button class="button is-primary is-small" v-on:click.prevent="submitAcceptance(currentApplication)" :disabled="hasAcceptanceMessage"><i class="fa fa-check-circle"></i> Accept</button>
                <button class="button is-small" v-on:click.prevent="cancelAcceptance()"><i class="fa fa-close"></i> Cancel</button>
            </div>
        </div>
        <div class="responses">
            <div v-if="currentApplication.responses.length > 0">
                <a href="#" @click.prevent="showResponses">
                    <span class="icon"><i class="fa" :class="{'fa-minus' : showResponsesFlag, 'fa-plus' : !showResponsesFlag}"></i></span> <span>{{ (showResponsesFlag) ? 'Hide' : 'Show' }} conversation</span>
                </a>
            </div>
            <div v-if="currentApplication.responses.length > 0" v-show="showResponsesFlag">
                <div class="media" v-for="response in currentApplication.responses">
                    <div class="media-left">
                        <img :src="response.profile.avatar" :alt="response.profile.fullname" class="image is-48x48 is-rounded">
                    </div>
                    <div class="media-content" :class="{ 'is-owner' :  currentApplication.user_id === response.user_id}">
                        <div class="content">
                            <span class="has-text-weight-bold">{{response.profile.fullname}}</span> <small>{{response.date}}</small>
                            <br>
                            <p v-html="response.response" class="text"></p>
                        </div>
                    </div>
                </div>
            </div>
            <form action="#" v-if="isResponseActive === currentApplication.id" class="ui form">
                <div class="field">
                    <textarea v-model="response.message" id="" class="textarea" rows="2" placeholder="Your reply here..."></textarea>
                </div>
                <div class="field">
                    <button class="button is-primary is-small" v-on:click.prevent="submitResponse(currentApplication)" :disabled="isSending">Submit</button>
                    <span v-if="isResponseActive != null"><a href="#" v-on:click.prevent="closeReply()" class="button is-small"><i class="fa fa-close"></i> Close</a></span>
                </div>
            </form>
        </div>
    </div>
    </span>
</template>

<script>
    export default {
        data(){
            return {
                response: {},
                isResponseActive: null,
                currentApplication: JSON.parse(this.application),
                isSending: false,
                url: window.Laravel.url + '/dashboard/jobs/application/response',
                acceptUrl: window.Laravel.url + '/dashboard/jobs/application/accept',
                isOwner: false,
                isAccepting: false,
                hasAcceptanceMessage: true,
                message: null,
                showResponsesFlag: false,
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
            showResponses(){
                return ( this.showResponsesFlag == false ) ? this.showResponsesFlag = true : this.showResponsesFlag = false;
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
