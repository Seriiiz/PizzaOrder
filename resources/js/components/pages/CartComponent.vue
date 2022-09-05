<template>
    <div class="col">
        <div class="card">
            <h2>Ordered Listing</h2>
            <hr>
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
                    <th>Action</th>
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
                                {{addon.name}}
                            </li>
                        </ul>
                    </td>
                    <td>{{order.delivery_time}}</td>
                    <td>{{order.remarks}}</td>
                    <td>
                        <button @click="editOrder(orderData)">Edit</button><br><br>
                        <button @click="deleteOrder(order.id)">Delete</button>
                    </td>
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
        deleteOrder(id){
            axios.delete('/orders/' + id)
            .then(response => {
                alert('Order deleted');
                console.log(response);
            })
            .catch(error => {
                console.log(error)
            })
        },
        editOrder(orderData){
            console.log(orderData);
        }
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

ul{
    list-style-type: none;
    overflow: hidden;
    margin: 0;
}

.col {
    float: left;
    width: 63.33%;
    padding: 10px;
    height: auto;
}
.card{
    border: 1px solid black;
    padding: 20px;
}
.btn-primary{
    background-color: blue;
    border-color: white;
    color: white;
    padding: 5px;
}
.btn-danger{
    background-color: red;
    border-color: white;
    color: white;
    padding: 5px;
}
</style>