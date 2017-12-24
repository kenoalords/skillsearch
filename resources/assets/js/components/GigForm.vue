<template>
    <div class="ui centered grid">
        <div class="sixteen wide mobile sixteen wide tablet ten wide computer column">
            <h1 class="ui header">Sell a new service</h1>
            <div class="ui fluid steps">
                <div class="step" :class="{'active' : step === 1}">
                    <div class="content">
                        <div class="title">Service details</div>
                    </div>
                </div>
                <div class="step" :class="{'active' : step === 2}">
                    <div class="content">
                        <div class="title">Image upload</div>
                    </div>
                </div>
                <div class="step" :class="{'active' : step === 3}">
                    <div class="content">
                        <div class="title">Additional info</div>
                    </div>
                </div>
                <div class="step" :class="{'active' : step === 4}">
                    <div class="content">
                        <div class="title">Review</div>
                    </div>
                </div>
            </div>
            
            <form class="ui form" id="gigform" :class="{'loading' : isLoading}">
                <transition name="scale">
                    <div id="step1" class="step white-boxed" v-if="step === 1">
                        <div class="field">
                            <label for="">Choose a category</label>
                            <select v-model="gig.category" class="ui search dropdown" @change="checkInputValues($event)">
                                <option value="" class="default text">Category</option>
                                <option :value="category.skill" v-text="category.skill" v-for="category in categories"></option>
                            </select>
                        </div>
                        <div class="field" id="service-title">
                            <label for="">Title</label>
                            <div class="ui huge input">
                                <input type="text" placeholder="do your makeup for free" v-model.trim="gig.title" @keyup="checkInputValues">
                            </div>
                        </div>
                        <div class="field">
                            <label for="" @click="hasDescription = true" v-if="!hasDescription">
                                <a @click.prevent="">
                                    <i class="icon plus"></i>Add a description (optional)
                                </a>
                            </label>
                            <textarea rows="3" placeholder="Description (Optional)" v-model="gig.description" v-if="hasDescription"></textarea>
                        </div>

                        <div class="two fields">
                            <div class="field">
                                <label for="regular_price">Regular price</label>
                                <input id="regular_price" type="number" placeholder="Regular price (optional)" v-model.number="gig.regular_price" @keyup="checkInputValues($event)">
                                <small>How much do you normally charge?</small>
                            </div>
                            <div class="field">
                                <label for="sale_price">Your sale price</label>
                                <input id="sale_price" type="number" placeholder="Sale price" v-model.number="gig.sale_price" @keyup="checkInputValues($event)">
                                <small>How much are you selling?</small>
                            </div>
                        </div>
                        <div class="field">
                            <div class="">
                                <h2 id="discount-ribbon" class="ui orange huge ribbon label" v-html="pecentage" v-if="pecentage"></h2>
                                <button class="ui button green right floated" v-on:click.prevent="goto(2)" :disabled="!stepOneComplete">
                                    Upload image <i class="icon arrow right"></i>
                                </button>
                            </div>
                        </div>
                    </div> <!-- End step 1 -->
                </transition>
                
                <transition name="scale">
                    <div id="step2" class="step white-boxed" v-if="step === 2">
                        <h3 class="ui centered header">
                            Upload service banner
                            <div class="sub header"><i class="icon info"></i>A well designed image can increase your sales by up to 28%</div>
                        </h3>
                        <div class="field" id="thumbnail-wrapper">
                            <label v-show="!hasImage">
                                <input type="file" id="thumbnail" style="display:hidden" @change.prevent="handleFileUpload($event)">
                            </label>
                            <div id="preview-final-image"></div>
                            <div class="ui modal" id="image-preview-modal" v-if="hasImage">
                                <div class="header">Resize and crop image</div>
                                <div class="scrolling content">
                                    <div id="preview"></div>
                                </div>
                                <div class="actions">
                                    <a href="#" class="ui deny button">Cancel</a>
                                    <a href="#" class="ui approve green button">Crop &amp; save</a>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="">
                                <a @click.prevent="goto(1)" class="bold" style="display: inline-block; margin-top: 0.5em"><i class="icon arrow left"></i> Back</a>
                                <button class="ui green button right floated" v-on:click.prevent="goto(3)" :disabled="!hasImage">
                                    Next <i class="icon arrow right"></i>
                                </button>
                            </div>
                        </div>
                    </div> <!-- End step 2 -->
                </transition>

                <transition name="scale">
                    <div id="step3" class="step white-boxed" v-if="step === 3">
                        <div class="field">
                            <h3 class="ui header">
                                Additional Information
                                <div class="sub header">You can provide additional information about this service</div>
                            </h3>
                        </div>
                        <div class="field">
                            <label for="delivery_time">How long will it take you to deliver this service?</label>
                            <div class="ui right labeled input">
                                <input type="number" v-model.number="gig.delivery_time" id="delivery_time">
                                <div class="ui label">Days</div>
                            </div>
                        </div>
                        <div class="field">
                            <label for="location">Can people outside you primary location buy this service?</label>
                            <select id="location" v-model="gig.is_local" class="ui dropdown">
                                <option value="">Select</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="field">
                            <button class="ui button green right floated" v-on:click.prevent="goto(4)">
                                Review service <i class="icon arrow right"></i>
                            </button>
                        </div>
                    </div> <!-- End step 3 -->
                </transition>
                
                <transition name="scale">
                    <div id="step4" class="step white-boxed" v-if="step === 4">
                        <div id="discount-ribbon" class="ui huge orange ribbon label" v-html="pecentage" v-if="pecentage"></div>
                        <h3 class="ui header">Review your service</h3>
                        <div class="ui items">
                            <div class="item">
                                <div class="image">
                                    <img :src="thumbnailPreview">
                                </div>
                                <div class="middle aligned content">
                                    <div class="ui big header" v-html="'I will ' + gig.title"></div>
                                    <div class="meta" v-html="gig.category"></div>
                                    <div class="description" v-html="gig.description" v-if="gig.description"></div>
                                    <div class="extra">
                                        <div class="left floated">
                                            <h3 class="ui red header" v-html="gig.sale_price.toLocaleString('en-UK', { style: 'currency', currency: 'NGN' })"></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ui divider"></div>
                        <div class="ui row">
                            <button class="ui green button right floated" @click.prevent="submitService(1)">Publish service</button>
                            <button class="ui button" @click.prevent="submitService(0)">Save</button>
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
                        $(modal).modal({
                            closable: false,
                            onDeny: () => {
                                $this.hasImage = false;
                                $this.isLoading = false;
                            },
                            onApprove: () => {
                                const newImage = cropper.getCroppedCanvas({
                                    imageSmoothingEnabled: false,
                                    imageSmoothingQuality: 'high',
                                }).toBlob((blob)=>{
                                    const img = document.createElement('img');
                                    const url = URL.createObjectURL(blob);
                                    img.onload = (e) => {
                                        // URL.revokeObjectURL(url)
                                    }
                                    img.classList.add('ui');
                                    img.classList.add('fluid');
                                    img.classList.add('image');
                                    img.src = url;
                                    $this.isLoading = false;
                                    $this.thumbnail = blob;
                                    $this.thumbnailPreview = url;
                                    document.getElementById('preview-final-image').appendChild(img);
                                }, 'image/jpeg', 0.75);
                                // console.log(newImage);
                            }
                        }).modal('show');
                        
                    }
                    image.src = evt.target.result;
                };
                reader.readAsDataURL(file);
            },
            submitService(status) {
                let form = new FormData();
                const gig = this.gig;
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
                    url: '/profile/gig/add',
                    headers: {
                        'Content-Type' : false,
                    }
                }).then( (response) => {
                    console.log(response);
                })
            },
        },

        mounted() {
            // console.log(this.skills)
        }
    }
</script>
