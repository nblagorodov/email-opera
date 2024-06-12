<template>
    <div class="body">
        <Header/>
        <Main />
        <Footer/>
    </div>
</template>

<script setup>
import Main from "./components/Main/Main.vue";

``

import Header from "./components/Header/Header";
import Footer from "./components/Footer/Footer.vue";

</script>

<style lang="scss">
body, html {
    padding: 0;
    margin: 0;

    font-family: "Anonymous Pro", monospace;
    font-weight: 400;
    font-style: normal;
}

.body {
    display: flex;
    flex-direction: column;

    height: 100vh;
}
</style>