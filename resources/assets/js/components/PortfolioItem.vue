<template>
    <div class="column is-one-third-desktop is-one-quarter-widescreen is-half-tablet">
        <div class="card portfolio" itemscope itemtype="http://schema.org/CreativeWork">
            
            <div class="card-image">
                <a :href="portfolio.link.url" style="line-height: 0; display: block;" itemprop="url">
                    <figure>
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+ip1sAAAAASUVORK5CYII=" :data-src="portfolio.thumbnail" :alt="portfolio.title" class="b-lazy">
                        <meta itemprop="thumbnailUrl" :content="portfolio.thumbnail">
                    </figure>
                </a>
            </div>
            <div class="card-content" style="padding: 5px;">
                <div class="level is-mobile">
                    <div class="level-left">
                        <a :href="portfolio.user" class="level-item" itemprop="url"  :class="{'verified': portfolio.verified}">
                            <img :src="portfolio.user_profile.avatar" :alt="portfolio.user_profile.fullname" class="image is-24x24 is-rounded is-inline"> &nbsp;
                             <span itemprop="author" v-text="portfolio.user_profile.first_name" class="has-text-weight-bold author"></span>
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
                        <featured :uid="portfolio.uid" :key="portfolio.uid" :stared="portfolio.is_featured" class="level-item"></featured>
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
