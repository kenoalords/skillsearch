<template>
    <div id="portfolio-items" v-if="isLoaded">
        <h4>Portfolio</h4>
        <hr>
        <div class="row" v-if="portfolios.length > 0">
            <div class="col-sm-6 col-md-3" v-for="portfolio in portfolios">
                <div v-if="portfolio.type == 'images'">
                    <a v-bind:href="'/'+ username + '/portfolio/' + portfolio.uid">
                        <img v-bind:src="getFirstImage(portfolio.files, portfolio.thumbnail)" v-bind:alt="portfolio.title" class="img-responsive">
                    </a>
                </div>
                <div v-if="portfolio.type == 'audio'">
                    <a v-bind:href="'/'+ username + '/portfolio/' + portfolio.uid">
                        <img v-bind:src="getAudioImage(portfolio.thumbnail)" :alt="portfolio.title" class="img-responsive">
                    </a>
                </div>
                <div class="p-content">
                    <h5 class="bold"><a v-bind:href="'/'+ username + '/portfolio/' + portfolio.uid">{{ portfolio.title }}</a></h5>
                    <p class="bold clearfix">
                        <small class="text-muted pull-left">
                            <i class="glyphicon glyphicon-heart"></i> 
                            {{portfolio.likes}} {{portfolio.likes > 1 ? 'Likes' : 'Like'}}
                        </small>
                        <small class="text-muted pull-right">{{portfolio.date}}</small>
                    </p>
                    
                </div>
            </div>
        </div>

        <div v-else-if="portfolios.length == 0">
            <p class="text-warning">No portfolio item has been uploaded</p>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                portfolios: [],
                queryLink : '/portfolio/' + this.username,
                isLoaded : false,
            }
        },
        props: {
            username: null
        },
        methods: {

            getPortfolio(){
                var _this = this;
                axios.get(this.queryLink).then( (response) => {
                    _this.isLoaded = true;
                    _this.portfolios = response.data;
                });
            },

            getFirstImage(file, thumbnail=null){
                if(thumbnail){
                    return window.Laravel.url + '/' + thumbnail;
                }
                return window.Laravel.url + '/' + file[0].file;
            },

            getAudioImage(thumbnail=null){
                if(thumbnail){
                    return window.Laravel.url + '/' + thumbnail;
                }
                return window.Laravel.url + '/public/audio_wave.jpg';
            }

        },
        mounted() {
            this.getPortfolio();
        }
    }
</script>
