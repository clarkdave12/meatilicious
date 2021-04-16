<template>
    <v-container>
        <v-row justify="center" class="mt-16">
            <v-sheet
            elevation="3"
            width="500px"
            class="px-9 pt-5">

                <v-toolbar-title class="text-center mb-9">Add Category</v-toolbar-title>

                <v-text-field
                v-model="category.category"
                class="mb-4"
                outlined
                dense
                label="Category"
                placeholder="Please enter category name"></v-text-field>

                <v-file-input
                @change="imageChange"
                class="mb-4"
                outlined
                dense
                prepend-icon="add_photo_alternate"
                label="Image"
                placeholder="Please upload image for category"></v-file-input>

                <v-row class="mb-5">
                    <v-col cols="12" sm="12" md="6">
                        <v-btn
                        @click="goBack"
                        outlined
                        block
                        color="secondary">Cancel</v-btn>
                    </v-col>

                    <v-col cols="12" sm="12" md="6">
                        <v-btn
                        @click="addCategory"
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

import { config } from '../../../config';

export default {

    data() {
        return {
            saveButton: false,
            category: {
                category: '',
                image: '',
                base_url: ''
            }
        }
    },

    methods: {

        goBack() {
            this.$router.replace({name: 'categories'});
        },

        imageChange(e) {

            const fileReader = new FileReader();
            fileReader.readAsDataURL(e);

            fileReader.onload = (ev) => {
                this.category.image = ev.target.result;
            }
        },

        addCategory() {
            this.saveButton = true;
            this.$store.dispatch('categories/addCategory', this.category)
                .then(() => {
                    this.$swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Category added successfully.'
                    });
                    this.saveButton = false;
                    this.$router.push({name: 'categories'});
                })
                .catch(error => {
                    console.log(error.response);
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Couldn\'t add the category.'
                    });
                    this.saveButton = false;
                })
        }

    },

    mounted() {
        this.$store.commit('interfaces/setPage', 'New Category');
        this.category.base_url = config.baseURL;
    }

}
</script>
