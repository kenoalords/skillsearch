<template>
    <span>
        <div class="modal bold" :class="{ 'is-active' : isActive }">
            <div class="modal-background"></div>
            <div class="modal-content has-text-centered">
                <div class="card">
                    <div class="card-content">
                        <div v-if="!isSuccessful">
                            <span class="is-size-1">😎</span>
                            <h1 class="title is-3 is-size-5-mobile">Get our weekly free tips on how to grow your business</h1>
                            <p class="">Enter your email address below</p>
                            <form action="">
                                <div class="field">
                                    <input type="email" class="input" v-model="email" placeholder="Email address">
                                </div>
                                <div class="field">
                                    <button @click.prevent="subscribeUser" class="button is-primary big-action-button is-fullwidth" :class="{ 'is-loading' : isLoading }" :disabled="email.length < 3">I want free tips</button>
                                </div>
                            </form>
                            <span v-if="error.length > 0">{{ error }}</span>
                        </div>
                        <div v-if="isSuccessful">
                            <span class="is-size-1">👍🏽</span>
                            <h2 class="title is-5">Thank you for subscribing</h2>
                            <a @click.prevent="isActive = false" class="button is-light is-small">
                                <span class="icon"><i class="fa fa-times"></i></span> <span>close</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <button class="modal-close is-large" aria-label="close" @click.prevent="isActive = false"></button>
        </div>
    </span>
</template>

<script>
    export default {
        data(){
            return {
                email: '',
                isLoading: false,
                isFilled: false,
                isActive: false,
                error: '',
                isSuccessful: false,
            }
        },
        methods: {
            subscribeUser: function(){
                this.isLoading = true;
                var _this = this,
                    data = {
                        email: this.email,
                    }
                axios.post('/email-subscription', data).then( (response) => {
                    _this.isLoading = false;
                    localStorage.setItem('subscription', true);
                    _this.isSuccessful = true;
                }).catch( (error) => {
                    _this.isLoading = false;
                    _this.error = 'There was a problem signing you up, please try again';
                    console.log(error)
                });
            }
        },
        mounted() {
            setTimeout(()=>{
                if ( localStorage.getItem('subscription') !== 'true' ){
                    this.isActive = true;
                }
            }, 10000)            
        }
    }
</script>
