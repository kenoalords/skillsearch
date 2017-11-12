<template>
    <div>
        <div class="ui centered grid">
            <portfolio-item v-for="portfolio in portfolios" :data="portfolio" :key="portfolio.uid"></portfolio-item>
        </div>  
        <div class="ui center aligned column" style="margin: 2em 0">
            <a href="#" @click.prevent="load" class="ui button" :class="{'loading' : isLoading}">Load more</a>
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
            };
        },

        props: {
            data: null,
        },

        methods: {
            load: function(){
                var _this = this;
                this.isLoading = true;
                axios.get('/load-portfolio/'+this.page+'/'+this.limit).then( (response) => {
                    _this.isLoading = false;
                    response.data.forEach( function(value, key) {
                        _this.portfolios.push(value);
                    });
                    _this.page++;
                }).catch( (error) => {
                    _this.isLoading = false;
                    iziToast.error({ title : 'No more results!' })
                    // console.log(error);
                });
            }
        },

        mounted() {
            this.load();
        }
    }
</script>
