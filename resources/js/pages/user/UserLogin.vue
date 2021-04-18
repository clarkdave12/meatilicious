<template>
    <v-app>
        <v-container class="my-5">
            <v-layout row wrap justify-center>
                <router-link to="#">
                    <v-img src="http://localhost:8000/images/defaults/yourlogo.png" max-width="300px"></v-img>
                </router-link>
                <v-flex xs6 class="my-15">
                    <p class="text-center">Our online store is safe, secure, and open 24/7</p>
                </v-flex>
            </v-layout>
            <v-layout row wrap justify-center class="my-5">
                <v-btn color="red" fab dark class="hidden-md-and-up" style="margin-right: 5px"><v-icon dark>menu</v-icon></v-btn>
                <v-btn color="red" fab dark class="hidden-md-and-up" style="margin-right: 5px"><v-icon>person</v-icon></v-btn>
                <v-btn color="red" fab dark class="hidden-md-and-up" style="margin-right: 5px"><v-icon>shopping_cart</v-icon></v-btn>
                <v-btn color="red" fab dark class="hidden-md-and-up"><v-icon>search</v-icon></v-btn>
            </v-layout>
            
            <v-layout>
                <v-flex class="hidden-sm-and-down">
                    <v-layout row wrap justify-center>
                        <v-flex sm1 md1>
                            <v-btn depressed class="red">Home</v-btn>
                        </v-flex>
                        <v-flex sm2 md2>
                            <v-btn outined block class="red">Our Products</v-btn>
                        </v-flex>
                        <v-flex sm2 md1>
                            <v-btn outined block class="red">Recipes</v-btn>
                        </v-flex>
                        <v-flex sm2 md2>
                            <v-btn outined block class="red">About Us</v-btn>
                        </v-flex>
                        <v-flex sm3 md1>
                            <v-btn outined block class="red">Retail Outlets</v-btn>
                        </v-flex>
                        <v-flex sm2 md1>
                            <v-btn outined block class="red">Business</v-btn>
                        </v-flex>
                        <v-flex sm1 md1>
                            <v-btn outined block class="red">News</v-btn>
                        </v-flex>
                        <v-flex sm1 md1>
                            <v-btn outined block class="red">FAQs</v-btn>
                        </v-flex>
                        <v-flex sm1 md1>
                            <v-btn outined block class="red">Contact Us</v-btn>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-layout>
        </v-container>
    </v-app>
</template>
