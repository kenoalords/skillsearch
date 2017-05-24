<template>
    <div>
        <div v-if="isFetching" class="text-center">
            <div class="padded">
                <h4 class="thin"><img :src="loader" width="24" height="24"> Loading Instagram Feed</h4>
            </div>
        </div>

        <div class="text-center" v-if="error">
            <h4 class="thin"><i class="fa fa-warning"></i> Error!</h4>
            <p>Sorry we could not load this instagram feed, please try again later.</p>
        </div>

        <div v-if="feeds" id="showcase" class="row" style="padding: 0px">
            <div class="grid">
                <div class="col-xs-12 col-sm-4 col-md-4 grid-item" :class="{'grid-sizer' : feeds.indexOf(feed) == 0 }" v-for="feed in feeds">
                    <div class="image-wrapper" :class="feed.type" style="margin-bottom:2.3em">
                        <a :href="feed.link" target="_blank" :data-image="feed.images.standard_resolution.url" v-on:click.prevent="showImage(feed)">
                            <img :src="feed.images.standard_resolution.url" width="320" height="320" alt="feed.user.full_name" class="img-responsive">
                        </a>
                        <div class="p-content">
                            <ul class="list-inline" style="font-size: 87.5%">
                                <li><i class="fa fa-heart"></i> {{feed.likes.count}} </li>
                                <li><i class="fa fa-comments"></i> {{feed.comments.count}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div><!-- end of grid -->
        </div>

        <div id="instagram-overlay" v-if="isOverlay">
            <a id="close-overlay" href="#" class="btn btn-basic text-muted" v-on:click.prevent="closeOverlay()"><i class="fa fa-close"></i></a>
            <div class="container">
                <div class="instagram-media col-md-6 col-md-offset-3" v-if="currentlyViewing">
                    <div v-if="currentlyViewing.type === 'image'">
                        <img :src="currentlyViewing.images.standard_resolution.url" alt="currentlyViewing.user.full_name" class="img-responsive">
                    </div>
                    <div v-if="currentlyViewing.type === 'video'">
                        <video id="video" class="video-js vjs-default-skin vjs-big-play-centered vjs-16-9" controls preload="auto" data-setup='{"fluid":true, "preload":auto}'>
                            <source type="video/mp4" v-bind:src="currentlyViewing.videos.standard_resolution.url"></video>
                        </video>
                    </div>
                </div>
                <div class="instagram-content col-md-6 col-md-offset-3">
                    <div class="media">
                        <div class="media-left">
                            <a :href="'https://instagram.com/' + currentlyViewing.user.username">
                                <img :src="currentlyViewing.user.profile_picture" alt="currentlyViewing.user.full_name" width="48" height="48" class="img-circle">
                            </a>
                        </div>
                        <div class="media-body">
                            <h5 class="media-heading bold">
                                <a :href="'https://instagram.com/' + currentlyViewing.user.username" target="_blank">
                                    {{currentlyViewing.user.full_name}}
                                </a>
                            </h5>
                            <ul class="list-inline bold">
                                <li><i class="fa fa-heart"></i> {{currentlyViewing.likes.count}} </li>
                                <li><i class="fa fa-comments"></i> {{currentlyViewing.comments.count}}</li>
                            </ul>
                        </div>
                    </div>
                    
                    <hr>
                    <p v-if="currentlyViewing.caption">
                        {{ currentlyViewing.caption.text }}
                    </p>  
                    <p>
                        <small class="bold"><a :href="currentlyViewing.link" target="_blank">View on Instagram <i class="fa fa-external-link"></i></a></small>
                    </p>
                </div>
            </div>
            <div class="navigation-links">
                <a href="#" class="prev text-muted" v-on:click.prevent="prevPost(currentlyViewing)"><i class="fa fa-arrow-left"></i></a>
                <a href="#" class="next text-muted" v-on:click.prevent="nextPost(currentlyViewing)"><i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</template>

<script>
    import videojs from "video.js";
    import masonry from "masonry-layout/dist/masonry.pkgd.min.js";
    import imagesLoaded from "imagesloaded/imagesloaded.js";
    export default {
        data(){
            return {
                feeds: null,
                isFetching: false,
                loader: window.Laravel.url + '/public/loading.gif',
                error: false,
                isOverlay: false,
                currentlyViewing : null,
                player : null,
            }
        },
        props: {
            user : null,
        },

        methods: {
            getInstagramFeed(){
                var _this = this;
                _this.isFetching = true;
                axios.get(window.Laravel.url + '/' + _this.user + '/instagram/feed').then((response)=>{
                    // console.log(response);
                    _this.isFetching = false;
                    _this.feeds = response.data;

                    setTimeout(()=>{
                        var el = document.querySelector('.grid');
                        if(el.length > 0){
                            var loaded = el.imagesLoaded(function(){
                                alert('loaded');
                                var masonry = new Masonry(el, {
                                    itemSelector: '.grid-item',
                                    columnWidth: '.grid-sizer',
                                    percentPosition: true,
                                });
                            });
                        }
                    },500);
                    
                }).catch((e) => {
                    console.log(e);
                    _this.isFetching = false;
                    _this.error = true;
                });
            },

            showImage(feed){
                console.log(feed);
                this.isOverlay = true;
                this.currentlyViewing = feed;
                if(feed.type === 'video'){
                    setTimeout(()=>{
                        videojs(document.querySelector('.video-js'));
                    }, 300)
                    
                }
            },

            closeOverlay(){
                this.isOverlay = false;
            },

            prevPost(feed){
                var index = this.feeds.indexOf(feed);
                if(index === 0){
                    setTimeout(()=>{
                        this.currentlyViewing = this.feeds[this.feeds.length - 1]
                    },300)
                } else {
                    setTimeout(()=>{
                        this.currentlyViewing = this.feeds[index - 1];
                    },300)
                }
            },

            nextPost(feed){
                var index = this.feeds.indexOf(feed);
                if(index === (this.feeds.length - 1)){
                    setTimeout(()=>{
                        this.currentlyViewing = this.feeds[0]
                    },300)
                } else {
                    setTimeout(()=>{
                        this.currentlyViewing = this.feeds[index + 1];
                    },300)
                }
            }
        },
        mounted() {
            this.getInstagramFeed();
        }
    }
</script>
