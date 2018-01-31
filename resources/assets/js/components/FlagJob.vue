<template>
    <span>
        <a href="" class="button is-small" v-on:click.prevent="flagJob()">
            <span class="icon"><i class="fa fa-warning"></i></span>
            <span>{{ isFlagged ? 'Flagged' : 'Flag as spam' }}</span>
        </a>
    </span>
</template>

<script>
    export default {

        data(){
            return {
                taskId : this.jobId,
                url : window.Laravel.url + '/dashboard/jobs/' + this.jobId + '/flag',
                urlCheck : window.Laravel.url + '/dashboard/jobs/' + this.jobId + '/flag/check',
                isLoggedIn: window.Laravel.userLoggedIn,
                isFlagged: false,
            }
        },

        props: {
            jobId : null,
        },

        methods: {
            flagJob(){
                var _this = this;
                if(window.confirm('Are you sure you want to flag this job?')){
                    axios.post(_this.url).then( (response)=>{
                        if(response.data === true){
                            alert('This job has been flagged');
                            _this.isFlagged = response.data;
                            return;
                        } else {
                            alert('You have flagged this job already');
                            return;
                        }
                    } )
                    .catch((error)=>{
                        alert('Oops!!! Something went wrong, please try again later');
                    });
                }
            },

            checkFlagged(){
                var _this = this;
                if(!_this.isLoggedIn){
                    return;
                }

                axios.get(_this.urlCheck).then( (response) => {
                    _this.isFlagged = response.data;
                } )
            }
        },

        mounted() {
            this.checkFlagged();
        }
    }
</script>
