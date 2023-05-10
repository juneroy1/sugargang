<template>
    <div>
        <b-container>
            <b-row>
                <b-col sm="12" md="12" lg="12">
                    <bar-chart v-if="showchart" :chart-data="chartData" :options="chartOptions"></bar-chart>
                </b-col>
                <b-col sm="12" md="12" lg="12">
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
const apiUrl = 'http://localhost:8000/api'//process.env.VUE_APP_API_URL;
import BarChart from '../../components/BarChart.vue'
import axios from 'axios';


export default {
    components: {
        BarChart
    },
    data() {
        return {
            showchart: false,
            data: [],
            currentPage: 1,
            totalPages: 1,
            chartData: {
                // labels: ['Product 1', 'Product 2', 'Product 3', 'Product 4'],
                labels: [],
                datasets: [
                    {
                        label: 'Quantity',
                        backgroundColor: '#f87979',
                        // data: [10, 20, 30, 40]
                        data: []
                    }
                ]
            },
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false
            }
        }
    }, methods: {
        fetchData() {
            this.showchart = false;
            axios.get(apiUrl+'/products?page=' + this.currentPage)
                .then(response => {
                    console.log(response.data.data);
                    if (response.data.data) {
                        this.data = response.data.data;
                        this.totalPages = response.data.last_page;
                        this.showchart = true;
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
    watch: {
        data() {
            if (this.data.length > 0) {
                this.chartData.labels = [];
                this.chartData.datasets[0].data = [];
                this.data.forEach(element => {
                    this.chartData.labels.push(element.name);
                    this.chartData.datasets[0].data.push(element.quantity);
                });
            } else {
                this.chartData.labels = [];
                this.chartData.datasets[0].data = [];
            }
        }
    },
    created() {
        this.fetchData();
    }
}
</script>
  