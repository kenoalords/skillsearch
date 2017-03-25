<template>
    <p></p>
</template>

<script>
    export default {
        data(){
            return {
                id: this.uid,
            }
        },
        methods:{
            logView(){
                axios.post('/portfolio/' + this.id + '/views');
            }
        },
        props:{
            uid: null,
        },

        mounted() {
            setTimeout(()=>{
                this.logView()
            }, 5000)
        }
    }
</script>
