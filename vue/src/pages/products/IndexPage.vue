
<template>
    <!-- eslint-disable-next-line -->
    <div>
        <b-container class="container-fluid mt-5">
            <b-row>
                <!-- {{ process.env.VUE_APP_API_URL }} -->
                <b-col sm="12" md="12" lg="12">
                    <b-input-group prepend="search" class="mb-4 mr-sm-2 mb-sm-4">
                        <b-form-input v-model="search" @input="fetchData" id="inline-form-input-username" placeholder="e.g name"></b-form-input>
                    </b-input-group>
                </b-col>
                <b-col :key="index" class="d-flex justify-content-center align-items-center" sm="12" md="12" lg="6"
                    v-for="(product, index) in data">
                    <b-card :title="product.name" :img-src="'https://' + product.image" img-alt="Image" img-top
                        tag="article" style="max-width: 20rem;" class="mb-2 text-center">
                        <b-card-text>
                            {{ product.price }}
                        </b-card-text>

                        <b-button @click="viewpage(product._id)" variant="primary">View</b-button>
                    </b-card>
                </b-col>
                <b-col>
                    <div class="my-5 d-flex justify-content-center align-items-center">
                        <b-button variant="primary" @click="previousPage">Previous</b-button>
                        <span>Page {{ currentPage }} of {{ totalPages }}</span>
                        <b-button variant="primary" @click="nextPage">Next</b-button>
                    </div>
                </b-col>
            </b-row>
        </b-container>
    </div>
</template>

<script>
/* eslint-disable */
const apiUrl = 'http://localhost:8000/api'//process.env.VUE_APP_API_URL;
import axios from 'axios';
export default {
    name: "IndexPage",
    data() {
        return {
            search: "",
            data: [],
            currentPage: 1,
            totalPages: 1,
        }
    },
    methods: {
        viewpage(id) {
            this.$router.push({ path: '/product/' + id });
        },
        fetchData() {
            axios.get(apiUrl+'/products?page=' + this.currentPage+'&search='+this.search)
                .then(response => {
                    console.log(response.data.data);
                    if (response.data.data) {
                        this.data = response.data.data;
                        this.totalPages = response.data.last_page;
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.fetchData();
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                this.fetchData();
            }
        }
    },
    computed: {

    },
    created() {
        this.fetchData();
    }
}

</script>