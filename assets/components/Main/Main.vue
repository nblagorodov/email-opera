<template>
    <div class="main">
        <div v-if="isLoading" class="loading-overlay">
            <span class="loader"></span>
        </div>
        <div :class="'content' + (!isResultsStep ? ' align-center' : '')">
            <h1 v-if="!isResultsStep" class="header">Find all the data you need</h1>
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
            </form>
        </div>
    </div>
</template>

<script setup>
import {ref} from "vue";
import {client} from "../../bootstrap";

const isResultsStep = ref(false);
const isLoading = ref(false);

const searchString = ref('');
const error = ref('');

const handleSearch = async (event) => {
    event.preventDefault();

    isLoading.value = true;

    await client
        .get(`search/${searchString.value}`)
        // .catch(error => error.value = error.response.data.error);
        .catch(response => error.value = response?.response?.data?.error);

    isLoading.value = false;

    isResultsStep.value = true;
}

</script>

<style scoped lang="scss">
@import "Main.module";
</style>