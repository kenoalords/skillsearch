<template>
    <div class="portfolio-tabs">
        <div class="section is-white">
            <div class="container">
                <div class="tabs is-fullwidth">
                    <ul>
                        <li><a href="javascript:;" @click.prevent="getPortfolioByCategory('Photography')">Photography</a></li>
                        <li><a href="javascript:;" @click.prevent="getPortfolioByCategory('Makeup Artist')">Makeup Artist</a></li>
                        <li><a href="javascript:;" @click.prevent="getPortfolioByCategory('Graphics Designer')">Graphics Designer</a></li>
                        <li><a href="javascript:;" @click.prevent="getPortfolioByCategory('Website Developer')">Website Designer</a></li>
                        <li><a href="javascript:;" @click.prevent="getPortfolioByCategory('Branding')">Branding</a></li>
                        <li><a href="javascript:;" @click.prevent="getPortfolioByCategory('Advertising')">Advertising</a></li>
                    </ul>
                </div>
                <h2 v-if="title" class="title is-4">{{ title }}</h2>
                <div class="columns is-multiline is-mobile">
                    <portfolio-item v-for="portfolio in portfolios" :data="portfolio" :key="portfolio.uid"></portfolio-item>
                </div>
            </div>
            <div class="panel-loader" v-if="isLoading" style="padding:5em 0">
                <span class="spinner"></span>
            </div>
            <div class="hero" v-if="portfolios.length > 0 && category != ''">
                <div class="hero-body has-text-centered">
                    <a :href="moreLink" class="button is-info is-fullwidth-mobile"><span>View more</span></a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {

        data() {
            return {
                isLoading : false,
                page: 0,
                limit: 36,
                portfolios: [],
                finished: false,
                duration: 0,
                category: '',
                moreLink: null,
                title: null,
            };
        },

        props: {
            data: null,
            type: String,
        },

        methods: {
            load: function(){
                var _this = this;
                this.isLoading = true;
                this.loadPortfolios();
            },
            getPortfolioByCategory(category){
                let _this = this;
                    _this.isLoading = true;
                    _this.portfolios = [];
                    _this.category = category;
                _this.loadPortfolios(category);
                console.log(_this);
            },
            loadPortfolios(category=''){
                let _this = this;
                axios.get('/load-portfolio/?category='+category).then( (response) => {
                    _this.isLoading = false;
                    _this.portfolios = [];
                    if ( _this.category !== '' ){
                        _this.moreLink = '/search/?term='+ category;
                        _this.title = category;
                    }
                    response.data.portfolios.forEach( function(value, key) {
                        _this.portfolios.push(value);
                    });
                }).catch( (error) => {
                    _this.isLoading = false;
                    _this.finished = true;
                });
            }
        },

        mounted() {
            var $this = this;
            $this.load();
        }
    }
</script>
