<template>
    <v-container>
        <v-row justify="center" class="mt-16">
            <v-sheet
            elevation="3"
            width="500px"
            class="px-9 pt-5">

                <v-toolbar-title class="text-center mb-9">Update Category</v-toolbar-title>

                <v-text-field
                v-model="category.name"
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
                        @click="navigate('categories')"
                        outlined
                        block
                        color="secondary">Cancel</v-btn>
                    </v-col>

                    <v-col cols="12" sm="12" md="6">
                        <v-btn
                        @click="updateCategory"
                        block
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
            category: {
                name: '',
                image: '',
                base_url: ''
            }
        }
    },

    methods: {
        navigate(name) {
            this.$router.push({name: name});
        },

        imageChange(e) {

            const fileReader = new FileReader();
            fileReader.readAsDataURL(e);

            fileReader.onload = (ev) => {
                this.category.image = ev.target.result;
            }
        },

        updateCategory() {
            let payload = {
                id: this.$route.params.categoryId,
                data: this.category
            }
            this.$store.dispatch('categories/updateCategory', payload)
                .then(() => {
                    this.$swal.fire({
                        icon: 'success',
                        title: 'Updated',
                        text: 'Category updated successfully.'
                    });
                    this.$router.replace({name: 'categories'});
                })
                .catch(error => {
                    console.log(error.response);
                    alert(error);
                })
        }
    },

    mounted() {
        this.$store.commit('interfaces/setPage', 'Update Category');
        this.category.base_url = config.baseURL;
        this.$store.dispatch('categories/getCategory', this.$route.params.categoryId)
            .then(() => {
                let cat = this.$store.getters['categories/getCategory'];
                console.log(cat);
                this.category.name = cat.name;
            })
            .catch(error => {
                console.log(error.response);
                alert('Error');
            });
    }
}
</script>
