<template>
    <div class="main">
        <div :class="'content' + (!isResultsStep ? ' align-center' : '')">
            <h1 v-if="!isResultsStep" class="header">Find all the data you need</h1>
            <div>
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

</script>

<style scoped lang="scss">
.main {
    flex-grow: 1;
}

.content {
    display: flex;
    flex-direction: column;
    align-items: center;
    row-gap: 35px;

    box-sizing: border-box;
    padding: 45px 0;

    height: 100%;
}

.align-center {
    align-items: center;
    padding-top: 28vh;
}

.header {
    font-weight: bold;
    font-size: 30px;
    margin: 0;
}

.search-box {
    display: flex;
    flex-direction: row;
    align-items: center;

    border: 2px solid black;

    box-shadow: 0 0 50px 10px rgba(178, 139, 241, 0.15);
}

#search-field, #search-button {
    display: block;

    height: 55px;
    box-sizing: border-box;

    font-size: 20px;
    border: 0;
}

#search-field {
    width: 960px;
    padding: 15px;
}

#search-button {
    width: 95px;
    padding: 10px;
    font-weight: bold;

    border-left: 2px solid black;

    background-color: #B28BF1;
}
</style>