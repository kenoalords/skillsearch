<template>
    <span>
        <button class="button is-primary" :disabled="isSending" :class="{'is-loading':isSending}" @click.prevent="sendReminder()">Send contact reminder</button>
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

                    axios.post('/dashboard/send-reminder').then( (response) => {
                        $this.isSending = false;
                    })
                }
            },
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
