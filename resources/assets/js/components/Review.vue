<template>
    <div>
        <div v-if="userLoggedIn && !isOwner" >
            <h4>Submit a review</h4>
            <hr>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <textarea v-model="review" class="form-control"></textarea>
                    </div>
                    <div class="clearfix">
                        <div class="pull-left">
                            <input name="score" id="score" type="number" class="rating" step=1 size="xs">
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-default" v-on:click.prevent="submitReview">Submit Review</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else-if="!userLoggedIn">
            
            <p>Please <a href="/login">login</a> if you will like to submit a review</p>
            <p><a href="/login" class="btn btn-primary">Login</a> or <a href="/register" class="btn btn-primary">Register</a></p>
            <hr>
        </div>

        <div v-if="reviews.length > 0">
            <h4>{{ reviews.length }} {{ (reviews.length > 1) ? 'Reviews' : 'Review' }}</h4>
            <hr>
            <div class="media review-list" v-for="review in reviews">
                <div class="media-left">
                    <a v-bind:href="review.user.name">
                        <img v-bind:src="getImage(review.profile.avatar)" width="50" height="50" class="media-object thumbnail">
                    </a>
                </div>
                <div class="media-body">
                    <h5 class="media-heading bold">
                        <a v-bind:href="review.user.name">{{ review.profile.first_name }} {{ review.profile.last_name }}</a>
                    </h5>
                    <div v-html="getRatings(review.score)"></div>
                    <p>{{ review.review }}</p>
                    <span class="text-muted"><small>{{review.date}}</small></span>
                </div>
            </div>
        </div>
        <div v-else-if="reviews.length == 0">
            <div class="text-center">
                <p style="font-size: 3em"><i class="glyphicon glyphicon-thumbs-down"></i></p>
                <p>No reviews yet!</p>
            </div>
        </div>
    </div>
</template>

<script>
    // import kartik from 'kartik-v';
    export default {
        data() {
            return {
                reviews: [],
                hasReviewed : false,
                review: null,
                score : 4,
                userLoggedIn : window.Laravel.userLoggedIn,
                isOwner : (parseInt(window.Laravel.user_id) === parseInt(this.userId)) ? true : false,
            }
        },

        props: {
            username : null,
            userId : null 
        },

        methods: {

            getReviews(){
                var _this = this;
                axios.get("/reviews/" + this.username).then( (response) => { 
                    setTimeout(()=>{
                        _this.reviews = response.data;
                    })   
                });
            },

            submitReview(){
                var score = document.getElementById('score').value;
                var _this = this;
                var data = {
                        score : score,
                        review : this.review,
                    };
                axios.post("/reviews/" + this.username, data).then( (response) => {
                    _this.review = '';
                    score = 0;
                    _this.reviews.unshift(response.data);
                });
                
            },

            getImage: function (image){
                return window.skillsearch.s3images + '/' + image;
            },

            getRatings(count){
                var star = '',
                    r = 5 - count;

                for(var i=0; i<count; i++){
                    star += '<span class="glyphicon glyphicon-star text-primary"></span>';
                }
                if(r > 0){
                    for(var i=0; i < r; i++){
                        star += '<span class="glyphicon glyphicon-star text-muted" style="opacity:.2"></span>';
                    }
                }
                return star;
            }

        },

        mounted() {
            this.getReviews();
        }
    }
</script>
