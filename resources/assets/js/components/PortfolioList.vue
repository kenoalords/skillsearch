<template>
    <div class="section is-white">
        <div class="container">
            <div class="columns is-multiline is-mobile">
                <portfolio-item v-for="portfolio in portfolios" :data="portfolio" :key="portfolio.uid"></portfolio-item>
            </div> 
        </div>  
        <div class="panel-loader" v-if="isLoading" style="padding:5em 0">
            <span class="spinner"></span>
        </div>
        <div class="hero">
            <div class="hero-body has-text-centered">
                <a href="#" @click.prevent="load" id="auto-loader" class="button is-info has-text-weight-bold" v-if="!isLoading"><span>Load more</span></a>
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
                limit: 16,
                portfolios: [],
                finished: false,
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
                axios.get('/load-portfolio/'+this.page+'/'+this.limit+'/?type='+this.type).then( (response) => {
                    _this.isLoading = false;
                    _this.page++;
                    response.data.forEach( function(value, key) {
                        _this.portfolios.push(value);
                    });
                    
                }).catch( (error) => {
                    _this.isLoading = false;
                    // iziToast.error({ title : 'No more results!' })
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
