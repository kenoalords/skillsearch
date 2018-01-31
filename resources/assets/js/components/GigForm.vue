<template>
    <div class="ui centered grid">
        <div class="sixteen wide mobile sixteen wide tablet ten wide computer column">
            <h1 class="title is-3">Sell a new service</h1>
            <div class="level is-mobile steps">
                <div class="level-item" :class="{'active' : step === 1}">
                    <div class="title is-6"><i class="fa fa-file-text"></i></div>
                </div>
                <div class="level-item" :class="{'active' : step === 2}">
                    <div class="title is-6"><i class="fa fa-image"></i></div>
                </div>
                <div class="level-item" :class="{'active' : step === 3}">
                    <div class="title is-6"><i class="fa fa-info-circle"></i></div>
                </div>
                <div class="level-item" :class="{'active' : step === 4}">
                    <div class="title is-6"><i class="fa fa-shopping-bag"></i></div>
                </div>
            </div>
            
            <form id="gigform" :class="{'loading' : isLoading}">
                <transition name="scale">
                    <div id="step1" class="card is-raised" v-if="step === 1">
                        <div class="card-content">
                            <div class="field">
                                <label class="label">Select a skill</label>
                                <div class="select is-block">
                                    <select v-model="gig.category" style="width: 100%" @change="checkInputValues($event)">
                                        <option :value="category.skill" v-text="category.skill" v-for="category in categories"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="field has-addons" id="service-title">
                                <p class="control">
                                    <a class="button is-static has-text-weight-bold is-large">I will </a>
                                </p>
                                <div class="control is-expanded">
                                    <input type="text" placeholder="do your makeup for free" v-model.trim="gig.title" @keyup="checkInputValues" class="input is-large">
                                </div>
                            </div>
                            <div class="field">
                                <label for="" @click="hasDescription = true" v-if="!hasDescription">
                                    <a @click.prevent="">
                                        <span class="icon"><i class="fa fa-plus"></i></span> <span>Add a description (optional)</span>
                                    </a>
                                </label>
                                <textarea rows="3" class="textarea" placeholder="Description (Optional)" v-model="gig.description" v-if="hasDescription"></textarea>
                            </div>

                            <div class="field is-grouped">
                                <div class="control">
                                    <label for="regular_price" class="label">Regular price</label>
                                    <input id="regular_price" type="number" placeholder="Regular price (optional)" v-model.number="gig.regular_price" @keyup="checkInputValues($event)" class="input">
                                    <small>How much do you normally charge?</small>
                                </div>
                                <div class="control">
                                    <label for="sale_price" class="label">Your sale price</label>
                                    <input id="sale_price" type="number" placeholder="Sale price" v-model.number="gig.sale_price" @keyup="checkInputValues($event)" class="input">
                                    <small>How much are you selling?</small>
                                </div>
                            </div>
                            <div class="field">
                                <div class="">
                                    <h2 id="discount-ribbon" class="ui orange huge ribbon label" v-html="pecentage" v-if="pecentage"></h2>
                                    <button class="button is-primary" v-on:click.prevent="goto(2)" :disabled="!stepOneComplete">
                                        <span>Upload image</span> <span class="icon"><i class="fa fa-arrow-right"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End step 1 -->
                </transition>
                
                <transition name="scale">
                    <div id="step2" class="card is-raised" v-if="step === 2">
                        <div class="card-content">
                            <h3 class="title is-4">Upload service banner</h3>
                            <h4 class="subtitle is-6">A well designed image can increase your sales by up to 28%</h4>
                            <div class="field" id="thumbnail-wrapper">
                                <label v-show="!hasImage" class="button is-primary">
                                    <input type="file" id="thumbnail" style="display:none" @change.prevent="handleFileUpload($event)">
                                    <span class="icon"><i class="fa fa-upload"></i></span>
                                    <span class="title is-6 has-text-white">Upload sales banner</span>
                                </label>
                                <div id="preview-final-image"></div>
                                <div class="modal" id="image-preview-modal" v-if="hasImage" :class="{'is-active' : hasImage }">
                                    <div class="modal-background"></div>
                                    <div class="modal-content">
                                        <div id="preview"></div>
                                        <div class="card is-raised" style="padding: 10px">
                                            <a class="button is-white" @click.prevent="closeOverlay">Cancel</a>
                                            <a @click.prevent="cropImage()" class="button is-primary">Crop &amp; save</a>
                                        </div>
                                    </div>
                                    <button class="modal-close is-large" aria-label="close" @click.prevent="closeOverlay"></button>
                                </div>
                            </div>
                            <div class="field">
                                <hr style="opacity: .5">
                                <div>
                                    <a @click.prevent="goto(1)" class="button is-grey"><span class="icon"><i class="fa fa-arrow-left"></i></span> <span>Back</span></a>
                                    <button class="button is-primary" v-on:click.prevent="goto(3)" :disabled="!hasImageUploaded">
                                        <span>Next</span> <span class="icon"><i class="fa fa-arrow-right"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End step 2 -->
                </transition>

                <transition name="scale">
                    <div id="step3" class="card is-raised" v-if="step === 3">
                        <div class="card-content">
                            <div class="field">
                                <h3 class="title is-4">
                                    Additional Information
                                </h3>
                                <div class="subtitle is-6">You can provide additional information about this service</div>
                            </div>
                            <div class="field">
                                <label for="delivery_time" class="label">How long will it take you to deliver this service? (in days)</label>
                                <div class="control">
                                    <input type="number" v-model.number="gig.delivery_time" id="delivery_time" class="input" style="max-width: 300px">
                                </div>
                            </div>
                            <div class="field">
                                <label for="location" class="label">Can people outside you primary location buy this service?</label>
                                <div class="select">
                                    <select id="location" v-model="gig.is_local">
                                        <option value="">Select</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="field">
                                <button class="button is-primary" v-on:click.prevent="goto(4)">
                                    <span>Review service</span> <span class="icon"><i class="fa fa-arrow-right"></i></span>
                                </button>
                            </div>
                        </div>
                    </div> <!-- End step 3 -->
                </transition>
                
                <transition name="scale">
                    <div id="step4" class="card is-raised" v-if="step === 4">
                        <div class="card-content">
                            <h3 class="title is-4">Review your service</h3>
                            <div class="columns">
                                <div class="column is-5">
                                    <figure class="image">
                                        <img :src="thumbnailPreview">
                                    </figure>
                                </div>
                                <div class="column is-7">
                                    <h1 class="title is-3" v-html="'I will ' + gig.title"></h1>
                                    <div class="tag is-info" v-html="gig.category"></div>
                                    <p class="description" v-html="gig.description" v-if="gig.description"></p>
                                    <div class="extra">
                                        <div>
                                            <h3 class="title is-3 has-text-danger" v-html="gig.sale_price.toLocaleString('en-UK', { style: 'currency', currency: 'NGN' })"></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr style="opacity: .5">
                            <div class="ui row">
                                <button class="button is-primary" @click.prevent="submitService(1)" :class="{'is-loading' : isSubmitting}">Publish service</button>
                                <button class="button is-white" @click.prevent="submitService(0)">Save</button>
                            </div>
                        </div>
                    </div>
                </transition>
                <div class="ui mini modal" id="error-message">
                    <div class="header"><i class="icon warning"></i>Error</div>
                    <div class="content" v-html="errorMessage"></div>
                    <div class="actions">
                        <a href="#" class="ui approve icon right labeled green button">
                            Got it <i class="icon check"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import Cropper from 'cropperjs';
    export default {
        data(){
            return {
                step: 1,
                gig: [],
                categories: JSON.parse(this.skills),
                stepOneComplete: false,
                hasDescription: false,
                pecentage: null,
                hasImage: false,
                isLoading: false,
                hasError: false,
                errorMessage: null,
                thumbnail: null,
                thumbnailPreview: null,
                isCropped: false,
                isCropper: null,
                hasImageUploaded: false,
                isSubmitting: false,
            }
        },

        props: {
            skills: null,
        },

        methods: {
            goto (index) {
                this.step = index;
            },
            checkInputValues(event) {
                if(this.gig.hasOwnProperty('sale_price') && this.gig.hasOwnProperty('regular_price')){
                    const regular = this.gig.regular_price;
                    const sale = this.gig.sale_price;
                    const percent = ( regular - sale ) / regular * 100;
                    this.pecentage = Math.floor(percent) + '% Discount';
                }
                switch(this.step){
                    case 1:
                        if( 
                            (this.gig.hasOwnProperty('title') && this.gig.title.length > 3)
                            && (this.gig.hasOwnProperty('sale_price') && typeof this.gig.sale_price == "number" && this.gig.sale_price > 0) 
                            && (this.gig.hasOwnProperty('regular_price') && typeof this.gig.regular_price == "number" && this.gig.regular_price > this.gig.sale_price )
                            && (this.gig.hasOwnProperty('category'))
                        ) {
                            this.stepOneComplete = true;
                            
                        } else {
                            this.stepOneComplete = false;
                        }
                    break;
                    default:
                        break;
                }
            },
            handleFileUpload(event) {
                const file = event.target.files[0];
                const errorModal = document.getElementById('error-message');
                const $this = this;
                if( !file ){
                    return;
                }
                if (!file.type.startsWith('image/')) { 
                    $this.errorMessage = "Please upload an image file";
                    $(errorModal).modal({
                        closeable: false,
                        onHidden: () => {
                            $this.errorMessage = null;
                        }
                    }).modal('show');
                    return; 
                }
                if ( file.size > 5000000 ) {
                    $this.errorMessage = "Please upload an image lower than 5MB";
                    $(errorModal).modal({
                        closeable: false,
                        onHidden: () => {
                            $this.errorMessage = null;
                        }
                    }).modal('show');
                    return;
                }
                // console.log(file); return;
                $this.isLoading = true;
                $this.hasImage = true;
                const reader = new FileReader();
               
                reader.onload = (evt) => {

                    // const canvas = document.getElementById('preview');
                    // const context = canvas.getContext('2d');
                    const imageWrapper = document.getElementById('preview');

                    const image = new Image();
                    const modal = document.getElementById('image-preview-modal');
                    image.onload = () => {
                        // context.canvas.height = image.height;
                        // context.canvas.width = image.width;
                        // context.drawImage(image, 0, 0);
                        image.classList.add('ui');
                        image.classList.add('fluid');
                        image.classList.add('image');
                        image.setAttribute('id', 'image');
                        imageWrapper.appendChild(image);
                        const imageCropper = document.getElementById('image');
                        const cropper = new Cropper(imageCropper, {
                            aspectRatio: 4 / 3,
                            zoomable: false,
                            guides: true,
                        });
                        $this.isCropper = cropper;
                        // console.log($this.isCropper);
                    }
                    image.src = evt.target.result;
                };
                reader.readAsDataURL(file);
            },

            closeOverlay: function(){
                this.hasImage = false;
                this.isLoading = false;
            },

            cropImage: function(){
                // console.log(this.isCropper);
                const $this = this;
                this.isCropper.getCroppedCanvas({
                    imageSmoothingEnabled: false,
                    imageSmoothingQuality: 'high',
                }).toBlob((blob)=>{
                    const img = document.createElement('img');
                    const url = URL.createObjectURL(blob);
                    img.onload = (e) => {
                        // URL.revokeObjectURL(url)
                    }
                    img.classList.add('image');
                    img.classList.add('is-responsive');
                    img.src = url;
                    $this.isLoading = false;
                    $this.hasImage = false;
                    $this.hasImageUploaded = true;
                    $this.thumbnail = blob;
                    $this.thumbnailPreview = url;
                    document.getElementById('preview-final-image').appendChild(img);
                }, 'image/jpeg', 0.75);
            },

            submitService(status) {
                let form = new FormData();
                const gig = this.gig;
                const $this = this;
                $this.isSubmitting = true;
                form.append('file', new Blob([this.thumbnail], {type: 'image/jpeg'}));
                form.append('title', gig.title);
                form.append('category', gig.category);
                form.append('description', gig.description);
                form.append('regular_price', gig.regular_price);
                form.append('sale_price', gig.sale_price);
                form.append('delivery_time', gig.delivery_time);
                form.append('is_local', gig.is_local);
                form.append('is_public', status);

                // console.log(form);
                axios({
                    method: 'post',
                    data: form,
                    url: '/dashboard/gigs/add',
                    headers: {
                        'Content-Type' : false,
                    }
                }).then( (response) => {
                    $this.isSubmitting = false;
                    iziToast.success({ title : 'Gig submitted successfully!'});
                    window.location.href = window.Laravel.url + '/dashboard/gigs';
                })
            },
        },

        mounted() {
            // console.log(this.skills)
        }
    }
</script>
