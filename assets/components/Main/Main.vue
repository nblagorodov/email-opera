<template>
    <div class="main">
        <div v-if="isLoading" class="loading-overlay">
            <span class="loader"></span>
        </div>
        <div :class="'content' + (!searchResult ? ' align-center' : '')">
            <h1 v-if="!searchResult" class="header">Find all the data you need</h1>

            <form id="search">
                <div class="search-box">
                    <input
                        id="search-field"
                        type="text"
                        placeholder="Enter an email or username"
                        v-model="searchString"
                    >

                    <button
                        id="search-button"
                        type="submit"
                        :disabled="!searchString"
                        @click="handleSearch"
                    >
                        Search
                    </button>
                </div>

                <div v-if="error" class="error-box">{{ error }}</div>

                <SearchResult v-if="searchResult" :results="searchResult" />
            </form>
        </div>
    </div>
</template>

<script setup>
import {reactive, ref} from "vue";
import {client} from "../../bootstrap";
import SearchResult from "./SearchResult/SearchResult";

const isLoading = ref(false);

const searchString = ref('');
let searchResult = reactive(null);

const error = ref('');

const handleSearch = async (event) => {
    event.preventDefault();

    isLoading.value = true;

    await client
        .get(`search/${searchString.value}`)
        .then(response => {
            console.log(response);
            searchResult = response.data;
            error.value = null;
        })
        .catch(response => {
            searchResult = null;
            error.value = response?.response?.data?.error;
        });

    isLoading.value = false;
}

</script>

<style scoped lang="scss">
@import "Main.module";
</style>