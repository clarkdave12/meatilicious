<template>
    <v-container>
        <v-row justify="center" class="mt-16">
            <v-sheet
            elevation="3"
            width="500px"
            class="px-9 pt-5">

                <v-toolbar-title class="text-center mb-9">Add Variant</v-toolbar-title>

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
                        @click="addVariant"
                        :disabled="disableSave"
                        :loading="disableSave"
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
            disableSave: false,
            variant: {
                variant: '',
                multiplier: 0
            }
        }
    },

    methods: {
        navigate(name) {
            this.$router.push({name: name});
        },

        addVariant() {
            this.disableSave = true;
            this.$store.dispatch('variants/addVariant', this.variant)
                .then(() => {
                    this.$swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'The variant was added.'
                    });
                    this.disableSave = false;
                    this.navigate('variants');
                })
                .catch(error => {
                    console.log(error.response);
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Ooopss...',
                        text: 'There was a problem while adding the variant.'
                    });
                    this.disableSave = false;
                });
        }
    }

}
</script>
