<template>
    <span>
        <a v-on:click.prevent="submitLike()" class="button" :class="{'is-light' : !hasLiked, 'is-info' : hasLiked}" v-if="isReady"><span class="icon"><i class="fa fa-thumbs-up" style="top:0"></i></span> <span>Like <span style="opacity: 0.7">{{likeCount}}</span></span></a>
    </span>
</template>

<script>
    export default {
    	data(){
    		return{
    			likeCount: this.count,
    			hasLiked: false,
    			blogId: this.uid,
    			isUserLoggedIn: window.Laravel.userLoggedIn,
    			isReady: false,
    		}
    	},
    	props: {
    		uid: null,
    		count: null,
    	},
    	methods: {
    		submitLike(){
    			if(this.isUserLoggedIn === true){
    				if(this.hasLiked){
    					this.likeCount--;
    					this.hasLiked = false;
    				} else {
    					this.likeCount++;
    					this.hasLiked = true;
    				}
                    var _this = this;
    				axios.post('/dashboard/blog/like/'+this.blogId+'/submit').then((response)=>{
    					// console.log(response);
                        _this.likeCount = response.data.count;
    				}).catch((error)=>{
    					alert('Oops! Something went wrong, please try again later');
    				});
    			} else {
    				alert('Please login to like this post');
    			}
    		},
    		hasUserLiked(){
    			var _this = this;
    			if(this.isUserLoggedIn === true){
    				axios.get('/blog/like/'+this.blogId+'/check').then((response)=>{
    					_this.hasLiked = response.data;
    					_this.isReady = true;
    				});
    			} else {
    				_this.isReady = true;
    			}
    		}
    	},
        mounted() {
            this.hasUserLiked();
        }
    }
</script>
