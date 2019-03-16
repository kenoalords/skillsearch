<template>
    <span class="like-button-wrapper">
        <span class="like_btn" :class="{ 'liked' : hasLiked }" :id="pid">
            <a v-on:click.prevent="submitLike" class="like-button" v-bind:class="{ 'liked' : hasLiked }">
                <i class="fa fa-thumbs-up" v-if="size"></i> 
                <i class="fa fa-thumbs-up" v-else="!size"></i>
            </a>
        </span>
        <span class="counter">{{ count }}</span>
    </span>
</template>

<script>
    export default {
        data(){
            return{
                isLoggedIn: null,
                count: this.likes,
                canLike: false,
                hasLiked: (this.liked == '1') ? true : false,
                isUserLoggedIn: window.Laravel.userLoggedIn,
                size: (this.big == 'true') ? true : false,
                pid: this.id,
            }
        },
        props: {
            id: null,
            big: null,
            likes: null,
            liked: null,
        },

        methods: {
            formatCount(count){
                var text = '';
                if(count === 0){
                    text = 'Be the first to like!';
                } else if(count === 1){
                    text = count + ' person likes this';
                }else if(count > 1){
                    text = count + ' people like this';
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
                    iziToast.success({
                        title: 'Liked!',
                        message: 'You rock!'
                    });
                } else if(this.hasLiked === true){
                    this.count--;
                    this.hasLiked = false;
                    this.unlike();
                    iziToast.info({
                        title: 'Unliked!',
                    });
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
            this.getLikes();
        }
    }
</script>
