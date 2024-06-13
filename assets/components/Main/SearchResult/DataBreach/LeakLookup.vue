<template>
    <div id="leak-lookup">
        <span>leak-lookup: </span>

        <b>
            <template v-if="leakData">{{ getBreachList() }}</template>
            <template v-else>unavailable.</template>
        </b>
    </div>
</template>

<script setup>
const props = defineProps({
    leakData: {
        type: Object,
        default: null,
    },
})

const getBreachList = () => {
    if (!props.leakData?.breach_sites) {
        return '&mdash;';
    }

    return props.leakData.breach_sites.join(', ');
}
</script>

<style scoped lang="scss">
#leak-lookup {
    border: 2px solid #B28BF1;
    padding: 15px;
}
</style>