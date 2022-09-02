<template>
    <div class="col">
        <div class="card">
            <pre></pre>
            <form @submit.prevent="addToCart()">
                <h2>Order Details</h2>
                <label>Customer name:</label>
                <input type="text" v-model="orders.customer_name" required/><br><br>
                <label>Telephone:</label>
                <input type="number" v-model="orders.customer_contact" required/><br><br>
                <label>Email address:</label>
                <input type="email" v-model="orders.customer_email" required/><br><br>
                <label>Delivery address:</label>
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
                size: '',
                delivery_time: '',
                remarks: '',
                addons: [],
            },
            addonData: []
        }
    },
    created(){
        var vm = this;
        axios.get('/addon')
        .then(function(data){
            vm.addonData = data.data;
        })
    },
    methods: {
        addToCart(){
            axios.post('/store/orders', this.orders).then(
                response => {
                    console.log(response);
                    alert('Order submitted');
                },
            )
            .catch(error => {
                console.log('Error');
            })
        },
    }
}
</script>

<style>
ul {
    list-style-type: none;
    padding-left: 0;
}
</style>