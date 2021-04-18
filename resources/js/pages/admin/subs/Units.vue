<template>
    <v-container fill-height>

        <v-layout align-center justify-center v-if="loading">
            <loader></loader>
        </v-layout>

        <v-container v-else>
            <v-row v-if="units.length > 0">
                <v-subheader>Units count: {{ units.length }} </v-subheader>
                <v-spacer></v-spacer>
                <v-btn
                @click="navigate('add_unit')"
                outlined
                color="success">
                    Add Unit
                </v-btn>

                <v-col cols="12" sm="12">
                    <v-simple-table
                    fixed-header
                    height="500px">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="button" v-for="unit in units" :key="unit.id">
                                <td> {{ unit.id }} </td>
                                <td> {{ unit.name }} </td>
                                <td>
                                    <v-btn @click="confirmDelete(unit)" text color="error" class="float-right"><v-icon>delete</v-icon></v-btn>
                                    <v-btn @click="navigateParams('update_unit', unit.id)" text color="primary" class="float-right"><v-icon>edit</v-icon></v-btn>
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
                        <v-toolbar-title class="mb-6"><h3>No Units yet?</h3></v-toolbar-title>
                        <v-btn @click="navigate('add_unit')" block outlined color="success">Add Now</v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-container>

    </v-container>
</template>

<script>

import { config } from '../../../config';
import Loader from '../../../components/Loader';

export default {

    components: {
        Loader
    },

    data() {
        return {
            loading: false,
            config: config
        }
    },

    computed: {
        units() {
            return this.$store.getters['units/getUnits'];
        }
    },

    methods: {

        navigate(name) {
            this.$router.push({name: name});
        },

        navigateParams(name, params) {
            this.$router.push({name: name, params: { unitId: params }});
        },

        confirmDelete(unit) {
            this.$swal.fire({
                icon: 'warning',
                title: 'Delete Unit',
                text: 'Are you sure you want to delete this unit?',
                showCancelButton: true,
                cancelButtonColor: '#DC143C',
                confirmButtonText: 'Yes, Delete it!'
            })
            .then(result => {
                if(result.isConfirmed) {
                    this.deleteUnit(unit);
                }
            });
        },

        deleteUnit(unit) {
            this.loading = true;
            this.$store.dispatch('units/deleteUnit', unit.id)
                .then(() => {
                    this.$store.dispatch('units/getUnits')
                        .then(() => {
                            this.$swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'The unit was deleted'
                            });
                            this.loading = false;
                        })
                        .catch(error => {
                            this.$swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'There was a problem fetching the units'
                            });
                            this.loading = false;
                            console.log(error.response);
                        })
                })
                .catch(error => {
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was a problem deleting'
                    });
                    console.log(error.response);
                    this.loading = false;
                });
        }

    },

    mounted() {
        this.loading = true;
        this.$store.commit('interfaces/setPage', 'Units');
        this.$store.dispatch('units/getUnits')
            .then(() => {
                this.loading = false;
            })
            .catch(error => {
                if(error.response.status == 500) {
                    this.$swal.fire({
                        icon: 'error',
                        title: '500',
                        text: 'Server Error'
                    });
                }
                else {
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was a problem while fetching the units'
                    });
                }
            });
    }
}
</script>
