<template>
    <div id="service-request" class="ui left aligned column">
        <div class="alert alert-success" role="alert" v-if="status" v-html="status"></div>
        <div class="alert alert-danger" role="alert" v-if="formErrors" v-for="error in formErrors">
            {{error[0]}}
        </div>
        <h2 class="ui top attached header">
            <img :src="avatar" class="ui medium circular image"> Contact {{firstName}}
        </h2>
        <div class="white-boxed">
            <div class="ui form">
                <div class="field">
                    <input type="text" v-model="subject" class="form-control" placeholder="Subject">
                </div>

                <div class="field">
                    <textarea v-model="body" class="form-control" placeholder="Make your request" rows="3"></textarea>
                </div>

                <p>Select the service you will like to inquire about? <span class="text-muted"></span></p>
                <div class="field" v-if="userServices" v-for="service in userServices">
                    <div class="ui checkbox">
                        <input type="checkbox" v-bind:value="service.skill" v-model="services" class="hidden">
                        <label>{{ service.skill }}</label>
                    </div>
                </div>

                <div class="">
                    <button id="submitRequest" class="ui primary button" v-on:click.prevent="submitRequest" :disabled="isSubmitting">Send Message</button>
                    <a :href="'/' + username" class="">Back to profile</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                userServices: JSON.parse(this.skills),
                subject: null,
                body: null,
                services: [],
                link: '/services/' + this.username,
                status : null,
                isSubmitting: false,
                formErrors : null,
            }
        },

        props: {
            firstName: null,
            username: null,
            skills: null,
            avatar: null,
        },

        methods: {

            submitRequest(){
                var _this = this,
                    data = {
                        subject : _this.subject,
                        body : _this.body,
                        services : _this.services,
                    };
                
                _this.isSubmitting = true;
                axios.post(_this.link, data).then( (response) => {
                    _this.subject = null;
                    _this.body = null;
                    _this.services = null;
                    _this.status = '<strong>Oshe!</strong> Your request was sent successfully!';
                    _this.isSubmitting = false;
                    setTimeout(()=>{
                        _this.status = null;
                        window.location.href = window.Laravel.url + '/' + _this.username;
                    },3000)
                }).catch((e)=>{
                    _this.isSubmitting = false;
                    _this.formErrors = e.response.data;
                });
            }

        },

        mounted() {
            //
        }
    }
</script>
