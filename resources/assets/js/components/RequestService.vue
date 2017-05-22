<template>
    <div id="service-request" class="padded">
        <div class="alert alert-success" role="alert" v-if="status" v-html="status">
        </div>
        <div class="alert alert-danger" role="alert" v-if="formErrors" v-for="error in formErrors">
            {{error[0]}}
        </div>
        <h2><span class="bold">Hire {{firstName}}</span> <span class="thin"> | Request any of {{firstName}}'s services</span></h2>
        <p class="text-info"><i class="glyphicon glyphicon-info-sign"></i> All fields are required</p>
        <hr>
        <div>
            <div class="form-group">
                <p>Select the service you will like to request for? <span class="text-muted"></span></p>
                <label v-if="userServices" v-for="service in userServices">
                    <input type="checkbox" v-bind:value="service.skill" v-model="services"> {{ service.skill }}
                </label>
            </div>

            <div class="form-group">
                <input type="text" v-model="subject" class="form-control" placeholder="Subject">
            </div>

            <div class="form-group">
                <textarea v-model="body" class="form-control" placeholder="Make your request" rows="3"></textarea>
            </div>

            <div class="form-group clearfix">
                <button id="submitRequest" class="btn btn-primary pull-left" v-on:click.prevent="submitRequest" :disabled="isSubmitting">Submit Request</button>
                <a :href="'/' + username" class="btn btn-basic pull-right">Back to profile</a>
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
