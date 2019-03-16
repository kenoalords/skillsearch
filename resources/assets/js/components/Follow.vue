<template>
    <span v-if="isLoaded">
        <span v-if="!is_self">
            <a href="#"  class="button" v-on:click.prevent="handle" :class="{ 'is-info': !can_follow }">
                <span class="icon"><i class="fa " :class="{ 'fa-user': can_follow, 'fa-check' : !can_follow }"></i></span> <span>{{ can_follow ? 'Follow' : 'Following' }} </span>
            </a>
        </span>
    </span>
</template>

<script>
    export default {
        data () {
            return {
                followers : null,
                following : null,
                can_follow : true,
                is_self : false,
                isLoaded : false,
                isUserLoggedIn : window.Laravel.userLoggedIn,
            }
        },

        props: {
            username : null
        },

        methods: {

            getFollowership: function (){
                var _this = this;
                axios
                    .get('/follower/' + this.username)
                    .then( (response) => {
                        _this.isLoaded = true;
                        _this.followers = response.data.followers;
                        _this.following = response.data.following;
                        _this.can_follow = response.data.can_follow;
                        _this.is_self = response.data.is_self;
                    });
            },

            handle: function(){
                if(!this.isUserLoggedIn){
                    alert('Please login to follow this user');
                    return;
                }

                if(this.can_follow){
                    this.can_follow = false;
                    this.followers++;
                    this.follow();

                } else {
                    this.can_follow = true;
                    this.followers--;
                    this.unfollow();

                }
            },

            follow: function(){
                axios.post('/follower/' + this.username);
            },

            unfollow: function(){
                axios.delete('/follower/' + this.username);
            }

        },

        mounted() {
            this.getFollowership();
        }
    }
</script>
