<template>
    <span>
        <div v-if="isSentMessage"> 
            <div class="notification is-primary">Your message was send successfully</div>
            <p>You will be redirected back in {{ timer }}</p>
        </div>
        
        <form action="#" v-on:keyup="checkFormInputs" v-on:submit.prevent="submitEnquiry" id="enquiry-form" v-if="!isSentMessage" autocomplete="off">
            <div class="field">
                <input type="text" class="input" v-model="enquiry.fullname" placeholder="Fullname">
            </div>
            <div class="field">
                <input type="email" class="input" v-model="enquiry.email" placeholder="Email address">
            </div>
            <div class="field">
                <input type="text" class="input" v-model="enquiry.phone_number" placeholder="Phone number (optional)">
            </div>
            <div class="field">
                <textarea v-model="enquiry.message" rows="3" class="textarea"></textarea>
            </div>
            <hr>
            <p>Are you human? Let's find out.</p>
            <div class="field has-addons">
                <div class="control">
                    <span class="button">{{ fig1 }} + {{ fig2 }} = </span>
                </div>
                <div class="control is-expanded">
                    <input type="number" v-model="captcha" class="input">
                </div>
            </div>
            <div class="field">
                <button type="submit" class="button is-info is-fullwidth" :disabled="!isFormOk">Send enquiry</button>
            </div>
        </form>
    </span>
</template>

<script>
    export default {
        data(){
            return {
                enquiry: {
                    fullname: '',
                    email: '',
                    message: '',
                    phone_number: '',
                },
                timer: 5,
                isFormOk: false,
                captcha: null,
                fig1: Math.floor(Math.random() * 10),
                fig2: Math.floor(Math.random() * 10),
                isSentMessage: false,
            }
        },
        props: {
            user: String,
        },
        methods: {
            checkFormInputs: function(e){
                if ( this.enquiry.fullname.length >= 3 && this.enquiry.email.length >= 3 && this.enquiry.message.length >= 3 && this.captcha !== null){
                    this.isFormOk = true;
                } else {
                    this.isFormOk = false;
                }
            },
            submitEnquiry: function(e){
                // Validate given email address
                let email_validation = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                if ( !email_validation.test(this.enquiry.email) ){
                    iziToast.error({ title: 'Invalid email address', message: 'Please provide a valid email address' });
                    return;
                }

                // Check captcha value
                let sum = this.fig1 + this.fig2;
                if ( sum !== parseInt(this.captcha) ){
                    this.fig1 = Math.floor(Math.random() * 10);
                    this.fig2 = Math.floor(Math.random() * 10);
                    iziToast.error({ title: 'Wrong captcha', message: 'Please solve the simple maths to prove you are human' });
                    return;
                }

                // Send post request
                let _this = this;
                $('body').addClass('is-loading');
                axios.post('/' + this.user + '/enquiry', this.enquiry).then( response => {
                    if ( response.data === true ){
                        _this.enquiry = {};
                        _this.isSentMessage = true;
                        $('body').removeClass('is-loading');
                        let timer = setInterval(()=>{
                            _this.timer--;
                        }, 1000);
                        setTimeout(()=>{
                            clearInterval(timer);
                            window.location.href = '/' + _this.user;
                        }, 5000)
                    } else {
                        _this.fig1 = Math.floor(Math.random() * 10);
                        _this.fig2 = Math.floor(Math.random() * 10);
                        $('body').removeClass('is-loading');
                    }
                } ).catch( e => {
                    $('body').removeClass('is-loading');
                    _this.fig1 = Math.floor(Math.random() * 10);
                    _this.fig2 = Math.floor(Math.random() * 10);
                    iziToast.error({ title: 'Error', message: 'There was an error processing your request, please try again.' });
                } );
            },
        },
        mounted() {
            // console.log(this.user);
        }
    }
</script>
