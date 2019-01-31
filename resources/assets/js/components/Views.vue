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
                axios.post('/portfolio/' + this.id + '/views').then((response)=>{
                    console.log('view registered')
                }).catch( (err) => {
                    console.log(err);
                });
            }
        },
        props:{
            uid: null,
        },

        mounted() {
            setTimeout(()=>{
                this.logView()
            }, 3000)
        }
    }
</script>
