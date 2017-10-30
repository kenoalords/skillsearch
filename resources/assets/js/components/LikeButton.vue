<template>
    <span>
        <a v-on:click.prevent="submitLike" class="ui circular extra huge icon button" v-bind:class="{ 'purple' : hasLiked }">
            <i class="icon thumbs up"></i> 
        </a> <span class="like-count">{{count}}</span>
         <!-- <small class="text-muted"> {{formatCount(count)}}</small> -->
    </span>
</template>

<script>
    export default {
        data(){
            return{
                isLoggedIn: null,
                count: null,
                canLike: false,
                hasLiked: false,
                isUserLoggedIn: window.Laravel.userLoggedIn,
            }
        },
        props: {
            id: null,
        },

        methods: {
            formatCount(c){
                var text = '';
                if(c === 0){
                    text = 'No likes yet';
                } else if(c === 1){
                    text = ' person likes this';
                }else if(c > 1){
                    text = ' people like this';
                }
                return text;
            },

            getLikes(){
                var _this = this;
                axios.get('/likes/'+this.id).then((response)=>{
                    // console.log(response);
                    _this.count = response.data.count;
                    _this.canLike = response.data.canLike;
                    _this.hasLiked = response.data.hasLiked;
                })
            },

            submitLike(){
                if(this.isUserLoggedIn === false){
                    alert('Please login to like this portfolio');
                    return;
                }
                if(this.hasLiked === false){
                    this.count++;
                    this.hasLiked = true;
                    this.like();
                } else if(this.hasLiked === true){
                    this.count--;
                    this.hasLiked = false;
                    this.unlike();
                }
            },

            like(){
                var _this = this,
                    data = {
                        id: _this.id
                    };
                axios.post('/likes/'+this.id, data);
            },

            unlike(){
                var _this = this,
                    data = {
                        id: _this.id
                    };
                axios.delete('/likes/'+this.id, data);
            }
        },
        mounted() {
            console.log(this.isUserLoggedIn);
            this.getLikes();
        }
    }
</script>
