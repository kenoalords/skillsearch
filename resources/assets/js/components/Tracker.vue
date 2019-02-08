<template>
    <span>
        <span></span>
    </span>
</template>

<script>
    export default {
        data(){
            return {

            }
        },
        props:{
            type: String,
            id: Number,
            url: '',   
            tags: '',         
        },
        methods: {
            tracker: function(){
                let data = {
                    id: this.id,
                    type: this.type,
                    url: this.url,
                    tags: this.tags,
                },
                _this = this;
                axios.post('/tracker/add', data).then( (response) => {
                    console.log(response);
                }).catch( (error) => {
                    console.log(error);
                });
            },
        },
        mounted() {
            this.tracker();
        }
    }
</script>
