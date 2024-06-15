<template>
    <div id="emairep">
        <span>emailrep: </span>

        <template v-if="emailRepData">
            <div><b>reputation:</b> {{ emailRepData.reputation ?? '&mdash;' }}.</div>
            <div><b>suspicious:</b> {{ emailRepData.suspicious ?? '&mdash;' }}.</div>
            <div><b>recent malicious activity:</b> {{ emailRepData.malicious_activity_recent ?? '&mdash;' }}.</div>
            <div><b>spam:</b> {{ emailRepData.spam ?? '&mdash;' }}.</div>
            <div><b>domain reputation:</b> {{ emailRepData.domain_reputation ?? '&mdash;' }}.</div>
        </template>
        <template v-else><b>unavailable.</b></template>
    </div>
</template>

<script setup>
const props = defineProps({
    emailRepData: {
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
#emairep {
    border: 2px solid #B28BF1;
    padding: 15px;
}
</style>