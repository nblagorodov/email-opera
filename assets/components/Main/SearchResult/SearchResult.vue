<template>
    <div id="search-results">
        <EmailRep v-if="results.type === 'email'" :email-rep-data="results.emailrep" />
        <LeakLookup :leak-data="results.leak_lookup" />
        <div id="social-networks">
            <Telegram :telegram-data="results.telegram"/>
            <VK :vk-data="results.vk"/>
        </div>
    </div>
</template>

<script setup>
import VK from "./SocialNetworks/VK.vue";
import Telegram from "./SocialNetworks/Telegram.vue";
import LeakLookup from "./DataBreach/LeakLookup.vue";
import EmailRep from "./DataBreach/EmailRep.vue";

const props = defineProps({
    results: {
        type: Object,
        required: true,
    },
});
</script>

<style lang="scss" scoped>
#search-results {
    display: flex;
    flex-direction: column;
    width: 100%;

    row-gap: 40px;
}

#social-networks {
    display: flex;
    flex-direction: row;

    box-sizing: border-box;
    border: 2px solid #B28BF1;

    width: 100%;
}

#social-networks div:first-child {
    border-right: 1px solid #B28BF1;
}

#social-networks div:last-child {
    border-left: 1px solid #B28BF1;
}

#social-networks div {
    box-sizing: border-box;
    padding: 15px;
    width: 50%;

    line-height: 25px;
}
</style>
