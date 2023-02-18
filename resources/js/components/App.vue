<template>
    <div>
        <form-component @submit="onFormSubmit"></form-component>
        <quote-component :quote-prop="quote"></quote-component>
    </div>
</template>

<script>
import FormComponent from "./FormComponent.vue";
import QuoteComponent from "./QuoteComponent.vue";

export default {
    components: {
        "form-component": FormComponent,
        "quote-component": QuoteComponent,
    },
    data() {
        return {
            quote: {
                budget: 0,
                entreposage: 0,
                utilisation: 0,
                association: 0,
                vendeur: 0,
                value: 0,
            },
        };
    },
    methods: {
        async onFormSubmit(amount) {
            const result = await axios({
                method: "get",
                url: "/api/quote/",
                params: {
                    budget: amount
                }
            });
            this.quote = result.data;
        }
    }
}
</script>

<style scoped>

</style>
