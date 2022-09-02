<template>
    <div class="col">
        <div class="card">
            <h2>Ordered Pizza</h2>
            <hr>
            <pre>{{ orderData }}</pre>
            <table>
                <tr>
                    <th>Customer Name</th>
                    <th>Customer Number</th>
                    <th>Customer Email</th>
                    <th>Delivery Address</th>
                    <th>Flavor</th>
                    <th>Size</th>
                    <th>Addon</th>
                    <th>Delivery Time</th>
                    <th>Instruction</th>
                </tr>
                <tr v-for="order in orderData">
                    <td>{{order.customer_name}}</td>
                    <td>{{order.customer_contact}}</td>
                    <td>{{order.customer_email}}</td>
                    <td>{{order.customer_address}}</td>
                    <td>{{order.flavor}}</td>
                    <td>{{order.size}}</td>
                    <td>
                        <ul>
                            <li v-for="addon in order.addons">
                                {{addon.addon_id}}
                            </li>
                        </ul>
                    </td>
                    <td>{{order.delivery_time}}</td>
                    <td>{{order.remarks}}</td>
                </tr>
            </table>
        </div>        
    </div>
</template>

<script>
import axios from 'axios';

export default{
    data() {
        return{
            orderData: [],
        }
    },
    created(){
        var vm = this;
        axios.get('/orders')
        .then(function(data){
            vm.orderData = data.data;
        })
    },
    methods: {
        //
    }
}
</script>

<style scoped>
table {
    border-collapse: collapse;
    width: 100%;
}

td, th {
    text-align: left;
    padding: 8px;
}

tr:nth-child() {
    background-color: #dddddd;
}

.col {
    float: left;
    width: 63.33%;
    padding: 10px;
    height: auto;
}
</style>