<template>
    <span>
        <a v-on:click.prevent="submitLike()" class="btn btn-thumbs-up" :class="{'btn-default' : !hasLiked, 'btn-success' : hasLiked}" v-if="isReady"><i class="fa fa-thumbs-up" style="top:0"></i> {{likeCount}}</a>
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
    				axios.post('/blog/like/'+this.blogId+'/submit').then((response)=>{
    					console.log(response);
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
