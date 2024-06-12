<template>
    <div class="main">
        <div v-if="isLoading" class="loading-overlay">
            <span class="loader"></span>
        </div>
        <div :class="'content' + (!isResultsStep ? ' align-center' : '')">
            <h1 v-if="!isResultsStep" class="header">Find all the data you need</h1>
            <div id="search">
                <form class="search-box">
                    <input id="search-field" type="text" placeholder="Enter an email or username">
                    <button id="search-button" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref} from "vue";

const isResultsStep = ref(false);
const isLoading = ref(false);
</script>

<style scoped lang="scss">
@import "Main.module";
</style>