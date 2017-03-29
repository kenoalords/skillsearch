<template>
    <div>
        <div class="panel panel-default" v-if="users" v-for="user in users">
            <div class="panel-body">
                <p><img :src="getImage(user.scan_link)" class="img-responsive" style="width:100%"></p>
                <hr>
                <h4>{{user.user_profile.first_name}} {{user.user_profile.last_name}}</h4>
                <p>
                    <button class="btn btn-primary" v-on:click.prevent="verifyUser(user)" :disabled="isVerifying">Verify request</button>
                    <button class="btn btn-danger" v-on:click.prevent="isCancel = true" :disabled="isCancel">Cancel request</button>
                </p>

                <div v-if="isCancel" class="white-boxed small thin">
                    <label class="checkbox">
                        <input type="radio" v-model="message" value="You identity card is not clear enough. Please upload a clearer picture"> You identity card is not clear enough. Please upload a clearer picture
                    </label>
                    <label class="checkbox">
                        <input type="radio" v-model="message" value="Kindly upload a Government issued Identity Card."> Kindly upload a Government issued Identity Card.
                    </label>
                    <label class="checkbox">
                        <input type="radio" v-model="message" value="We could not verify your identity using the uploaded file. Please upload another file"> We could not verify your identity using the uploaded file. Please upload another file
                    </label>
                    <p>
                        <button class="btn btn-primary" v-on:click.prevent="cancelMessage(user)">Send Message</button>
                        <button class="btn btn-default" v-on:click.prevent="isCancel = false">Cancel</button>
                    </p>
                </div>
            </div>
        </div>

        <div v-if="loaded && users.length == 0">
            <h3 class="text-center">No user verification request</h3>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                users: null,
                loaded: false,
                message: null,
                isCancel: false,
                isVerifying: false,
            }
        },

        methods: {
            getVerificationRequests(){
                var _this = this;
                axios.get('/home/users').then((response)=>{
                    _this.loaded = true;
                    _this.users = response.data;
                    // console.log(response);
                })
            },
            getImage(image){
                return window.skillsearch.s3images + '/' + image;
            },

            verifyUser(user){
                var data = {
                    user_id : user.user_id,
                    id : user.id,
                };
                this.isVerifying = true;
                var _this = this;
                axios.post('/home/users/ok', data).then((response)=>{
                    _this.users.splice(_this.users.indexOf(user), 1);
                }).catch((error)=>{
                    _this.isVerifying = false;
                });
            },

            cancelMessage(user){
                var data = {
                    user_id : user.user_id,
                    message : this.message,
                    id : user.id,
                };
                var _this = this;
                axios.post('/home/users/cancel', data).then((response)=>{
                    _this.users.splice(_this.users.indexOf(user), 1);
                });
            }
        },

        mounted() {
            this.getVerificationRequests();
        }
    }
</script>
