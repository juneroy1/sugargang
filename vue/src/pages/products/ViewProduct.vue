<template>
    <div>
        <b-container class="container d-flex justify-content-center align-items-center mt-5">
            <b-row>
                <b-col>
                    <div class="w-100">
                        <b-card v-if="showDetails" :img-src="'https://' + data.image"
                            class="d-flex justify-content-start align-items-center" img-alt="Card image" img-left>
                            <b-card-text @mouseover="isHovered = true" style="text-align: left;">
                                <b>Title:</b> {{ data.name }}
                            </b-card-text>
                            <b-card-text style="text-align: left;" class="text-align-left">
                                <b>Price:</b> {{ data.price }}
                            </b-card-text>
                            <b-card-text style="text-align: left;" class="text-align-left">
                                <b>Quantity:</b> {{ data.quantity }}
                            </b-card-text>
                            <b-card-text style="text-align: left;" class="text-align-left">
                                <b>Ingredients:</b>{{ data.ingredients }}
                            </b-card-text>
                            <b-card-text style="text-align: left;" class="text-left">
                                <b>SKU:</b> {{ data.sku }}
                            </b-card-text>
                            <transition name="fade">
                                <div v-if="isHovered" :class="['d-flex', { 'hovered': isHovered }]">
                                    <b-button v-b-modal.modal-1 variant="primary">Edit</b-button>
                                </div>
                            </transition>
                            <b-modal id="modal-1" :title="'Update ' + data.name" hide-footer>
                                <b-form @submit="onSubmit">
                                    <b-form-group id="input-group-1" label="Name:" label-for="input-1">
                                        <b-form-input class="mb-4" id="input-1" v-model="data.name" type="text"
                                            placeholder="Enter title" required @input="updateProduct"></b-form-input>


                                    </b-form-group>
                                    <b-form-group id="input-group-1" label="Quantity:" label-for="input-1">
                                        <b-form-input id="input-1" class="mb-4" v-model="data.quantity" type="number"
                                            placeholder="Enter quantity" required @input="updateProduct"></b-form-input>

                                    </b-form-group>

                                    <b-form-group id="input-group-1" label="Ingredients" label-for="input-1">
                                        <b-form-textarea @input="updateProduct" id="input-1" rows="3" max-rows="6"
                                            class="mb-4" v-model="data.ingredients" type="text"
                                            placeholder="Enter ingredients" required></b-form-textarea>
                                    </b-form-group>

                                    <div class="d-flex justify-content-end align-items-center">
                                        <b-button class="mt-4" type="submit" variant="primary">Update</b-button>
                                    </div>
                                </b-form>

                            </b-modal>
                        </b-card>
                        <div v-else>
                            <b-container>
                                <b-row>
                                    <b-col>
                                        <b-spinner variant="primary"></b-spinner>
                                        <p>Fetching data...</p>
                                    </b-col>
                                </b-row>
                            </b-container>

                        </div>
                    </div>
                </b-col>
            </b-row>
        </b-container>
    </div>
</template>

<script>
const apiUrl = 'http://localhost:8000/api'//process.env.VUE_APP_API_URL;

import axios from 'axios';

export default {
    name: "ViewProduct",
    data() {
        return {
            showDetails: false,
            data: null,
            isHovered: false
        }
    },
    methods: {
        onSubmit(event) {
            event.preventDefault()
            axios.put(apiUrl+'/product/' + this.$route.params.id, this.data)
                .then(response => {
                    console.log(response);
                    // if (response.data.result) {
                    //     this.data = response.data.result;
                    //     this.showDetails = true;
                    // }
                    this.$bvModal.hide("modal-1");
                })
                .catch(error => {
                    console.log(error);
                    this.$bvModal.hide("modal-1");
                });
        },
        updateProduct() {
            //    show modal
            console.log('update')
            axios.put(apiUrl+'/product/' + this.$route.params.id, this.data)
                .then(response => {
                    console.log(response);
                    // if (response.data.result) {
                    //     this.data = response.data.result;
                    //     this.showDetails = true;
                    // }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        fetchProduct() {
            axios.get(apiUrl+'/product/' + this.$route.params.id)
                .then(response => {
                    console.log(response);
                    if (response.data.result) {
                        this.data = response.data.result;
                        this.showDetails = true;
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    created() {
        this.fetchProduct();
    }
}

</script>

<style>
.hovered {
    transition: background-color 0.5s ease;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>