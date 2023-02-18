<template>
    <div class="content">
        <h4>Soumission</h4>
        <table class="w-25">
            <thead>
                <tr>
                    <th class="w-50 text-end">Frais</th>
                    <th class="w-50 text-end">Valeur</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-end">Entreposage</td>
                    <td class="text-end">{{ formatMoney( quoteProp.entreposage ) }}</td>
                </tr>
                <tr>
                    <td class="text-end">Utilisation de base</td>
                    <td class="text-end">{{ formatMoney( quoteProp.utilisation ) }}</td>
                </tr>
                <tr>
                    <td class="text-end">Association</td>
                    <td class="text-end">{{ formatMoney( quoteProp.association ) }}</td>
                </tr>
                <tr>
                    <td class="text-end">Spécial du vendeur</td>
                    <td class="text-end">{{ formatMoney( quoteProp.vendeur ) }}</td>
                </tr>
            </tbody>

            <tfoot>
                <tr>
                    <td class="text-end">Budget</td>
                    <td class="text-end">{{ formatMoney( quoteProp.budget ) }}</td>
                </tr>
                <tr>
                    <td class="text-end">Valeur du véhicule</td>
                    <td class="text-end">{{ formatMoney( quoteProp.value ) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        quoteProp: {
            type: Object,
            default() {
                return {
                    budget: 0,
                    entreposage: 0,
                    utilisation: 0,
                    association: 0,
                    vendeur: 0,
                    value: 0,
                }
            }
        }
    },
    methods: {
        formatMoney(value) {
            return (parseFloat(value)).toLocaleString('fr-CA', {
                style: 'currency',
                currency: 'CAD',
            });
        }
    }
}
</script>

<style lang="scss" scoped>
.content {
    table {
        tbody {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
        }
        tfoot {
            font-weight: bold;
        }
    }
    margin-top: 25px;
    align-items: flex-end;
    justify-content: flex-start;
    width: 100%;
    column-gap: 5px;
}
</style>
