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
                    <label>Email:</label>
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
                        <ul style="list-style-type: none; overflow: hidden; margin: 0; padding-left: 0;">
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
                    <div v-if="edit === false">
                        <button type="submit">Add</button>
                    </div>
                    <div v-else>
                        <button type="submit">Update</button>
                        <button type="submit" @click.prevent="clearForm()">Cancel</button>
                    </div>
                </form>
            </div> 
        </div>
        <div class="col">
            <div class="card">
                <h2>Ordered Listing</h2>
                <div class="pagination">
                    <a v-bind:class="[{disabled: !paginations.prev_page_url}]" @click="fetchOrders(paginations.prev_page_url)"><b>Previous</b></a>
                    <a disabled>Page {{ paginations.current_page }} of {{ paginations.last_page }}</a>
                    <a v-bind:class="[{disabled: !paginations.next_page_url}]" @click="fetchOrders(paginations.next_page_url)"><b>Next</b></a>
                </div>
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
                            <ul style="margin: 0; padding-left: 20px;">
                                <li v-for="addon in order.addons">
                                    {{addon.name}}
                                </li>
                            </ul>
                        </td>
                        <td>{{order.delivery_time}}</td>
                        <td>{{order.remarks}}</td>
                        <td>
                            <button @click="editOrder(order)">Edit</button><br><br>
                            <button @click="confirmDelete = true, order_id = order.id">Delete</button>
                            <confirm-modal v-show="confirmDelete" @close-modal="confirmDelete = false, order_id = ''" @confirm-modal="deleteOrder(order_id)"></confirm-modal>
                        </td>
                    </tr>
                </table>
            </div>        
        </div>    
    </div>
</template>

<script>

import axios from 'axios';
import Modal from '../modals/ModalComponent'

export default{
    components:{
        'confirm-modal': Modal
    },
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
            confirmDelete: false,
            paginations: {}
        }
    },
    created(){
        this.fetchOrders();
        this.fetchAddon();
    },
    methods: {
        fetchOrders(pageId){
            var vm = this;
            let page_url = pageId || '/orders'
            axios.get(page_url)
            .then(res => {
                vm.orderData = res.data.data;
                vm.makePagination(res);
            })
            .catch(error => {
                console.log(error);
            })
        },
        makePagination(res) {
            let pagination = {
                current_page: res.data.current_page,
                last_page: res.data.last_page,
                next_page_url: res.data.next_page_url,
                prev_page_url: res.data.prev_page_url
            };
            this.paginations = pagination;
        },
        fetchAddon(){
            var vm = this;
            axios.get('/addon')
            .then(function(data){
                vm.addonData = data.data;
            })
            .catch(error => {
                console.log(error);
            })
        },
        addToCart(){
            if(this.edit === false){
                axios.post('/store/orders', this.orders)
                .then(response => {
                    alert('Order submitted');
                    this.orderData.push(response.data.data);
                    this.clearForm();
                })
                .catch(error => {
                    console.log(error);
                })
            }
            else{
                axios.put('/store/orders', this.orders)
                .then(response => {
                    console.log(response);
                    alert('Order updated');
                    this.fetchOrders();
                    this.clearForm();
                })
                .catch(error => {
                    console.log(error);
                })
            }
        },
        deleteOrder(id){
            console.log(id);
            axios.delete('/orders/' + id)
            .then(response => {
                console.log(response);
                this.confirmDelete = false;
                this.order_id = '';
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
            this.orders.addons = [];
            order.addons.forEach(function(data){
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
.pagination a {
    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    transition: background-color .3s;
    border: 1px solid #ddd;
}
.pagination a:hover:not(.active) {
    background-color: #ddd;
}
.disabled{
    pointer-events: none;
    background-color: #ccc;
}
</style>