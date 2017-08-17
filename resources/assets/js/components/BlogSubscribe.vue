<template>
    <span id="subscribe">
        <a href="#" class="btn btn-thumbs-up" v-on:click.prevent="subscribeUser()" :class="{ 'subscribing' : isSubscribing, 'btn-success' : isSubscribed, 'btn-default' : !isSubscribed }" v-if="isReady"><i class="glyphicon" :class="{ 'glyphicon-bell' : !isSubscribed, 'glyphicon-ok-sign' : isSubscribed }"></i> {{ isSubscribed ? 'Subscribed' : 'Subscribe' }} - {{subCount}}</a>
        <span class="subscribe-form-wrapper" v-if="isActive && !isUserLoggedIn">
            <form action="#">
                <h3 class="bold">Subscribe to {{blogOwner}} Blog Posts</h3>
                <hr>
                <div class="form-group">
                    <input type="text" class="form-control" v-model="fullname" placeholder="Fullname e.g. Tosin Jegede">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" v-model="email" placeholder="Email e.g. tosin_jegede@gmail.com" v-on:focusout="checkFormFields(email)">
                </div>
                <div class="form-group">
                    <label>Are you human?</label>
                    <div class="input-group">
                        <span class="input-group-addon bold" id="captcha">
                            {{captcha.first}} + {{captcha.second}} = 
                        </span>
                        <input type="number" v-model="result" class="form-control" aria-describedby="captcha">
                    </div>
                </div>
                <div>
                    <button class="btn btn-success btn-block" type="submit" v-on:click.prevent="submitSubscriber" :disabled="isButtonDisabled">Subscribe</button>
                </div>
                <a href="#" v-on:click.prevent="closeForm()" class="close-form"><i class="fa fa-close"></i></a>
            </form>
        </span>
    </span>
</template>

<script>
    export default {
        data(){
            return {
                isUserLoggedIn : window.Laravel.userLoggedIn,
                userID : window.Laravel.user_id,
                subscribe : {},
                isActive: false,
                captcha: {
                    first: Math.floor(Math.random() * 10),
                    second: Math.floor(Math.random() * 10),
                },
                isButtonDisabled: true,
                fullname: null,
                email: null,
                result: null,
                blogOwner: this.name, 
                subCount: this.subscriberCount,
                isSubscribing: false,
                isSubscribed: false,
                isReady: false,
            }
        },
        props: {
            name: null,
            uid: null,
            subscriberCount: null,
            userId: null,
        },
        methods: {
            submitSubscriber(){
                var $this = this,
                    sum = this.captcha.first + this.captcha.second;

                if( sum !== parseInt(this.result) ){
                    alert('Your answer is incorrect. Are you sure you are human?');
                    return;
                }
                if($this.fullname === null || $this.fullname === ""){
                    alert('Please provide your fullname');
                    return;
                }
                if(!this.validateEmail($this.email)){
                    alert('Please provide a valid email address');
                    return;
                }

                var data = {
                    fullname: this.fullname,
                    email: this.email,
                };
                axios.post('/blog/subscribe/'+this.uid+'/visitor', data).then((response)=>{
                    $this.subCount = response.data.count;
                    $this.isSubscribed = true;
                    $this.closeForm();
                    var storage = window.localStorage;
                    storage.setItem($this.userId, true);
                }).catch((error)=>{

                });
            },
            subscribeUser(){
                var _this = this;
                if(this.isUserLoggedIn === true){
                    this.isSubscribing = true;
                    axios.post('/blog/subscribe/'+this.uid+'/user').then(function(response){
                        _this.isSubscribing = false;
                        _this.subCount = response.data.count;
                        if(response.data.status === 'subscribed'){
                            _this.isSubscribed = true;
                        } else if(response.data.status === 'unsubscribed'){
                            _this.isSubscribed = false;
                        }
                    }).catch(function(error){
                        _this.isSubscribing = false;
                        alert('Oops! something went wrong!');
                    })
                } else {
                    this.isActive = true;
                }
            },
            checkFormFields(email){
                if(this.validateEmail(email)){
                    this.isButtonDisabled = false;
                } else {
                    this.isButtonDisabled = true;
                }
            },
            closeForm(){
                this.fullname = null;
                this.email = null;
                this.result = null;
                this.isActive = false;
                this.captcha.first = Math.floor(Math.random() * 10);
                this.captcha.second = Math.floor(Math.random() * 10);
            },
            checkSubscription(){
                var _this = this;
                if(this.isUserLoggedIn === true){
                    axios.post('/blog/subscribe/'+this.uid+'/check').then((response)=>{
                        _this.isSubscribed = response.data;
                        _this.isReady = true;
                    }).catch((error)=>{

                    });
                } else {
                    var storage = window.localStorage,
                        check = storage.getItem(this.userId);
                    if(check && check === 'true'){
                        this.isSubscribed = true;
                    }
                    this.isReady = true;
                }
            },
            validateEmail(email) {
                var filter = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if (!filter.test(email)) {
                    return false;
                } else {
                    return true;
                }
            }
        },
        mounted() {
            this.checkSubscription();
        }
    }
</script>
