<template>
    <v-container>
        <v-row justify="center" class="mt-16">
            <v-sheet
            elevation="3"
            width="500px"
            class="px-9 pt-5">

                <v-toolbar-title class="text-center mb-9">Update Variant</v-toolbar-title>

                <v-text-field
                v-model="variant.variant"
                class="mb-4"
                outlined
                dense
                label="Variant"
                placeholder="Please enter variant"></v-text-field>

                <v-text-field
                v-model="variant.multiplier"
                class="mb-4"
                outlined
                dense
                label="Multiplier"
                placeholder="Please enter price multiplier"
                type="number"></v-text-field>

                <v-row class="mb-5">
                    <v-col cols="12" sm="12" md="6">
                        <v-btn
                        @click="navigate('variants')"
                        outlined
                        block
                        color="secondary">Cancel</v-btn>
                    </v-col>
                    <v-col cols="12" sm="12" md="6">
                        <v-btn
                        @click="updateVariant"
                        :disabled="saveButton"
                        :loading="saveButton"
                        block
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
            variant: {}
        }
    },

    methods: {
        navigate(name) {
            this.$router.push({name: name});
        },

        updateVariant() {
            this.saveButton = true;
            let payload = {
                id: this.$route.params.variantId,
                data: this.variant
            }
            this.$store.dispatch('variants/updateVariant', payload)
                .then(() => {
                    this.saveButton = false;
                    this.$swal.fire({
                        icon: 'success',
                        title: 'Updated',
                        text: 'The variant is updated.'
                    });
                    this.$router.push({name: 'variants'});
                })
                .catch(error => {
                    console.log(error.response);
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Ooops..',
                        text: 'There is a problem while updating the variant.'
                    });
                    this.saveButton = false;
                });
        }
    },

    mounted() {
        this.$store.dispatch('variants/getVariant', this.$route.params.variantId)
            .then(() => {
                this.variant = this.$store.getters['variants/getVariant'];
            })
            .catch(error => {
                console.log(error.response);
                this.$swal.fire({
                    icon: 'error',
                    title: 'Ooops..',
                    text: 'There is a problem while fetching the variant.'
                });
            });
    }

}
</script>
