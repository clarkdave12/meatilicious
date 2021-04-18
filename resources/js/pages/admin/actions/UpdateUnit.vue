<template>
    <v-container>
        <v-row justify="center" class="mt-16">
            <v-sheet
            elevation="3"
            width="500px"
            class="px-9 pt-5">

                <v-toolbar-title class="text-center mb-9">Update Unit</v-toolbar-title>

                <v-text-field
                v-model="unit.name"
                class="mb-4"
                outlined
                dense
                label="Unit"
                placeholder="Please enter unit name"></v-text-field>

                <v-row class="mb-5">
                    <v-col cols="12" sm="12" md="6">
                        <v-btn
                        @click="navigate('units')"
                        outlined
                        block
                        color="secondary">Cancel</v-btn>
                    </v-col>

                    <v-col cols="12" sm="12" md="6">
                        <v-btn
                        @click="updateUnit"
                        block
                        :disabled="saveButton"
                        :loading="saveButton"
                        color="success">Save</v-btn>
                </v-col>

                </v-row>

            </v-sheet>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            saveButton: false,
            unit: {}
        }
    },

    methods: {
        navigate(name) {
            this.$router.push({name: name});
        },

        updateUnit() {
            this.saveButton = true;

            let payload = {
                id: this.$route.params.unitId,
                data: this.unit
            }

            this.$store.dispatch('units/updateUnit', payload)
                .then(() => {
                    this.saveButton = false;
                    this.$swal.fire({
                        icon: 'success',
                        title: 'Updated',
                        text: 'The unit was updated'
                    });
                    this.navigate('units');
                })
                .catch(error => {
                    this.saveButton = false;
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There is a problem'
                    });
                    console.log(error.response);
                })
        }
    },

    mounted() {
        this.$store.commit('interfaces/setPage', 'Update Unit');
        this.$store.dispatch('units/getUnit', this.$route.params.unitId)
            .then(() => {
                this.unit = this.$store.getters['units/getUnit'];
            })
            .catch(error => {
                this.$swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'There was a problem while fetching the unit'
                });
                console.log(error.response);
            });
    }
}
</script>
