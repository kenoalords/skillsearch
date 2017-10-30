<template>
    <span>
        <button class="ui icon mini button" v-on:click.prevent="togglePrivacy" v-bind:class="{'red' : !isPublic, 'green' : isPublic}">
            <i class="icon " v-bind:class="{'lock' : !isPublic, 'unlock' : isPublic}"></i>
        </button>
    </span>
</template>

<script>
    export default {
        data(){
            return {
                isPublic: false,
            }
        },

        methods: {
            togglePrivacy(){
                if(this.isPublic){
                    this.isPublic = false;
                    this.setPrivate();
                } else {
                    this.isPublic = true;
                    this.setPublic();
                }
            },

            setPrivate(){
                axios.get('/profile/set/private');
            },

            setPublic(){
                axios.get('/profile/set/public');
            },

            getStatus(){
                var _this = this;
                axios.get('/profile/get-privacy').then((response)=>{
                    _this.isPublic = response.data.status;
                });
            }
        },

        props: {
            public: null
        },

        mounted() {
            this.getStatus();
        }
    }
</script>
