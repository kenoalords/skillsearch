<template>
    
    <div class="ui padded grid">
        <div class="four wide column" id="message-list">
            <div class="ui relaxed middle aligned selection list" v-if="serviceRequests.length > 0">
                <div class="request-list item" v-for="serviceRequest in serviceRequests" :id="'request-'+serviceRequest.id" v-on:click.prevent="loadRequest(serviceRequest)">
                    <!-- <a href="#" v-on:click.prevent="loadRequest(serviceRequest)"> -->
                    <img v-bind:src="serviceRequest.sender_profile.avatar" alt="" width="24" height="24" class="ui avatar image">
                    <div class="content">
                        <h4 class="header">{{ serviceRequest.sender_profile.fullname }}</h4>
                        <small class="description">{{ serviceRequest.date }}</small>
                    </div>
                    <!-- </a> -->
                    <div :id="'response-'+serviceRequest.id" class="service-response"></div>
                </div>
            </div>
            <div v-else-if="!reading && serviceRequests.length == 0">
                <div class="ui header">You have no messages.</div>
            </div>
        </div>
        <div class="twelve wide column" id="message-reader">
            <div v-if="reading" class="reading-block ui padded grid">
                <div  id="responses" class="row">
                    <div class="column">
                        <h3 class="ui header">
                            {{reading.subject}}
                            <div class="sub header"> Interested in <strong>{{ reading.skills }}</strong> {{reading.date}}</div>
                        </h3>
                        <p>{{ reading.body }}</p>
                        <div v-if="responses.length > 0" class="ui comments">
                            <h5 class="ui dividing header">{{responses.length}} {{responses.length > 1 ? 'Responses' : 'Response'}}</h5>
                            <div class="comment" v-for="response in responses">
                                <div class="avatar">
                                    <img :src="response.profile.avatar" class="" width="24" height="24">
                                </div>
                                <div class="content">
                                    <h5 class="author" style="margin-bottom:0">
                                        {{response.profile.first_name}} {{response.profile.last_name}} 
                                    </h5>
                                    <div class="metadata">{{response.date}}</div>
                                    <div class="text">{{ response.response }}</div>
                                </div>
                            </div>
                        </div>
                        <div v-else-if="responses.length == 0">
                            <h5 class="ui red header">No Response Yet</h5>
                        </div>
                    </div>
                </div>
                <div class="reply-form-wrapper ui form row">
                    <div class="column" style="margin: 0 -1em">
                        <div class="field">
                            <div class="ui action input">
                                <input type="text" v-model="body" rows="1" placeholder="Reply" v-on:keyup="checkCharLength()">
                                <button class="ui primary button" v-on:click.prevent="submitResponse(reading)" :disabled="isTyping">Reply</button>
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
            return {
                serviceRequests : JSON.parse(this.requests),
                userId : window.Laravel.user_id,
                reading : null,
                responses : [],
                body : null,
                isLoadingResponse : false,
                isTyping: true,
            } 
        },

        methods: {
            getAvatar(image){
                return window.skillsearch.s3images + '/' + image;
            },

            loadRequest(request){
                this.loadResponses(request);
                this.reading = request;
            },

            loadResponses(request){
                var _this = this,
                    _request = request;
                _this.responses = [];
                axios.get('/profile/response/' + request.id).then( (response) => {
                    $('#responses').scrollTop($('#responses').scrollHeight);
                    _this.isLoadingResponse = true;
                    _this.responses = response.data;
                });
            },

            submitResponse(request){
                var _this = this,
                    data = {
                        response : _this.body
                    }
                axios.post('/profile/response/' + request.id, data).then( (response) => {
                    $('#responses').scrollTop($('#responses').scrollHeight);
                    _this.body = null;
                    _this.responses.push(response.data);
                });
            },

            checkCharLength(){
                if(this.body.length > 2){
                    this.isTyping = false;
                } else {
                    this.isTyping = true;
                }
            }
            
        },

        props: {
            requests : null
        },

        mounted() {
            
        }
    }
</script>
