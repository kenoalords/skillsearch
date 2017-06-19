<template>
    <div>
        <ul class="list-inline bold" v-if="!isRejected">
            <li><a href="" class="btn btn-primary btn-sm" v-on:click.prevent="approveJob()"><i class="fa fa-check-circle"></i> Approve</a></li>
            <li><a href="" class="btn btn-default btn-sm" v-on:click.prevent="isRejected = true"><i class="fa fa-close"></i> Reject</a></li>
        </ul>
        <div class="form-group" v-if="isRejected">
            <p><textarea v-model="message" rows="3" class="form-control"></textarea></p>
            <p>
                <button class="btn btn-default" v-on:click.prevent="sendRejectMessage()" :disabled="isSending">Send Message</button>
                <button class="btn btn-default" v-on:click.prevent="isRejected = false">Cancel</button>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                isRejected: false,
                message: null,
                job: JSON.parse(this.task),
                rejectUrl: window.Laravel.url + '/profile/jobs/' + JSON.parse(this.task).id + '/reject',
                approveUrl: window.Laravel.url + '/profile/jobs/' + JSON.parse(this.task).id + '/approve',
                isSending: false,
            }
        },

        props: {
            task: null,
        },

        methods: {
            sendRejectMessage(){
                var _this = this;
                _this.isSending = true;
                if(_this.message !== null){
                    var data = {
                        id : _this.job.id,
                        message : _this.message,
                    };
                    axios.put(_this.rejectUrl, data).then((response)=>{
                        _this.isSending = false;
                        alert('Rejection Notice Sent!');
                        $('#job-'+_this.job.id).slideUp('fast');
                    })
                    .catch((error)=>{
                        alert('Something went wrong');
                        _this.isSending = false;
                        _this.isRejected = false;
                    })
                }
            },

            approveJob(){
                if(window.confirm('Are you sure you want to approve this job')){
                    var _this = this;
                    var data = {
                        id : _this.job.id,
                    };
                    axios.put(_this.approveUrl, data).then((response)=>{
                        $('#job-'+_this.job.id).slideUp('fast');
                    })
                };
            }
        },

        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
