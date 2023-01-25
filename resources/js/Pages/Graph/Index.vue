<template>
    <AppLayout title="Graph">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Graph
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-4 sm:px-6">
                    <div class="container">
                        <div class="grid sm:grid-cols-6 grid-cols-2">
                            <div class="left-0 mb-5 p-1">
                                <label for="total"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date</label>
                                <select @change="graphSelect" id="graphSelectDate"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                                    <option value="all">All Time</option>
                                    <option value="day">Last Day</option>
                                    <option value="week">Last Week</option>
                                    <option value="month">Last Month</option>
                                    <option value="year">Last Year</option>
                                </select>
                            </div>
                            <div class="left-0 mb-5 p-1">
                                <label for="total"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sort by</label>
                                <select @change="graphSelect" id="graphSelectType"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                                    <option value="city">Most visited City</option>
                                    <option value="country">Most visited Country</option>
                                    <option value="platform">Most Platform used</option>
                                    <option value="browser">Most Browrser used</option>
                                </select>
                            </div>
                        </div>
                        <Bar v-if="loaded" :data="chartData" />
                    </div>
                </div>
            </div>
        </div>

    </AppLayout>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import AppLayout from "@/Layouts/AppLayout.vue";


import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
import DropDown from "@/Components/Dropdown.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
    name: 'BarChart',
    components: { Bar, AppLayout, DropDown, PrimaryButton },
    data() {
        return {
            loaded: false,
            chartData: null,
            //select: null,
        };
    },
    mounted() {
        this.setSelectedGraph();
    },
    methods: {
        graphSelect(event) {
            this.setSelectedGraph();
        },
        setSelectedGraph() {
            let graphSelectType = document.getElementById("graphSelectType");
            let graphSelectDate = document.getElementById("graphSelectDate");
            this.getTotal(graphSelectDate.value, graphSelectType.value);
        },
        async getTotal(graphSelectDateValue, graphSelectTypeValue) {
            this.loaded = false;
            await this.axios.get(route('graph.get.total', {date:graphSelectDateValue, type:graphSelectTypeValue}))
                .then(response => {
                    this.loaded = true;
                    let customData = {
                        labels: response.data.labels,
                        datasets: [{
                            label: 'Sort by '+response.data.title+'',
                            backgroundColor: 'rgb(31, 41, 55)',
                            borderColor: 'rgb(31, 41, 55)',
                            data: response.data.dataset,
                        }]
                    };
                    this.chartData = customData;
                })
                .catch(error => {
                    return null;
                })
        },
        /*         data: function () {
                    let customData
                    return customData = {
                        labels: this.labels,
                        datasets: [{
                            label: 'My First dataset',
                            backgroundColor: 'rgb(255, 99, 132)',
                            borderColor: 'rgb(255, 99, 132)',
                            data: this.datasets,
                        }]
                    };
                },
                labelAarray() {
                    let labels;
                    return labels = [
                        'January',
                        'February',
                        'March',
                        'April',
                        'May',
                        'June',
                    ];
                },
                datasetArray() {
                    let data;
                    return data = [0, 10, 5, 2, 20, 30, 45, 11];
                }, */
    },
}

</script>

<style>

</style>
