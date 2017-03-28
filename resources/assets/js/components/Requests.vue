<template>

    <div class="row" v-if="serviceRequests.length > 0">
        <div class="col-md-4">
            <div class="list-group">
                <a v-on:click.prevent="loadRequest(serviceRequest)" class="list-group-item" v-for="serviceRequest in serviceRequests">
                    <div class="media">
                        <div class="media-left media-middle">
                            <!-- <a href="#" v-if="serviceRequest.user_id === userId">
                                <img v-bind:src="serviceRequest.receiver_profile.avatar" alt="" width="40" height="40" class="img-circle">
                            </a>
                            <a href="#" v-else-if="serviceRequest.user_id !== userId">
                                <img v-bind:src="serviceRequest.sender_profile.avatar" alt="" width="40" height="40" class="img-circle">
                            </a> -->
                            <img v-bind:src="serviceRequest.sender_profile.avatar" alt="" width="24" height="24" class="img-circle">
                        </div>
                        <div class="media-body media-middle">
                            <!-- <small>{{serviceRequest.receiver_profile.first_name}} {{serviceRequest.receiver_profile.last_name}}</small>  -->
                            <h5 class="media-heading pull-left">{{ serviceRequest.subject }}</h5>
                            <small class="pull-right"><em class="text-muted">{{ serviceRequest.date }}</em></small> 
                            <!-- - <small class="text-muted"><em>{{ serviceRequest.skills }}</em></small> -->
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-8">
            
            <div v-if="reading">
                <small>{{reading.date}}</small>
                <h3>{{reading.subject}}</h3>
                <h5>Services Requested: {{ reading.skills }}</h5>
                <hr>
                <p>{{ reading.body }}</p>

                <div v-if="isLoadingResponse" id="response-wrapper">
                    <div v-if="responses.length > 0">                                
                        <h5 class="text-warning">{{responses.length}} {{responses.length > 1 ? 'Responses' : 'Response'}}</h5>
                        <hr>
                        <div class="media" v-for="response in responses">
                            <div class="media-left">
                                <img :src="response.profile.avatar" class="media-object img-circle" width="50" height="50">
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
                        <h5 class="text-warning">No Response Yet</h5>
                        <hr>
                    </div>
                </div>

                <div class="form-group">
                    <textarea class="form-control" v-model="body" rows="3" placeholder="Reply"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-default" v-on:click.prevent="submitResponse(reading)">Send Reply</button>
                </div>
            </div>

            <div v-else-if="!reading && serviceRequests.length > 0">
                <div class="padded text-center">
                    <p style="font-size:3em"><i class="glyphicon glyphicon-hand-left"></i></p>
                    <p>Select a request to view</p>
                </div>
            </div>
            
            <div v-else-if="!reading && serviceRequests.length == 0">
                <div class="padded text-center">
                    <p style="font-size:3em"><i class="glyphicon glyphicon-thumbs-down"></i></p>
                    <p>You have not received any service request yet</p>
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
            } 
        },

        methods: {
            getAvatar(image){
                return window.skillsearch.s3images + '/' + image;
            },

            loadRequest(request){
                this.reading = request;
                this.loadResponses(request);
            },

            loadResponses(request){
                var _this = this;
                _this.responses = [];
                axios.get('/profile/response/' + request.id).then( (response) => {
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
                    _this.body = null;
                    _this.responses.push(response.data);
                });
            },

            
        },

        props: {
            requests : null
        },

        mounted() {
            console.log(this.serviceRequests);
        }
    }
</script>
