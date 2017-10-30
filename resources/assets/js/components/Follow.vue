<template>
    <span v-if="isLoaded">
        <!-- <ul id="f-stats">
            <li><strong>{{followers}}</strong> Followers</li>
            <li><strong>{{following}}</strong> Following</li>
            
        </ul> -->
        <span v-if="!is_self">
            <a href="#" v-bind:class="{'basic': can_follow, 'blue' : !can_follow}" class="ui mini icon labeled button" v-on:click.prevent="handle">
                <i class="icon user"></i>
                {{ can_follow ? 'Follow' : 'Following' }}
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
