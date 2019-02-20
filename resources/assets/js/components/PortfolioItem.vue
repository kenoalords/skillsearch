<template>
    <div class="column is-one-third-tablet is-one-quarter-desktop is-half-mobile">
        <div class="card portfolio" itemscope itemtype="http://schema.org/CreativeWork">
            
            <div class="card-image">
                <a :href="portfolio.link.url" style="line-height: 0; display: block;" itemprop="url">
                    <figure>
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+ip1sAAAAASUVORK5CYII=" :data-src="portfolio.thumbnail" :alt="portfolio.title" class="b-lazy">
                        <meta itemprop="thumbnailUrl" :content="portfolio.thumbnail">
                    </figure>
                </a>
                <span class="is-featured" v-if="portfolio.verified">
                    <img src="/images/featured-badge.png" alt="featured work">
                </span>
            </div>
            <div class="card-content" style="padding: 5px;">
                <div class="level is-mobile">
                    <div class="level-left">
                        <a :href="portfolio.user" class="level-item" itemprop="url"  :class="{'verified': portfolio.verified}">
                            <img :src="portfolio.user_profile.avatar" :alt="portfolio.user_profile.fullname" class="image is-24x24 is-rounded is-inline">
                        </a>
                    </div>
                    <div class="level-right">
                        <span class="level-item">
                            <span>
                                <a :href="portfolio.link.url" class="is-grey">
                                    <span class="icon"><i class="fa fa-thumbs-up"></i></span> 
                                    <span>{{portfolio.likes_count}}</span>
                                </a>
                            </span>
                        </span>
                        <span class="level-item">
                            <a :href="portfolio.link.url + '#comment'" class="is-grey">
                                <span class="icon"><i class="fa fa-comment"></i></span>
                                <span itemprop="commentCount">{{portfolio.comment_count}}</span>
                            </a>
                        </span>
                        <featured :uid="portfolio.uid" :key="portfolio.uid" :status="portfolio.is_featured" class="level-item"></featured>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data(){
            return {
                portfolio : this.data,
                verified: window.Laravel.url + '/public/verified.svg',
            }
        },

        props:{
            data: Object,
        },

        mounted() {
            var bLazy = new Blazy({
                offset: 200
            });
            // console.log(this.data)
        }
    }
</script>
