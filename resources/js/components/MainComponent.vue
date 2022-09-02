<template>
    <div>
        <order-component></order-component>
        <cart-component></cart-component>
    </div>
</template>

<script>
import Order from './pages/OrderComponent.vue';
import Cart from './pages/CartComponent.vue';

export default{
    components: {
        'order-component': Order,
        'cart-component': Cart
    },
    data() {
        return{
            //
        }
    },
    methods: {
        //
    }
}
</script>