<template>
    
    <div>
        <div class="row" v-if="serviceRequests.length > 0" id="service-request">
            <div class="service">
                <div class="list-group">
                    <div class="list-group-item request-list" v-for="serviceRequest in serviceRequests" :id="'request-'+serviceRequest.id">
                        <div class="media">
                            <a href="#" v-on:click.prevent="loadRequest(serviceRequest)">
                            <div class="media-left">
                                <img v-bind:src="serviceRequest.sender_profile.avatar" alt="" width="48" height="48" class="img-circle">
                            </div>
                            <div class="media-body">
                                <div class="media-heading clearfix">
                                    <h4>{{ serviceRequest.subject }}</h4>
                                    <small class="text-muted bold">{{ serviceRequest.date }}</small> 
                                    <!-- <br><small class="text-muted"><em>{{ serviceRequest.skills }}</em></small> -->
                                </div>
                                
                            </div>
                            </a>
                        </div>
                        <div :id="'response-'+serviceRequest.id" class="service-response"></div>
                    </div>

                    <div v-if="reading" class="reading-block">
                        <!-- <small>{{reading.date}}</small> -->
                        <!-- <h3>{{reading.subject}}</h3> -->
                        <div class="content">
                            <p>{{ reading.body }}</p>
                            <p class="text-muted"><em>Interested in <strong>{{ reading.skills }}</strong></em></p>
                        </div>
    
                        <div v-if="isLoadingResponse" class="response-wrapper">
                            <div v-if="responses.length > 0" class="responses">                                
                                <h5 class="text-warning bold">{{responses.length}} {{responses.length > 1 ? 'Responses' : 'Response'}}</h5>
                                <hr>
                                <div class="media" v-for="response in responses">
                                    <div class="media-left">
                                        <img :src="response.profile.avatar" class="media-object img-circle" width="24" height="24">
                                    </div>
                                    <div class="media-body">
                                        <h5 class="media-heading">
                                            {{response.profile.first_name}} {{response.profile.last_name}} 
                                            <small class="text-muted"><em>{{response.date}}</em></small>
                                        </h5>
                                        <p>{{ response.response }}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-else-if="responses.length == 0">
                                <h5 class="text-warning bold">No Response Yet</h5>
                                <hr>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" v-model="body" rows="3" placeholder="Reply" v-on:keyup="checkCharLength()"></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" v-on:click.prevent="submitResponse(reading)" :disabled="isTyping">Send Reply</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-else-if="!reading && serviceRequests.length == 0">
            <div class="padded text-center">
                <p style="font-size:3em"><i class="glyphicon glyphicon-thumbs-down"></i></p>
                <p>You have not received any service request yet</p>
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
                
                $('.reading-block').slideUp('fast');
                $('.request-list').removeClass('reading');
                $('#request-'+request.id).addClass('reading');
                this.loadResponses(request);
                this.reading = request;
            },

            loadResponses(request){
                var _this = this,
                    _request = request;
                _this.responses = [];
                axios.get('/profile/response/' + request.id).then( (response) => {
                    _this.isLoadingResponse = true;
                    _this.responses = response.data;
                    $('#response-' + _request.id).append($('.reading-block'));
                    $('.reading-block').slideDown('fast');
                });
            },

            submitResponse(request){
                var _this = this,
                    data = {
                        response : _this.body
                    }
                axios.post('/profile/response/' + request.id, data).then( (response) => {
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
