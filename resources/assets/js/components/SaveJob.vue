<template>
    <span>
        <a href="#" class="btn btn-sm" v-on:click.prevent="saveJob()" :class="{ 'btn-default-success-outline' : isSaved, 'btn-default' : !isSaved }"><i class="fa fa-star"></i> {{ isSaved === false ? 'Save Job' : 'Saved!' }}</a>
    </span>
</template>

<script>
    export default {
        data() {
            return{
                id: this.jobId,
                url: window.Laravel.url + '/profile/jobs/' + this.jobId + '/save',
                checkUrl: window.Laravel.url + '/profile/jobs/' + this.jobId + '/save/check',
                isLoggedIn: window.Laravel.userLoggedIn,
                isSaved: false,
                userId: window.Laravel.user_id,
            }
        },

        props: {
            jobId: null
        },

        methods: {
            saveJob(){
                if(!this.isLoggedIn){
                    alert('Please login to save this job');
                    return;
                }
                var _this = this;
                axios.post(_this.url).then( (response) => {
                    if(response.data === true){
                        _this.isSaved = true;
                    } else {
                        _this.isSaved = false;
                    }
                } )
            },

            checkSavedStatus(){
                if(!this.isLoggedIn){
                    return;
                }
                var _this = this;
                var data = {
                    id: _this.jobId,
                    user: _this.userId,
                }
                axios.get(this.checkUrl).then( (response) => {
                    _this.isSaved = response.data;
                } )
            }
        },

        mounted() {
            this.checkSavedStatus();
        }
    }
</script>
