<template>
    <span>
        
    </span>
</template>

<script>
    export default {
        data(){
            return {
                isActive: false,
            }
        },
        methods: {
            pushNotification: function(){

            },
            checkPushStatus: function(){
                // window.serviceWorker.pushManager.getSubscription().then( (subscription) => {
                //     console.log(subscription);
                // }).catch( (error) => {
                //     console.log(error);
                // });
            }
        },
        mounted() {
            this.checkPushStatus();
        }
    }
</script>
