<template>
    <span id="subscribe">
        <a href="#" class="button" v-on:click.prevent="subscribeUser()" :class="{ 'is-loading' : isSubscribing, 'is-info' : isSubscribed, 'is-ux-action' : !isSubscribed }" v-if="isReady"><span class="icon"><i class="fa fa-bell"></i></span> <span>{{ isSubscribed ? 'Subscribed' : 'Subscribe' }} <span style="opacity: 0.7">{{subCount}}</span></span></a>
        <div class="subcription modal" :class="{ 'is-active' : isActive }">
            <div class="modal-background"></div>
            <div class="modal-content" v-if="isActive && !isUserLoggedIn">
                <form action="#" class="box">
                    <h3 class="title is-4">Subscribe to email notification.</h3>
                    <p>We will send you an email each time {{ blogOwner }} publishes a new post.</p>
                    <div class="field">
                        <input type="text" class="input" v-model="fullname" placeholder="Fullname e.g. Tosin Jegede">
                    </div>
                    <div class="field">
                        <input type="email" class="input" v-model="email" placeholder="Email e.g. tosin_jegede@gmail.com" v-on:focusout="checkFormFields(email)">
                    </div>
                    <label>Are you human?</label>
                    <div class="field has-addons">
                        <div class="control">
                            <span class="button is-static">{{captcha.first}} + {{captcha.second}} = </span>
                        </div>
                        <div class="control is-expanded">
                            <input type="number" v-model="result" class="input" aria-describedby="captcha">
                        </div>
                    </div>
                    <div>
                        <button class="button is-ux-action is-fullwidth" type="submit" v-on:click.prevent="submitSubscriber" :disabled="isButtonDisabled">Subscribe</button>
                    </div>
                </form>
            </div>
            <button class="modal-close is-large" aria-label="close" v-on:click.prevent="closeForm()"></button>
        </div>
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
            name: String,
            uid: Number,
            subscriberCount: Number,
            userId: Number,
            blogTitle: String,
        },
        methods: {
            submitSubscriber(){
                var $this = this,
                    sum = this.captcha.first + this.captcha.second;
                $('body').addClass('is-loading');
                if( sum !== parseInt(this.result) ){
                    $('body').removeClass('is-loading');
                    alert('Your answer is incorrect. Are you sure you are human?');
                    return;
                }
                if($this.fullname === null || $this.fullname === ""){
                    $('body').removeClass('is-loading');
                    alert('Please provide your fullname');
                    return;
                }
                if(!this.validateEmail($this.email)){
                    $('body').removeClass('is-loading');
                    alert('Please provide a valid email address');
                    return;
                }

                var data = {
                    fullname:   this.fullname,
                    email:      this.email,
                    blog_id:    this.uid,
                    blog_url:   window.location.href,
                    blog_title: this.blogTitle,
                };
                axios.post('/blog/subscribe/'+this.uid+'/visitor', data).then((response)=>{
                    $this.subCount = response.data.count;
                    $this.isSubscribed = true;
                    $this.closeForm();
                    var storage = window.localStorage;
                    storage.setItem($this.userId, true);
                    $('body').removeClass('is-loading');
                }).catch((error)=>{
                    $('body').removeClass('is-loading');
                });
            },
            subscribeUser(){
                var _this = this;
                if(this.isUserLoggedIn === true){
                    this.isSubscribing = true;
                    var data = {
                        blog_id:    this.uid,
                        blog_url:   window.location.href,
                        blog_title: this.blogTitle,
                    };
                    axios.post('/dashboard/blog/subscribe/'+this.uid+'/subscribe-user', data).then(function(response){
                        _this.isSubscribing = false;
                        _this.subCount = response.data.count;

                        if(response.data.status === 'subscribed'){
                            _this.isSubscribed = true;
                        } else if(response.data.status === 'unsubscribed'){
                            _this.isSubscribed = false;
                        } else if( response.data.status === 'owner' ){
                            _this.isSubscribed = false;
                            iziToast.error({ title: 'You cant subscribe to your own blog' });
                        }
                    }).catch(function(error){
                        _this.isSubscribing = false;
                        iziToast.error({ title: 'Something went wrong', message: 'please try again later' });
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
                    axios.post('/dashboard/blog/subscribe/'+this.uid+'/check').then((response)=>{
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
