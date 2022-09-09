<template>
    <transition name="modal-fade">
        <div class="modal-overlay" @click="$emit('close-modal')">
            <div class="modal" @click.stop>
                <h6>Delete Order</h6>
                <p>Are you sure?</p>
                <button @click="$emit('confirm-modal')">Confirm</button>
                <button @click="$emit('close-modal')">Cancel</button>
            </div>
        </div>
    </transition>
</template>

<script>
export default{
    //
}
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
    background-color: #000000da;
}
.modal {
    text-align: center;
    background-color: white;
    height: 150px; 
    width: 400px;
    margin-top: 10%;
    border-radius: 20px;
}
.close {
    margin: 10% 0 0 16px;
    cursor: pointer;
}
.close-img {
    width: 25px;
}
.check {
    width: 150px;
}
h6 {
    font-weight: 500;
    font-size: 28px;
    margin: 20px 0;
}
p {
    font-size: 16px;
    margin: 20px 0;
}
.modal-fade-enter,
.modal-fade-leave-to {
    opacity: 0;
}
.modal-fade-enter-active,
.modal-fade-leave-active {
    transition: opacity 0.5s ease;
}
button{
    margin: 0 10px;
}
</style>