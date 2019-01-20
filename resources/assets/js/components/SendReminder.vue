<template>
    <span>
        <button class="button is-info" :disabled="isSending" :class="{'is-loading':isSending}" @click.prevent="sendReminder()">Send contact reminder</button>
    </span>
</template>

<script>
    export default {
        data(){
            return {
                isSending: false,
            }
        },
        methods: {
            sendReminder(){
                const $this = this;
                if(confirm('Are you sure you want to send the contact invite reminder?')){
                    $this.isSending = true;
                    $('body').addClass('is-loading');
                    axios.post('/dashboard/send-reminder').then( (response) => {
                        $('body').removeClass('is-loading');
                        $this.isSending = false;
                        iziToast.success({ title: "Contact reminder sent successfully" });
                    }).catch( (error) => {
                        $('body').removeClass('is-loading');
                        iziToast.error({ title: 'An error occured. Please check the console' });
                        console.log(error);
                    })
                }
            },
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
