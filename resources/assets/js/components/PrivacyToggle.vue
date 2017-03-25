<template>
    <span>
        <button class="btn btn-default" v-on:click.prevent="togglePrivacy">
        <i class="fa" v-bind:class="{'fa-lock' : !isPublic, 'fa-unlock' : isPublic}"></i>
        {{ !isPublic ? 'Make Profile Public' : 'Make Profile Private' }}
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
