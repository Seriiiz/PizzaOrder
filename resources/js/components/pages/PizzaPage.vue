<template>
    <div class="container">
        <div class="col">
            <div class="card">
                <form @submit.prevent="addToCart()">
                    <h2>Order Details</h2>
                    <label>Name:</label>
                    <input type="text" v-model="orders.customer_name" required/><br><br>
                    <label>Telephone:</label>
                    <input type="number" v-model="orders.customer_contact" required/><br><br>
                    <label>Email address:</label>
                    <input type="email" v-model="orders.customer_email" required/><br><br>
                    <label>Address:</label>
                    <input type="text" v-model="orders.customer_address" required/><br><br>
                    <fieldset>
                        <legend>Flavors</legend>
                        <input type="radio" name="flavor" value="Cheesy" v-model="orders.flavor" required><label>Cheesy</label><br>
                        <input type="radio" name="flavor" value="Hawaiian" v-model="orders.flavor"><label>Hawaiian</label><br>
                        <input type="radio" name="flavor" value="Pepperoni" v-model="orders.flavor"><label>Pepperoni</label><br>
                    </fieldset><br>
                    <fieldset>
                        <legend>Sizes</legend>
                        <input type="radio" name="size" value="Small" v-model="orders.size" required><label>Small</label><br>
                        <input type="radio" name="size" value="Medium" v-model="orders.size"><label>Medium</label><br>
                        <input type="radio" name="size" value="Large" v-model="orders.size"><label>Large</label><br>
                    </fieldset><br>
                    <fieldset>
                        <legend>Addons</legend>
                        <ul>
                            <li v-for="addon in addonData">
                                <input type="checkbox" name="addon" :value="addon.id" v-model="orders.addons">
                                <label>{{addon.name}}</label>
                            </li>
                        </ul>
                    </fieldset><br>
                    <label>Preferred delivery time:</label>
                    <input type="time" v-model="orders.delivery_time" required/><br><br>
                    <label>Delivery instruction:</label>
                    <textarea v-model="orders.remarks" required></textarea><br><br>
                    <button type="submit">Submit</button>
                </form>
            </div> 
        </div>
        <div class="col">
            <div class="card">
                <h2>Ordered Listing</h2>
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
                            <button @click="editOrder(order)">Edit</button><br><br>
                            <button @click="deleteOrder(order.id)">Delete</button>
                        </td>
                    </tr>
                </table>
            </div>        
        </div>        
    </div>
</template>

<script>

import axios from 'axios';

export default{
    data() {
        return{
            orders:{
                customer_name: '',
                customer_contact: '',
                customer_email: '',
                customer_address: '',
                flavor: '',
                size: '',
                delivery_time: '',
                remarks: '',
                addons: [],
            },
            order_id: '',
            edit: false,
            addonData: [],
            orderData: [],
        }
    },
    created(){
        this.fetchOrders();
        this.fetchAddon();
    },
    methods: {
        fetchOrders(){
            var vm = this;
            axios.get('/orders')
            .then(function(data){
                vm.orderData = data.data;
            })
        },
        fetchAddon(){
            var vm = this;
            axios.get('/addon')
            .then(function(data){
                vm.addonData = data.data;
            })
        },
        addToCart(){
            if(this.edit === false){
                axios.post('/store/orders', this.orders).then(
                    response => {
                        console.log(response);
                        alert('Order submitted');
                        this.fetchOrders();
                        this.clearForm();
                    },
                )
                .catch(error => {
                    console.log(error);
                })
            }
            else{
                axios.put('/store/orders', this.orders).then(
                    response => {
                        console.log(response);
                        alert('Order updated');
                        this.fetchOrders();
                        this.clearForm();
                    },
                )
                .catch(error => {
                    console.log(error);
                })
            }
        },
        deleteOrder(id){
            axios.delete('/orders/' + id)
            .then(response => {
                alert('Order deleted');
                console.log(response);
                this.fetchOrders();
            })
            .catch(error => {
                console.log(error)
            })
        },
        editOrder(order){
            var vm = this;
            this.edit = true;
            this.orders.order_id = order.id;
            this.orders.customer_name = order.customer_name;
            this.orders.customer_contact = order.customer_contact;
            this.orders.customer_email  = order.customer_email;
            this.orders.customer_address = order.customer_address;
            this.orders.size = order.size;
            this.orders.flavor = order.flavor;
            this.orders.delivery_time = order.delivery_time;
            this.orders.remarks = order.remarks;
            order.addons.forEach(function(data, id){
                vm.orders.addons.push(data.pivot.addon_id);
            });
        },
        clearForm(){
            this.edit = false;
            this.orders.order_id = null;
            this.orders.customer_name = '';
            this.orders.customer_contact = '';
            this.orders.customer_email = '';
            this.orders.customer_address = '';
            this.orders.size = '';
            this.orders.flavor = '';
            this.orders.delivery_time = '';
            this.orders.remarks = '';
            this.orders.addons = [];
        }
    }
}
</script>

<style scoped>
.container{
    display: flex;
    flex-wrap: nowrap;
    width: 100%;
}
.card{
    border: 1px solid black;
    padding: 20px;
}
.col {
    float: left;
    padding: 10px;
    height: auto;
}
table {
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #ddd;
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
    padding-left: 0;
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