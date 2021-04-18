<template>
    <v-container>
        <v-row>
            <v-col cols="12" sm="12" md="6" class="pa-4">
                <v-toolbar-title><v-subheader>Product Info</v-subheader></v-toolbar-title>
                <v-sheet
                elevation="2"
                class="pa-3">

                    <v-text-field
                    v-model="productName"
                    outlined
                    dense
                    label="Product Name"
                    placeholder="Please enter product name"></v-text-field>

                    <v-combobox
                    v-model="selectedCategory"
                    @change="getSubCategories"
                    :items="displayCategories"
                    outlined
                    dense
                    label="Category"
                    placeholder="Please choose category for product"></v-combobox>

                    <v-combobox
                    v-model="selectedSubCategory"
                    :disabled="selectedCategory == ''"
                    :items="displaySubCategories"
                    outlined
                    dense
                    label="Sub Category"
                    placeholder="Please choose sub category for product"></v-combobox>

                </v-sheet>
            </v-col>

            <v-col cols="12" sm="12" md="6" class="pa-4">
                <v-row>
                    <v-toolbar-title><v-subheader>Prices</v-subheader></v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn @click="clearPrices" color="error" text>Clear</v-btn>
                </v-row>
                <v-sheet
                elevation="2"
                class="pa-3">
                    <v-simple-table
                    fixed-header>

                        <thead>
                            <tr>
                                <th>Price</th>
                                <th>Per</th>
                                <th>Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="price in prices" :key="price.unit.id">
                                <td>{{ price.price }}</td>
                                <td>{{ price.per }}</td>
                                <td> {{ price.unit.name }} </td>
                            </tr>
                        </tbody>

                    </v-simple-table>
                </v-sheet>
            </v-col>

        </v-row>
        <v-row>
            <v-col cols="12" sm="12" md="6" class="pa-4">
                <v-toolbar-title><v-subheader>Product Prices</v-subheader></v-toolbar-title>
                <v-sheet
                elevation="2"
                class="pa-3">

                    <v-text-field
                    v-model="productPrice.price"
                    type="number"
                    outlined
                    dense
                    label="Price"
                    placeholder="Please enter price for product"></v-text-field>

                    <v-text-field
                    v-model="productPrice.per"
                    type="per"
                    outlined
                    dense
                    label="Per"
                    placeholder="500"></v-text-field>

                    <v-combobox
                    v-model="selectedUnit"
                    :items="displayUnits"
                    outlined
                    dense
                    label="Unit"
                    placeholder="Please choose unit"></v-combobox>

                    <v-btn
                    @click="addPrice"
                    color="primary">
                        Add Price
                    </v-btn>

                </v-sheet>
            </v-col>
            <v-col cols="12" sm="12" md="6" class="pa-4">
                <v-row>
                    <v-toolbar-title><v-subheader>Product Gallery</v-subheader></v-toolbar-title>
                    <v-spacer></v-spacer>
                    <input style="display: none;" ref="imageInput" type="file" @change="onFileSelected">
                    <v-btn color="success" @click="$refs.imageInput.click()">Add Image</v-btn>
                </v-row>
                <v-row>
                    <!-- Loop this tag for product gallery -->
                    <v-col v-for="(image, index) in images" :key="index" cols="12" sm="12" md="3">
                        <v-sheet
                        elevation="2"
                        class="pa-3">
                            <v-img
                            height="100px"
                            width="100px"
                            :src="image"></v-img>
                            <v-btn @click="removeImage(index)" color="error" text>Remove</v-btn>
                        </v-sheet>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
        <v-row>
            <v-spacer></v-spacer>
            <v-btn color="secondary" outlined class="mr-6">Cancel</v-btn>
            <v-btn
            :loading="saveLoading"
            @click="addProduct"
            color="primary">
                <v-icon left>save</v-icon>
                Save
            </v-btn>
        </v-row>
    </v-container>
</template>

<script>
export default {

    data() {
        return {
            saveLoading: false,
            categories: [],
            selectedCategory: '',
            subCategories: [],
            selectedSubCategory: '',
            units: [],
            selectedUnit: '',

            productName: '',
            productPrice: {
                price: '',
                per: '',
                unit: {}
            },
            prices: [],
            images: []
        }
    },

    computed: {
        displayCategories() {
            return this.categories.map(category => {
                return category.name;
            });
        },
        getSelectedCategory() {
            let category = {};
            this.categories.map(cat => {
                if(this.selectedCategory == cat.name) {
                    category = cat;
                }
            });
            return category;
        },

        displaySubCategories() {
            return this.subCategories.map(sc => {
                return sc.name;
            });
        },
        getSelectedSubCategory() {
            let sub = {};
            this.subCategories.map(sc => {
                if(this.selectedSubCategory == sc.name) {
                    sub = sc;
                }
            });
            return sub;
        },

        displayUnits() {
            return this.units.map(unit => {
                return unit.name;
            });
        },

        getSelectedUnit() {
            let unit = {};
            this.units.map(u => {
                if(this.selectedUnit == u.name) {
                    unit = u;
                }
            });
            return unit;
        }

    },

    methods: {
        navigate(name) {
            this.$router.push({name: name});
        },

        getSubCategories() {
            this.selectedSubCategory = '';
            this.$store.dispatch('subCategories/getSubCategoriesByCategoryId', this.getSelectedCategory.id)
                .then(() => {
                    this.subCategories = this.$store.getters['subCategories/getSubCategories'];
                })
                .catch(error => {
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was an error while fetching the sub categories'
                    });
                    console.log(error.response);
                });
        },

        addPrice() {
            let price = {
                price: this.productPrice.price,
                per: this.productPrice.per,
                unit: this.getSelectedUnit
            }
            this.prices.push(price);
            this.productPrice.price = '',
            this.productPrice.per = '',
            this.selectedUnit = ''
        },

        clearPrices() {
            this.prices = [];
        },

        onFileSelected(event) {
            let img = event.target.files[0];
            let reader = new FileReader();
            reader.readAsDataURL(img);
            reader.onload = e => {
                this.images.push(e.target.result);
            }

        },

        removeImage(index) {
            let newList = [];
            for(let i = 0; i < this.images.length; i++) {
                if(index == i) {
                    continue;
                }
                newList.push(this.images[i]);
            }
            this.images = newList;
        },

        addProduct() {
            this.saveLoading = true;
            let payload = {
                name: this.productName,
                sub_category_id: this.getSelectedSubCategory.id,
                prices: this.prices,
                images: this.images
            }

            this.$store.dispatch('products/addProduct', payload)
                .then(response => {
                    this.$swal.fire({
                        icon: 'success',
                        'title': 'Added',
                        text: 'The product was added'
                    });
                    this.saveLoading = false;
                    this.navigate('products');
                })
                .catch(error => {
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was an error while adding product'
                    });
                    this.saveLoading = false;
                    console.log(error);
                    console.log(error.response);
                });
        }
    },

    mounted() {
        this.$store.commit('interfaces/setPage', 'Add Product');
        this.$store.dispatch('categories/getCategories')
            .then(() => {
                this.categories = this.$store.getters['categories/getCategories'];
            })
            .catch(error => {
                this.$swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Can\'t load the categories'
                });
                console.log(error.response);
            });

        this.$store.dispatch('units/getUnits')
            .then(() => {
                this.units = this.$store.getters['units/getUnits'];
            })
            .catch(error => {
                this.$swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Can\'t load the units'
                });
                console.log(error.response);
            })
    }

}
</script>
