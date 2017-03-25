<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Send Message to: {{ profile.name }}</div>

                    <div class="panel-body">
                        <div class="form-group">
                            <input type="text" v-model="subject" class="form-control" placeholder="Subject">
                        </div>
                        <div class="form-group">
                            <textarea rows="10" v-model="message" class="form-control" placeholder="Message"></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-block btn-info" v-on:click.prevent="sendMessage">Send message</button>
                        </div>
                        <h4 class="text-center">{{ status }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            var user = (this.user) ? JSON.parse(this.user) : '';
            return {
                subject : null,
                receiver_id : user.id,
                message : null,
                sent : false,
                sending : false,
                profile : user,
                status : null
            }
        },
        props: {
            user : null
        },
        methods: {
            sendMessage: function ( event ) {
                var data = {
                    subject : this.subject,
                    message : this.message,
                    receiver_id : this.receiver_id
                },
                    _this = this;
                axios.post( '/' + this.user.name + '/message', data )
                    .then ( (response) => {
                        _this.status = 'Your message was sent successfully';
                        _this.subject = '';
                        _this.message = '';
                    });
            }
        },
        mounted() {
            
        }
    }
</script>
