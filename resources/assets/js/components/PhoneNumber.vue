<template>
    <span>
        <a class="ui green icon labeled button phone-number" v-on:click.prevent="showNumber" :class="{'mini' : mini}">
            <i class="icon phone"></i>
            <span>{{text}}</span>
        </a>
    </span>
</template>

<script>
    export default {
        data(){
            return{
                text: 'XXX-SHOW-PHONE',
                phone: this.number,
            }
        },

        props: {
            number: null,
            mini: false,
        },

        methods: {
            showNumber: function(){
                this.text = this.phone;
            }
        },

        mounted() {
            
        }
    }
</script>
