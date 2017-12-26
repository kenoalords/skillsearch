<template>
    <div>
        <div class="ui card" itemscope itemtype="http://schema.org/CreativeWork">
            <div class="content tablet-only">
                <a :href="portfolio.user" style="font-size: .875em; font-weight: 700" itemprop="url">
                    <img :src="portfolio.user_profile.avatar" :alt="portfolio.user_profile.fullname" class="ui avatar image">
                     <span itemprop="author" v-text="portfolio.user_profile.fullname"></span>
                     <img :src="verified" alt="Verified profile" v-if="portfolio.user_profile.verified" class="verified">
                </a>
            </div>
            <div class="ui fluid image">
                <a :href="portfolio.link.url" style="line-height: 0; display: block;" itemprop="url">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+ip1sAAAAASUVORK5CYII=" :data-src="portfolio.thumbnail" :alt="portfolio.title" class="b-lazy">
                    <meta itemprop="thumbnailUrl" :content="portfolio.thumbnail">
                </a>
                <div class="featured-tag" v-if="portfolio.is_featured"><i class="icon star"></i></div>
            </div>
            <div class="content">
                <div class="small bold">
                    <!-- <div class="right floated meta">14h</div> -->
                    <a :href="portfolio.user" class="large-screen-only" itemprop="url">
                        <img :src="portfolio.user_profile.avatar" :alt="portfolio.user_profile.fullname" class="ui avatar image">
                         <span itemprop="author" v-text="portfolio.user_profile.first_name"></span>
                         <img :src="verified" alt="Verified profile" v-if="portfolio.user_profile.verified" class="verified">
                    </a>

                    <span class="right floated meta large-screen-only portfolio-meta">
                        <span class="bold"><a :href="portfolio.link.url"><i class="fa fa-thumbs-up"></i> {{portfolio.likes_count}}</a></span>

                        <span class="bold" style="margin-left: 1em"><a :href="portfolio.link.url + '#comment'"><i class="fa fa-comment"></i> <span itemprop="commentCount">{{portfolio.comment_count}}</span></a></span>
                        <featured :uid="portfolio.uid" :key="portfolio.uid" :stared="portfolio.is_featured"></featured>
                    </span>

                    <span class="meta mobile-only tablet-only portfolio-meta">
                        <span class="bold"><a :href="portfolio.link.url"><i class="fa fa-thumbs-up"></i> {{portfolio.likes_count}}</a></span>
                        
                        <span class="bold" style="margin-left: 1em"><a :href="portfolio.link.url"><i class="fa fa-comment"></i> <span itemprop="commentCount">{{portfolio.comment_count}}</span></a></span>
                        <featured :uid="portfolio.uid" :key="portfolio.uid" :stared="portfolio.is_featured"></featured>
                    </span>
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
            // console.log('Component mounted.')
        }
    }
</script>
