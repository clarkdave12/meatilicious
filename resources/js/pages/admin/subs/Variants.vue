<template>
    <v-container fill-height>

        <v-layout align-center justify-center v-if="loading">
            <loader></loader>
        </v-layout>

        <v-container v-else>
            <v-row v-if="variants.length > 0">
                <v-subheader>Variant Count: 0</v-subheader>
                <v-spacer></v-spacer>
                <v-btn @click="navigate('add_variant')" outlined color="success">Add Variant</v-btn>

                <v-col cols="12" sm="12">
                    <v-simple-table
                    fixed-header
                    height="500px">
                        <thead>
                            <tr>
                                <th> Variant ID </th>
                                <th> Variant </th>
                                <th> Multiplier </th>
                                <th class="text-end"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="button" v-for="variant in variants" :key="variant.id">
                                <td> {{ variant.id }} </td>
                                <td> {{ variant.variant }} </td>
                                <td> {{ variant.multiplier }} </td>
                                <td>
                                    <v-btn @click="confirmDelete(variant)" text color="error" class="float-right"><v-icon>delete</v-icon></v-btn>
                                    <v-btn @click="updateVariant(variant)" text color="primary" class="float-right"><v-icon>edit</v-icon></v-btn>
                                </td>
                            </tr>
                        </tbody>

                    </v-simple-table>
                </v-col>
            </v-row>

            <v-container v-else>
                <v-row justify="center">
                    <v-col cols="4" class="text-center">
                        <v-img
                        class="mx-auto"
                        :src="config.baseURL + '/images/defaults/meat.png'"
                        max-height="150px"
                        max-width="150px"></v-img>
                        <v-toolbar-title class="mb-6"><h3>No Variants yet?</h3></v-toolbar-title>
                        <v-btn @click="navigate('add_variant')" block outlined color="success">Add Now</v-btn>
                    </v-col>
                </v-row>
            </v-container>

        </v-container>
    </v-container>
</template>

<script>

import Loader from '../../../components/Loader';
import { config } from '../../../config';

export default {

    components: {
        Loader,
    },

    data() {
        return {
            loading: false,
            config: config
        }
    },

    computed: {
        variants() {
            return this.$store.getters['variants/getVariants'];
        }
    },

    methods: {
        navigate(name) {
            this.$router.push({name: name});
        },

        updateVariant(variant) {
            this.$router.push({name: 'update_variant', params: { variantId: variant.id }});
        },

        confirmDelete(variant) {
            this.$swal.fire({
                icon: 'warning',
                title: 'Delete Variant?',
                text: 'You won\'t be able to undo this action.',
                showCancelButton: true,
                cancelButtonColor: '#DC143C',
                confirmButtonText: 'Yes, delete it!'
            })
            .then(result => {
                if(result.isConfirmed) {
                    this.deleteVariant(variant);
                }
            });
        },

        deleteVariant(variant) {
            this.loading = true;
            this.$store.dispatch('variants/deleteVariant', variant.id)
                .then(() => {
                    this.$store.dispatch('variants/getVariants')
                        .then(() => {
                            this.$swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: 'The variant was deleted'
                            });
                            this.loading = false;
                        })
                        .catch(error => {
                            console.log(error.response);
                            this.$swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'There was a problem while fetching the variants.'
                            });
                            this.loading = false;
                        })
                })
                .catch(error => {
                    console.log(error.repsonse);
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was a problem while deleting the variant.'
                    });
                    this.loading = false;
                });
        }
    },

    mounted() {
        this.loading = true;
        this.$store.commit('interfaces/setPage', 'Variants');
        this.$store.dispatch('variants/getVariants')
            .then(() => {
                this.loading = false;
            })
            .catch(error => {
                console.log(error.response);
                this.$swal.fire({
                    icon: 'error',
                    title: 'Ooopss...',
                    text: 'There was a problem loading the variants.'
                });
            });
    }
}
</script>
