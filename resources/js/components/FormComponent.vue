<template>
    <div class="content">
        <label for="amount">Votre budget: </label>
        <input @keyup.enter="onSubmit" type="number" id="amount" v-model.number="amount" placeholder="Entrez un montant" />
        <button @click="onSubmit">Soumettre</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            amount: null
        };
    },
    methods: {
        onSubmit() {
            if (this.amount !== null) {
                this.$emit('submit', this.amount);
                this.amount = null;
            }
        }
    }
}
</script>

<style lang="scss" scoped>
    .content {
        align-items: flex-end;
        display: inline-flex;
        justify-content: flex-start;
        width: 100%;
        column-gap: 5px;
    }
</style>
