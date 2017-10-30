<template>
    <span>
        <div class="field">
            <label for="">Referral Code (Optional)</label>
            <input type="text" v-model="referralCode" v-on:keyup="checkReferralCode">
        </div>
    </span>
</template>

<script>
    export default {
        data(){
            return {
                referralCode: (this.code) ? this.code : null,
            }
        },
        props: {
            code: null,
        },
        methods: {
            checkReferralCode: function(){
                if(this.referralCode.length > 6){
                    
                }
            },
        },
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
