<template>
    <span>
        <a href="#" class="ui icon labeled green button" :class="{'loading':isGenerating}" v-if="!hasCode" v-on:click.prevent="generateReferralCode">
            <i class="icon handshake"></i>Generate referral code
        </a>
        <span class="ui icon labeled green button" v-if="hasCode" >
            <i class="icon handshake"></i>{{refCode.toUpperCase()}}
        </span>
    </span>
</template>

<script>
    export default {
        data: function(){
            return {
                hasCode: false,
                isGenerating: false,
                refCode: this.code,
            }
        },

        props: {
            code: null,
        },  

        methods: {
            generateReferralCode: function(){
                var _this = this;
                this.isGenerating = true;
                axios.get('/home/referral/generate').then((response)=>{
                    _this.refCode = response.data.code;
                    _this.isGenerating = false;
                    _this.hasCode = true;
                });
            },
        },

        mounted() {
            if(this.code){
                this.hasCode = true;
            }
        }
    }
</script>
