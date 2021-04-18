<template>
    <v-container>
        <v-row justify="center" class="mt-16">
            <v-sheet
            elevation="3"
            width="500px"
            class="px-9 pt-5">

                <v-toolbar-title class="text-center mb-9">Add Unit</v-toolbar-title>

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
                        @click="addUnit"
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
            unit: {
                name: ''
            }
        }
    },

    methods: {
        navigate(name) {
            this.$router.push({name: name});
        },

        addUnit() {
            this.saveButton = true;
            this.$store.dispatch('units/addUnit', this.unit)
                .then(() => {
                    this.saveButton = false;
                    this.$swal.fire({
                        icon: 'success',
                        title: 'Added',
                        text: 'The unit was added'
                    });

                    this.navigate('units');
                })
                .catch(error => {
                    this.saveButton = false;
                    console.log(error.response);

                    if(error.response.status == 500) {
                        this.$swal.fire({
                            icon: 'error',
                            title: '500',
                            text: 'Server Error'
                        });
                    }
                });
        }
    },

    mounted() {
        this.$store.commit('interfaces/setPage', 'Add Unit');
    }

}
</script>
