<template>
    <div id="leak-lookup">
        <span>leak-lookup: </span>

        <b>
            <template v-if="leakData">{{ getBreachList() ?? '&mdash;' }}</template>
            <template v-else><b>unavailable.</b></template>
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
    if (!props.leakData?.breach_sites?.length) {
        return null;
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