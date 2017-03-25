<template>
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></div>
            <input type="text" list="locations" id="location" v-on:keyup="getLocationInput" class="form-control" placeholder="City, State e.g Lekki, Lagos" v-model="location" autocomplete="off" v-on:blur="focusOut">

            <datalist id="locations" v-if="cities">
                <select name="locations" class="form-control">
                    <option v-for="list in cities">
                       <i class="glyphicon glyphicon-map-marker"></i> {{ list.city }}, {{ list.name }}
                    </option>
                </select>
            </datalist>
        </div>
    </div>
</template>

<script>
    export default {

        data: function() {
            return {
                location: this.currentLocation,
                cities: {},
            }
        },

        props: {
            currentLocation : null
        },

        methods: {

            getLocationInput: function(event){
                var _this = this;

                if(this.location.length > 1){
                    axios
                        .get('/autocomplete_cities/'+this.location)
                        .then(function(response){
                            _this.cities = response.data;
                    });
                    
                }
            },

            focusOut: function(event){
                document.getElementById('user_location').value = this.location
            }

        },

        mounted() {
            
        }
    }
</script>
