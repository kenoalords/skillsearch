<template>
    <span v-if="isLoaded">
        <span v-if="!is_self">
            <a href="#" v-bind:class="{'is-light': can_follow, 'is-primary' : !can_follow}" class="button is-small has-text-weight-bold" v-on:click.prevent="handle">
                <span class="icon"><i class="fa fa-user"></i></span> <span>{{ can_follow ? 'Follow' : 'Following' }} </span> <span class="icon" v-if="!can_follow"><i class="fa fa-check"></i></span>
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
